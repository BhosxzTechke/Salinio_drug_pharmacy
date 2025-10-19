<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Orderdetails;
use App\Models\Inventory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    //


public function viewPos()
{
    // 1. Get the active VAT rate from the 'vats' table
    $activeVat = \App\Models\Vat::where('active', true)->first();
    $vatRate = $activeVat ? $activeVat->rate : config('cart.tax', 0);


    // 2. Get cart subtotal (remove formatting)
    $totalInclusive = (float) preg_replace('/[^\d.]/', '', Cart::subtotal());

    
    // 3. Default VAT calculations (for now)
    $totalVatable = round($totalInclusive / (1 + ($vatRate / 100)), 2);
    $totalVat = round($totalInclusive - $totalVatable, 2);

    // 4. Load customers, inventory, categories
    $Customer = Customer::where('added_by_staff', 1)->latest()->get();

    $PosData = Inventory::where('quantity', '>', 0)
    ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), 'selling_price')
    ->groupBy('product_id', 'selling_price')
    ->latest()
    ->get();

    


    

    $AllCategory = Category::all();

    // 5. Check if an active discount exists
    $discounts = DB::table('discounts')->where('active', 1)->get();

    // 6. Pass all data to the view
    return view('pos.pos', compact(
        'PosData',
        'Customer',
        'totalInclusive',
        'totalVatable',
        'totalVat',
        'AllCategory',
        'vatRate',
        'discounts'
    ));
}



            public function CreateInvoiceCustomer(request $Request)
        {   

                        // Validate input
            $Request->validate([
                'customer_id' => 'required|exists:customers,id',
            ]);


            // 1. Get the active VAT rate from the 'vats' table
            $activeVat = \App\Models\Vat::where('active', true)->first();
            $vatRate = $activeVat ? $activeVat->rate : config('cart.tax', 0);


            // 2. Get cart subtotal (remove formatting)
            $totalInclusive = (float) preg_replace('/[^\d.]/', '', Cart::subtotal());

            
            // 3. Default VAT calculations (for now)
            $totalVatable = round($totalInclusive / (1 + ($vatRate / 100)), 2);
            $totalVat = round($totalInclusive - $totalVatable, 2);



            // 5. Check if an active discount exists
            $discounts = DB::table('discounts')->where('active', 1)->get();


            // ID FOR CUSTOMER AND ALL CONTENT IN THE CART
            $customer_id = $Request->customer_id;
            $Customer = Customer::where('id', $customer_id)->first();
            $CartContent = Cart::content();


            $notification = array(
                'message' => 'Invoice Created Successfully',
                'alert-type' => 'success'
            );





            return view('invoice.productInvoice',  compact(
                        'Customer',
                        'totalInclusive',
                        'totalVatable',
                        'totalVat',
                        'vatRate',
                        'discounts',
                        'CartContent'
                    ))->with($notification);
        }








        ///// Testing
        public function CartContent()
        {
            $ProductsItem = Cart::content();

            $notification = array(
                'message' => 'Cart Content Retrieved Successfully',
                'alert-type' => 'success'
            );

            return view('POS.cart', compact('ProductsItem'))->with($notification);
        }










public function ChangeQty(Request $request, $rowId)
{
    $request->validate([
        'qty' => 'required|integer|min:1',
    ]);

    // Get the cart item
    $cartItem = Cart::get($rowId);

    if (!$cartItem) {
        return back()->with([
            'message' => 'Cart item not found.',
            'alert-type' => 'error'
        ]);
    }

            // Get the total available stock for this product (all batches)
            $productId = $cartItem->options->product_id ?? null;

            $totalAvailable = Inventory::where('product_id', $productId)
                ->sum('quantity');

            // Validate against total stock
            if ($request->qty > $totalAvailable) {
                return back()->with([
                    'message' => 'Insufficient stock available across all batches.',
                    'alert-type' => 'error'
                ]);
            }



    // Update cart qty
    Cart::update($rowId, $request->qty);

    
    return back()->with([
        'message' => 'Quantity Updated Successfully',
        'alert-type' => 'success'
    ]);
}




        public function RemoveProduct($rowId)
        {
            Cart::remove($rowId);

            $notification = array(
                'message' => 'Product Removed Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }



        // ADD INVOICE FOR CUSTOMER





public function AddPos(Request $request)
{
    // Get product info
    $product = Product::find($request->id);

    if (!$product) {
        return redirect()->back()->with([
            'message' => 'Product not found',
            'alert-type' => 'error'
        ]);
    }

                // Decide sorting method: FEFO for items with expiration, FIFO for others
                $query = Inventory::where('product_id', $product->id)
                    ->where('quantity', '>', 0);

                if ($product->has_expiration) {
                    // FEFO: sort by soonest expiration date
                    $query->whereDate('expiry_date', '>', now()) // skip expired batches
                        ->orderBy('expiry_date', 'asc');
                } else {
                    // FIFO: sort by date received or created
                    $query->orderBy('created_at', 'asc');
                }

    $inventoryItem = $query->first();

    if (!$inventoryItem) {
        return redirect()->back()->with([
            'message' => 'Product out of stock or expired',
            'alert-type' => 'error'
        ]);
    }

    // Check if requested quantity exceeds available
    if ($request->qty > $inventoryItem->quantity) {
        return redirect()->back()->with([
            'message' => 'Not enough stock available',
            'alert-type' => 'error'
        ]);
    }

    // Add to cart
    Cart::add([
        'id' => $inventoryItem->id, // Inventory batch ID
        'name' => $inventoryItem->product->product_name ?? 'Unnamed Product',
        'qty' => $request->qty,
        'price' => $inventoryItem->product->selling_price ?? 0,
        'weight' => 20,
        'options' => [
            'image' => $inventoryItem->product->image,
            'product_id' => $inventoryItem->product_id,
            'expiration_date' => $inventoryItem->expiry_date,
        ]
    ]);

    $notification = [
        'message' => 'Product added successfully!',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}




            ////////////////////////////      POS WALK IN  ///////////////////////////////


public function PaymentWalkin(Request $request)
{
            $request->validate([
                'discount' => 'nullable|numeric',
                'pay' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',

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
            'customer_id'      => null, // Walk-in
            'order_date'       => Carbon::now(),
            'order_status'     => 'complete',
            'order_type'     => 'In-Store',
            'total_products'   => Cart::count(),
            'sub_total'        => $subTotal,
            'vat'              => $request->vat,
            'vat_status'       => $request->vat_status,
            'invoice_no'       => 'INV-' . mt_rand(100000, 999999),
            'total'            => $total,
            'payment_status'   => 'paid',
            'payment_method'   => $request->payment_method,
            'pay'              => $pay,
            'due'              => $due < 0 ? abs($due) : 0,
            'discount'         => $discount,
            'change_amount'    => $due > 0 ? $due : 0,
            'created_by'       => auth()->id(),
        ]);

        //  Loop through cart and create OrderDetails
        foreach (Cart::content() as $item) {

            // Create empty order detail first (we’ll update with batch & profit after)
            $orderDetail = Orderdetails::create([
                'order_id'   => $order->id,
                'product_id' => $item->options->product_id,
                'quantity'   => $item->qty,
                'unitcost'   => 0, // will update after FIFO
                'total'      => $item->qty * $item->price,
                'batch_number' => null,
                'profit'     => 0,
            ]);

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





            public function confirm($id)
        {
            $order = Order::findOrFail($id);

            return view('POS.confirm', compact('order'));
        }



    public function Receipt($id)
            {
                // Get order
                $order = Order::with('OrderDetails.product')->findOrFail($id);

                return view('pos.receipt', compact('order'));
            }

        }




