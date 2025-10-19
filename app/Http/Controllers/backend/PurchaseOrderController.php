<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\delivery;
use App\Models\delivery_item;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



use Gloudemans\Shoppingcart\Facades\Cart;
use PhpOffice\PhpSpreadsheet\Worksheet\Validations;

class PurchaseOrderController extends Controller
{
    //
    public function ShowPurchaseOrder(){

        $prod = Product::all();
        $sup = Supplier::latest()->get();

        return view('PurchaseOrder.PurchaseOrder', compact('sup','prod'));
    }


    /////////// test purchase car
    public function TestPurchaseCart(){

        $test = Cart::instance('purchaseOrder')->content();

        return view('PurchaseOrder.testpurchase', compact('test'));
    }



public function SavePurchaseOrder(Request $request)
{
    try {
    
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'expected_delivery_date' => 'required|date|after_or_equal:today',
        ], [
            'supplier_id.required' => 'Please select a supplier.',
            'expected_delivery_date.after_or_equal' => 'Expected delivery date cannot be in the past.',
        ]);

        $po_number = 'PO-' . strtoupper(uniqid());

        $cart = Cart::instance('purchaseOrder')->content();


        if ($cart->isEmpty()) {
            return back()->with([
                'message' => 'Your purchase order cart is empty!',
                'alert-type' => 'warning'
            ]);
        }



        $purchase = PurchaseOrder::create([
            'po_number' => $po_number,
            'supplier_id' => $request->supplier_id,
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => 'sent',
        ]);

        foreach ($cart as $item) {
            $cost = $item->options->cost_price ?? 0;
            $selling = $item->price ?? 0;

            if ($selling <= $cost) {
                return back()->withErrors([
                    'price' => "Selling price must be greater than cost price for product: {$item->name}."
                ]);
            }

            PurchaseOrderItem::create([
                'purchase_order_id' => $purchase->id,
                'product_id'        => $item->id,
                'quantity_ordered'  => $item->qty,
                'cost_price'        => $cost,
                'line_total'        => $cost * $item->qty,
            ]);
        }

        Cart::instance('purchaseOrder')->destroy();

        return redirect()->route('purchase.order')->with([
            'message' => 'Purchase Order successfully created!',
            'alert-type' => 'success',
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel handles validation errors automatically
        throw $e;

    } catch (\Exception $e) {
        \Log::error('Purchase Order Save Error: ' . $e->getMessage());

        return back()->with([
            'message' => 'Something went wrong while saving the purchase order. Please try again.',
            'alert-type' => 'error',
        ]);
    }
}



        public function AllPurchaseOrder (){

            $PurchaseOrder = PurchaseOrder::latest()->get();

            return view('PurchaseOrder.AllPurchaseOrder', compact('PurchaseOrder'));

        }


        public function AllPendingOrder()
        {
            // Get only POs where status is still "sent" or "partially_received"
            $PendingOrder = PurchaseOrder::whereIn('status', ['sent', 'partially_received'])
                ->latest()
                ->get();

            return view('PurchaseOrder.PendingDeliveries', compact('PendingOrder'));
        }



        public function ReceivedOrderDetails($id){

            $PurchaseOrder = PurchaseOrder::findorfail($id);

            $Delivery = Delivery::where('purchase_order_id', $id)->first();

            // Get PO items and auto-generate batch numbers for each
                $PurchaseOrderItem = PurchaseOrderItem::where('purchase_order_id', $id)
                ->orderBy('id', 'DESC')
                ->get()
                ->map(function ($item) use ($id) {


            $receivedQty = delivery_item::whereHas('delivery', function ($q) use ($id) {
                $q->where('purchase_order_id', $id);
            })
            ->where('product_id', $item->product_id)
            ->sum('quantity_received');


                    // 100  received 

            // Remaining = ordered - received
            $item->remaining_qty = $item->quantity_ordered - $receivedQty;



            // Auto batch number only if stock still remaining
            if ($item->remaining_qty > 0) {
                $item->auto_batch_number = 'BATCH-' . now()->format('Ymd') . '-' . $item->product_id . '-' . strtoupper(Str::random(4));
            } else {
                $item->auto_batch_number = null;
            }

            return $item;

    });



            return view('PurchaseOrder.POdetails', compact('PurchaseOrder','PurchaseOrderItem','Delivery'));
            
        }


public function SaveOrderdeliveries(Request $request)
{
    // 1. Validate request
    $validator = Validator::make($request->all(), [
        'purchase_order_id' => 'required|exists:purchase_orders,id',
        'delivery_date' => 'nullable|date',
        'reference_number' => 'nullable|string|max:255',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity_received' => 'required|numeric|min:1',
        'items.*.cost_price' => 'required|numeric|min:0',
        'items.*.expiry_date' => 'nullable|date|after_or_equal:today',
        'items.*.batch_number' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Please correct the errors in the form.');
    }

    DB::beginTransaction();

    try {
        // 2. Create Delivery record
        $delivery = Delivery::create([
            'purchase_order_id' => $request->input('purchase_order_id'),
            'delivery_date' => $request->input('delivery_date') ?? now(),
            'reference_number' => $request->input('reference_number'),
            'remarks' => $request->input('remarks'),
        ]);

        $deliveryItems = $request->input('items');
        $po = PurchaseOrder::find($request->input('purchase_order_id'));

        foreach ($deliveryItems as $item) {


            // 3. Create DeliveryItem
            delivery_item::create([
                'delivery_id' => $delivery->id,
                'product_id' => $item['product_id'],
                'batch_number' => $item['batch_number'] ?? null,
                'expiry_date' => $item['expiry_date'] ?? null,
                'quantity_received' => $item['quantity_received'],
                'cost_price' => $item['cost_price'],
            ]);

            // 4. Update inventory (FIFO)
            $supplierId = $item['supplier_id'] ?? ($po->supplier_id ?? null);

            $inventoryRow = Inventory::where('product_id', $item['product_id'])
                ->where('supplier_id', $supplierId)
                ->where('expiry_date', $item['expiry_date'] ?? null)
                ->where('cost_price', $item['cost_price'])
                ->first();

            if ($inventoryRow) {
                $inventoryRow->increment('quantity', $item['quantity_received']);
            } else {
                Inventory::create([
                    'product_id' => $item['product_id'],
                    'supplier_id' => $supplierId,
                    'batch_number' => $item['batch_number'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'received_date' => now(),
                    'quantity' => $item['quantity_received'],
                    'cost_price' => $item['cost_price'],
                    'selling_price' => $item['selling_price'] ?? null,
                ]);
            }
        }

        // 5. Update PO status
        if ($po) {
            $totalOrdered = $po->items()->sum('quantity_ordered');
            $totalReceived = delivery_item::whereHas('delivery', function ($q) use ($po) {
                $q->where('purchase_order_id', $po->id);
            })->sum('quantity_received');

            $po->status = $totalReceived >= $totalOrdered ? 'received' : 'partially_received';
            $po->save();
        }

        DB::commit();

        return redirect()->route('deliveries.index')->with('success', 'Delivery saved and inventory updated!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to save delivery: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString()
        ]);

        return redirect()->back()->withInput()->with('error', 'Something went wrong while saving the delivery. Please try again.');
    }
}












        public function CompleteDeliveries()
        {
            $delivery = Delivery::whereHas('purchaseOrder', function ($query) {
                $query->where('status', 'received');
            })
            ->latest()
            ->get();

            return view('PurchaseOrder.deliveryHistory', compact('delivery'));
        }

}
