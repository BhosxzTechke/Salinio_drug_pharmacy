<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Orderdetails;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
/**
 * Class User
 *
 * @method \Spatie\Permission\PermissionRegistrar getRoleNames()
 * @method \Spatie\Permission\Traits\HasRoles hasRole(string $role)
 * @mixin \Spatie\Permission\Traits\HasRoles
 */

    


    //
    public function FinalInvoice(Request $request){

        {
            $request->validate([
                'discount' => 'nullable|numeric',
                'pay' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'reference' => [
                    'nullable',
                    'regex:/^[0-9]{13}$/',
                    'required_if:payment_method,gcash',
                ],
            ]);



    if ($request->pay < $request->total) {
        return back()->with([
            'message' => 'The payment amount must be greater than or equal to the total due.',
            'alert-type' => 'error'
        ]);
    }

    $total = $request->total;
    $pay = $request->pay;
    $discount = $request->discount ?? 0;
    $due = $pay - $total;
    $subTotal = $total - $request->vat;

    DB::beginTransaction();

    try {
        //  Create Order
        $order = Order::create([
            'order_source'     => 'POS',
            'customer_id'      => $request->customer_id,
            'order_date'       => Carbon::now(),
            'order_status'     => 'pending',
            'order_type'     => 'Pickup',
            'total_products'   => Cart::count(),
            'sub_total'        => $subTotal,
            'vat'              => $request->vat,
            'vat_status'       => $request->vat_status,
            'invoice_no'       => 'INV-' . mt_rand(100000, 999999),
            'total'            => $total,
            'payment_status'   => 'paid',
            'reference_number' => $request->reference,
            'payment_method'   => $request->payment_method,
            'pay'              => $pay,
            'due'              => $due < 0 ? abs($due) : 0,
            'discount'         => $discount,
            'change_amount'    => $due > 0 ? $due : 0,
            'created_by'       => auth()->id(),
        ]);

        //  Loop through cart and create OrderDetails
        foreach (Cart::content() as $item) {

            // // Create empty order detail first (we’ll update with batch & profit after)
            // $orderDetail = Orderdetails::create([
            //     'order_id'   => $order->id,
            //     'product_id' => $item->options->product_id,
            //     'quantity'   => $item->qty,
            //     'unitcost'   => 0, // will update after FIFO
            //     'total'      => $item->qty * $item->price,
            //     'batch_number' => null,
            //     'profit'     => 0,
            // ]);

            $quantityToSell = $item->qty;
            $sellingPrice = $item->price;



            


                    $product = Product::find($item->options->product_id);

                    // FEFO (for medicines with expiration)
                    // FIFO (for non-expiring products)


                    
                    if ($product && $product->has_expiration) {
                        // FEFO - First Expired, First Out
                        $batches = Inventory::where('product_id', $item->options->product_id)
                            ->where('quantity', '>', 0)
                            ->whereNotNull('expiry_date')
                            ->orderBy('expiry_date', 'asc')
                            ->get();


                            
                    } else {
                        // FIFO - First In, First Out
                        $batches = Inventory::where('product_id', $item->options->product_id)
                            ->where('quantity', '>', 0)
                            ->orderBy('received_date', 'asc')
                            ->get();
                    }


                    


            foreach ($batches as $batch) {
                if ($quantityToSell <= 0) break;

                

                $deduct = min($batch->quantity, $quantityToSell);

                // Deduct stock
                $batch->decrement('quantity', $deduct);


                // Calculate profit
                $unitCost = $batch->cost_price;
                $profit = ($sellingPrice - $unitCost) * $deduct;


                // Update order detail for this batch (if multiple batches, you can optionally split into multiple order_details rows)

                    //  Create a new order_detail per batch
                    Orderdetails::create([
                        'order_id'      => $order->id,
                        'product_id'    => $item->options['product_id'],
                        'quantity'      => $deduct,
                        'unitcost'      => $unitCost,
                        'total'         => $deduct * $sellingPrice,
                        'batch_number'  => $batch->batch_number,
                        'profit'        => $profit,
                    ]);

                $quantityToSell -= $deduct;
            }

            if ($quantityToSell > 0) {
                throw new \Exception("Not enough stock for product: {$item->name}");
            }
        }

        // Clear cart
        Cart::destroy();

        DB::commit();

        return response()->json([
            'success' => true,
            'order_id' => $order->id
        ]);

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Something went wrong: '.$e->getMessage());
            }
        }

    }





    
        public function ShowPickupInvoice($order_id)
                {
                    $order = Order::with('customer', 'orderDetails.product')->findOrFail($order_id);
                    return view('invoice.pickupInvoice', compact('order'));
                }




    

    public function PendingPickup() {

        $Orders = order::where('order_type', 'Pickup')
            ->where('order_status', 'pending')
            ->latest()
            ->get();

        return view('Order.PickupOrder.pending', compact('Orders'));

    }




 public function ajaxPickupComplete(Request $request)
{
    $order = Order::findOrFail($request->id);
    $order->order_status = 'complete';
    $order->shipped_at = now();
    $order->shipped_by = auth()->id(); // or use a specific admin ID
    $order->save();

    return response()->json(['success' => true, 'message' => 'Order marked as Complete.']);
}



    public function CompletePickup() {

        $Orders = order::where('order_type', 'Pickup')
            ->where('order_status', 'complete')
            ->latest()
            ->get();

        return view('Order.PickupOrder.complete', compact('Orders'));

    }






    
    public function Receipt($id)
            {
                // Get order
                $order = Order::with('OrderDetails.product')->findOrFail($id);

                return view('pos.receipt', compact('order'));
            }





    public function PendingOrders() {

        $Orders = order::where('order_status','pending')->latest()->get();

        return view('Order.pending', compact('Orders'));
        

    }



    //// SHOW DETAILS ONLY
    public function Details($order_id) {



        $OrderDetails = Orderdetails::where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        // Fetch the order to display its details

        // You can also use findOrFail to handle cases where the order does not exist
        $Order = Order::findOrFail($order_id);


        return view('Order.Details.ShowDetails', compact('OrderDetails', 'Order'));

    }


    //// SHOW DETAILS AND COMPLETE ORDER BUTTON
    public function CompleteDetailsOrder($order_id) {



        $OrderDetails = Orderdetails::where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        // Fetch the order to display its details

        // You can also use findOrFail to handle cases where the order does not exist
        $Order = Order::findOrFail($order_id);


        return view('Order.Details.CompleteDetails', compact('OrderDetails', 'Order'));

    }


    // Update the status of an order and Subtract the product quantity from stock
    public function StatusUpdate(Request $request) {

        // Validate the request data
        $request->validate([
            'id' => 'required|exists:orders,id',
            'order_status' => 'required|string|max:255',
        ]);

        // Find the order by ID and update its status
        $order = Order::findOrFail($request->id);


        // MINUS THE QUANTITY OF THE PRODUCT IN THE STOCK
        $products = Orderdetails::where('order_id', $order->id)->get();
        // kumbaga titingnan niya ung order id is same sa id nato


        // then i loloop niya ung products 

        foreach ($products as $inventory) {
            // Update the product stock based on the quantity ordered
            $InventproductModel = Inventory::findOrFail($inventory->product_id);

            
            // BALI TITINGNAN NIA SA PRODUCT MODEL KUNG MAY MATCH SA PRODUCT ID
            $InventproductModel->decrement('quantity', $inventory->quantity);

        }


         // Update the order status Complete
        $order->order_status = $request->order_status; 
        $order->save();


         $notification = array(
                'message' => 'Invoice Created Successfully',
                'alert-type' => 'success'
            );


        // Redirect back with a success message
        return redirect()->route('pending.order')->with($notification);
    }




    /////////////////// INVENTORY MANAGEMENT //////////////////////
    public function ShowStock(){

    $product = Product::latest()->get();
    return view('Inventory.stocks',compact('product'));

    }


public function ajaxMarkAsShipped(Request $request)
{
    $order = Order::findOrFail($request->id);
    $order->order_status = 'shipped';
    $order->shipped_at = now();
    $order->shipped_by = auth()->id(); // or use a specific admin ID
    $order->save();

    return response()->json(['success' => true, 'message' => 'Order marked as Shipped.']);
}







public function ajaxMarkAsCancelled(Request $request)
{

    $order = Order::findOrFail($request->id);
    $user  = auth('web')->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    
    $order->update([
        'order_status'       => 'cancelled',
        'cancelled_at'       => now(),
        'cancelled_by'       => $user->id,
        'cancel_reason' => $request->cancel_reason ?? 'No reason provided',
    ]);

    return response()->json(['success' => true, 'message' => 'Order cancelled.']);
}



    public function AllShippedOrders() {
        $Orders = Order::where('order_status','shipped')->get();

        return view('Order.Shipped', compact('Orders'));
    }



    public function AllCancelOrders() {
        $Orders = order::where('order_status','cancelled')->get();

        return view('Order.cancelled', compact('Orders'));
    }




    public function CompleteOrders() {
        $Orders = order::where('order_status','complete')->get();

        return view('Order.complete', compact('Orders'));
    }


    public function CreatePDF($id) {
        $order = Order::findOrFail($id);
        $orderDetails = Orderdetails::where('order_id', $id)->get();

        // Generate PDF using a library like Dompdf or Snappy
        // For example, using Dompdf:
        $pdf = PDF::loadView('Order.invoice_template', compact('order', 'orderDetails'));

        // Return the generated PDF as a response
        return $pdf->download('invoice_' . $order->invoice_no . '.pdf');
    }



    


}