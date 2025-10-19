<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\Orderdetails;
use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
 //



        public function EcommercePayment() {

        if (Cart::instance('ecommerce')->count() === 0) {
        return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }


        $vatRate = config('cart.tax'); // e.g., 12
        $totalInclusive = (float) str_replace(',', '', Cart::instance('ecommerce')->subtotal());
        $totalVatable = round($totalInclusive / (1 + ($vatRate / 100)), 2);
        $totalVat = round($totalInclusive - $totalVatable, 2);


        // if authenticate 
        $Customer = Auth::guard('customer')->user();
        $addresses = $Customer ? $Customer->addresses : collect();

        return view('Ecommerce.payment.checkout', compact('totalInclusive', 'totalVatable', 'totalVat','addresses','Customer'));


        }




//         public function EcommerceCheckout(Request $request) {




//         // Create a new order
//         $order = Order::create([
//         'customer_id' => $request->customer_id,
//         'order_source' => 'ECOM',
//         'order_date' => Carbon::parse($request->order_date),
//         'order_status' => $request->order_status,  // e.g., 'pending', 'completed'
//         'total_products' => $request->total_products,
//         'sub_total' => floatval(str_replace(',', '', Cart::instance('ecommerce')->subtotal())),
//         'vat'       => floatval(str_replace(',', '', Cart::instance('ecommerce')->tax())),
//         'invoice_no' => 'SdPrime' . mt_rand(10000000, 99999999), // Generate a random invoice number
//         'total'     => floatval(str_replace(',', '', Cart::instance('ecommerce')->total())),
//         'payment_status' => $request->payment_status ?? 'pending', // Default to 'pending' if not provided
//         'pay' => $request->pay,
//         'due' => $request->due,
//         'payment_method' => $request->payment_method,
//         'shipping_address_id' => $request->shipping_address_id, 
//         'created_at' => now(),

//         ]);


//         // Loop through the cart items and create order details
//         foreach (Cart::instance('ecommerce')->content() as $item) {
//         Orderdetails::create([
//         'order_id' => $order->id,
//         'product_id' => $item->id,
//         'quantity' => $item->qty,
//         'price' => $item->price,
//         'options' => json_encode($item->options),
//         ]);
//         }



//         if ($request->payment_method === 'paypal') {
// // Use PayPal client
//                 $provider = new PayPalClient;
//                 $provider->setApiCredentials(config('paypal'));
//                 $paypalToken = $provider->getAccessToken();

//                         $order = $provider->createOrder([
//                         "intent" => "CAPTURE",
//                         "application_context" => [
//                         "return_url" => route("paypal.success", $order->id), // pass order ID
//                         "cancel_url" => route("paypal.payment.cancel", $order->id),
//                         ],
//                         "purchase_units" => [
//                         [
//                         "amount" => [
//                         "currency_code" => "USD",
//                         "value" => floatval(str_replace(',', '', Cart::instance('ecommerce')->total())), // total from cart
//                         ]
//                         ]
//                 ]
//                 ]);

//                 // dd($order);

//                 // Redirect customer to PayPal approval page
//                 foreach ($order['links'] as $link) {
//                 if ($link['rel'] === 'approve') {
//                 return redirect()->away($link['href']);
//                 }
//                 }

//                 return back()->with('error', 'Something went wrong with PayPal.');
//                 }



                
//                 // $order->decrement('quantity', $item->qty);


//                 // ///
//                 // Clear the cart after creating the order

//                 Cart::instance('ecommerce')->destroy();

//                 // $order = Order::with('items.product')->findOrFail(session('order'));

//                 // return redirect()->route('success.order', compact('order'));

//                 return redirect()
//                 ->route('success.order', $order->id)
//                 ->with('success', 'Payment successful!');
// }






// public function EcommerceCheckout(Request $request) { 

//         if ($request->pay < $request->total) {
//                 return back()->with([
//                 'message' => 'The payment amount must be greater than or equal to the total due.',
//                 'alert-type' => 'error'
//                 ]);
//         }

//         $total = $request->total;
//         $pay = $request->pay;
//         $discount = $request->discount ?? 0;
//         $due = $pay - $total;
//         $subTotal = $total - $request->vat;

//         DB::beginTransaction();

//         try {
//                 //  Create Order
//                 $order = Order::create([


//                 'customer_id' => $request->customer_id,
//                 'order_source' => 'ECOM',
//                 'order_type'     => 'Delivery',
//                 'order_date' => Carbon::parse($request->order_date),
//                 'order_status' => $request->order_status,  // e.g., 'pending', 'completed'
//                 'total_products' => $request->total_products,
//                 'sub_total' => floatval(str_replace(',', '', Cart::instance('ecommerce')->subtotal())),
//                 'vat'       => floatval(str_replace(',', '', Cart::instance('ecommerce')->tax())),
//                 'invoice_no' => 'SdPrime' . mt_rand(10000000, 99999999), // Generate a random invoice number
//                 'total'     => floatval(str_replace(',', '', Cart::instance('ecommerce')->total())),
//                 'payment_status' => $request->payment_status ?? 'pending', // Default to 'pending' if not provided
//                 'pay' => $request->pay,
//                 'due' => $request->due,
//                 'payment_method' => $request->payment_method,
//                 'shipping_address_id' => $request->shipping_address_id, 
//                 'created_at' => now(),



//                 ]);




//         //  Loop through cart and create OrderDetails
//         foreach (Cart::content() as $item) {

//         // Create empty order detail first (we’ll update with batch & profit after)
//         $orderDetail = Orderdetails::create([
//         'order_id'   => $order->id,
//         'product_id' => $item->options->product_id,
//         'quantity'   => $item->qty,
//         'unitcost'   => 0, // will update after FIFO
//         'total'      => $item->qty * $item->price,
//         'batch_number' => null,
//         'profit'     => 0,
//         ]);



//         if ($request->payment_method === 'paypal') {
//                 // Use PayPal client
//                 $provider = new PayPalClient;
//                 $provider->setApiCredentials(config('paypal'));
//                 $paypalToken = $provider->getAccessToken();

//                         $order = $provider->createOrder([
//                         "intent" => "CAPTURE",
//                         "application_context" => [
//                         "return_url" => route("paypal.success", $order->id), // pass order ID
//                         "cancel_url" => route("paypal.payment.cancel", $order->id),
//                         ],
//                         "purchase_units" => [
//                         [
//                         "amount" => [
//                         "currency_code" => "USD",
//                         "value" => floatval(str_replace(',', '', Cart::instance('ecommerce')->total())), // total from cart
//                         ]
//                         ]
//                 ]
//                 ]);

//                 // dd($order);

//                 // Redirect customer to PayPal approval page
//                 foreach ($order['links'] as $link) {
//                 if ($link['rel'] === 'approve') {
//                 return redirect()->away($link['href']);
//                 }
//                 }

// return back()->with('error', 'Something went wrong with PayPal.');
// }



//                 $quantityToSell = $item->qty;
//                 $sellingPrice = $item->price;



//             //  Deduct stock using FIFO
//         $batches = Inventory::where('product_id', $item->options->product_id)
//                                 ->where('quantity', '>', 0)
//                                 ->orderBy('received_date', 'asc')
//                                 ->get();


//         foreach ($batches as $batch) {
//                 if ($quantityToSell <= 0) break;

                

//                 $deduct = min($batch->quantity, $quantityToSell);

//                 // Deduct stock
//                 $batch->decrement('quantity', $deduct);


//                 // Calculate profit
//                 $unitCost = $batch->cost_price;
//                 $profit = ($sellingPrice - $unitCost) * $deduct;


//                 // Update order detail for this batch (if multiple batches, you can optionally split into multiple order_details rows)

//                     //  Create a new order_detail per batch
//                 Orderdetails::create([
//                         'order_id'      => $order->id,
//                         'product_id'    => $item->options['product_id'],
//                         'quantity'      => $deduct,
//                         'unitcost'      => $unitCost,
//                         'total'         => $deduct * $sellingPrice,
//                         'batch_number'  => $batch->batch_number,
//                         'profit'        => $profit,
//                 ]);

//         $quantityToSell -= $deduct;
//         }

//         if ($quantityToSell > 0) {
//         throw new \Exception("Not enough stock for product: {$item->name}");
//         }
// }

//         // Clear cart
//         Cart::instance('ecommerce')->destroy();

//         DB::commit();

//                 // return response()->json([
//                 // 'success' => true,
//                 // 'order_id' => $order->id
//                 // ]);


//                 $order = Order::with('items.product')->findOrFail(session('order'));

//                 return redirect()->route('success.order', compact('order'));

//                 return redirect()
//                 ->route('success.order', $order->id)
//                 ->with('success', 'Payment successful!');




//         } catch (\Exception $e) {
//                 DB::rollBack();
//                 return back()->with('error', 'Something went wrong: '.$e->getMessage());
//         }
// }





        public function EcommerceCheckout(Request $request)
                                {
                                if ($request->pay < $request->total) {
                                        return back()->with([
                                        'message' => 'The payment amount must be greater than or equal to the total due.',
                                        'alert-type' => 'error'
                                        ]);
                                }

                                $cartInstance = Cart::instance('ecommerce');
                                $cartTotal = floatval(str_replace(',', '', $cartInstance->total()));
                                $subTotal = floatval(str_replace(',', '', $cartInstance->subtotal()));
                                $vat = floatval(str_replace(',', '', $cartInstance->tax()));
                                $due = $request->pay - $cartTotal;

                                // If PayPal, redirect to PayPal approval before committing order
                                if ($request->payment_method === 'paypal') {
                                        $provider = new PayPalClient;
                                        $provider->setApiCredentials(config('paypal'));
                                        $token = $provider->getAccessToken();
                                        $provider->setAccessToken($token);

                                        $paypalOrder = $provider->createOrder([
                                        "intent" => "CAPTURE",
                                        "application_context" => [
                                                "return_url" => route("paypal.success"),
                                                "cancel_url" => route("paypal.cancel"),
                                        ],
                                        "purchase_units" => [
                                                [
                                                "amount" => [
                                                        "currency_code" => "USD",
                                                        "value" => number_format($cartTotal, 2, '.', ''),
                                                ]
                                                ]
                                        ]
                                        ]);

                                        /////// if approve na then dadalin na sa checkout page

                                        foreach ($paypalOrder['links'] as $link) {
                                        if ($link['rel'] === 'approve') {
                                                // Save temp checkout data in session (or DB if more secure)
                                                session([
                                                'checkout_data' => $request->all()
                                                ]);

                                                return redirect()->away($link['href']);
                                        }
                                        }

                                        return back()->with('error', 'Unable to initiate PayPal payment.');
                                }

                                // If not PayPal, proceed with direct checkout
                                return $this->processOrder($request);
}






                /////////// ITO UNG KUKUHA NG URL
                public function paypalSuccess(Request $request)
                {
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $token = $provider->getAccessToken();
                $provider->setAccessToken($token);

                $paypalOrderId = $request->get('token');
                $result = $provider->capturePaymentOrder($paypalOrderId);

                if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                        // Retrieve original request data
                        $requestData = session('checkout_data');
                        $request = new Request($requestData);
                        $request->merge([
                        'payment_status' => 'paid',
                        'payment_method' => 'paypal',
                        ]);

                        return $this->processOrder($request);
                }

                return redirect()->route('cart.checkout')->with('error', 'Payment was not successful.');
                }





private function processOrder(Request $request)
{
DB::beginTransaction();

try {
$cartInstance = Cart::instance('ecommerce');
$cartTotal = floatval(str_replace(',', '', $cartInstance->total()));
$subTotal = floatval(str_replace(',', '', $cartInstance->subtotal()));
$vat = floatval(str_replace(',', '', $cartInstance->tax()));
$pay = $request->pay;
$due = $pay - $cartTotal;

$order = Order::create([
        'customer_id' => $request->customer_id,
        'order_source' => 'ECOM',
        'order_type' => 'Delivery',
        'order_date' => Carbon::parse($request->order_date),
        'order_status' => $request->order_status,
        'total_products' => $request->total_products,
        'sub_total' => $subTotal,
        'vat' => $vat,
        'invoice_no' => 'SdPrime' . mt_rand(10000000, 99999999),
        'total' => $cartTotal,
        'payment_status' => $request->payment_status ?? 'pending',
        'pay' => $pay,
        'due' => $due,
        'payment_method' => $request->payment_method,
        'shipping_address_id' => $request->shipping_address_id,
        'created_at' => now(),
]);

foreach ($cartInstance->content() as $item) {
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
        $batch->decrement('quantity', $deduct);

        $unitCost = $batch->cost_price;
        $profit = ($sellingPrice - $unitCost) * $deduct;

        Orderdetails::create([
                'order_id' => $order->id,
                'product_id' => $item->options['product_id'],
                'quantity' => $deduct,
                'unitcost' => $unitCost,
                'total' => $deduct * $sellingPrice,
                'batch_number' => $batch->batch_number,
                'profit' => $profit,
        ]);

        $quantityToSell -= $deduct;
        }

            if ($quantityToSell > 0) {
                throw new \Exception("Not enough stock for product: {$item->name}");
            }
        }

        Cart::instance('ecommerce')->destroy();

        DB::commit();

        return redirect()
            ->route('success.order', $order->id)
            ->with('success', 'Order completed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}






        public function successPaypal($id)
        {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        $total = $order->total; // Access total directly from the order model
        $OrderNumber = $order->id;

        return view('Ecommerce.payment.success', compact('order', 'total', 'OrderNumber'));
        }


        //// Cash success payment
        public function SuccesfullyOrder($id)
        {

        $order = Order::with('orderDetails.product')->findOrFail($id);     
        $total = $order->total; // Access total directly from the order model
        $OrderNumber = $order->id;

        return view('Ecommerce.payment.success', compact('order', 'total', 'OrderNumber'));


        }





        public function CancelOrder() {
        return view('Ecommerce.payment.cancel');
        }



        //////////// CHANGE ADRESS ///////////////
        public function updateAddress(Request $request)
        {
        $customer = Auth::guard('customer')->user();

        // Case 1: Selected an existing saved address

        /// if pumindot ka sa combobox 
        if ($request->filled('saved_address')) {
        $address = Address::where('customer_id', $customer->id)
        ->find($request->saved_address);

        if ($address) {

        session([
        'shipping_address_id' => $address->id,
        'shipping_address_temp' => null // clear temporary if existed na
        ]);
        }
        }




        // Case 2: Entered a new address manually
        elseif ($request->filled('new_address')) {
        if ($request->save_to_profile) {
        // Save permanently to DB
        $newAddress = Address::create([
        'customer_id' => $customer->id,
        'full_address' => $request->new_address,
        'is_default' => false,
        ]);

        session(['shipping_address_id' => $newAddress->id,
        'shipping_address_temp' => null, // clear temp
        ]);



        } else {
        // Store TEMPORARY address in session only
        session(['shipping_address_temp' => [
        'full_address' => $request->new_address,
        'customer_id' => $customer->id
        ]]);
        }
        }

        return redirect()->back()->with([
        'message' => 'Shipping address updated',
        'alert-type' => 'success'
        ]);
}


///////////// AJAX CANCEL ORDER IN HISTORY /////////////

        public function ajaxMarkAsCancelled(Request $request)
        {
                if (!$request->ajax()) {
                        return response()->json(['error' => 'Invalid request'], 400);
                }

                $user = auth('customer')->user();
                if (!$user) {
                        return response()->json(['error' => 'Unauthorized'], 401);
                }

                $order = Order::findOrFail($request->id);

                // Prevent cancelling if already shipped or cancelled
                if ($order->order_status === 'shipped') {
                        return response()->json(['error' => 'Order has already been shipped and cannot be cancelled'], 400);
                }
                
                if ($order->order_status === 'cancelled') {
                        return response()->json(['error' => 'Order is already cancelled'], 400);
                }

                // Only allow cancelling if status is 'pending' or 'processing'
                if (!in_array($order->order_status, ['pending', 'processing'])) {
                        return response()->json(['error' => 'Only pending or processing orders can be cancelled'], 400);
                }

                $order->order_status = 'cancelled';
                $order->save();

                return response()->json(['success' => true, 'message' => 'Order cancelled.']);
        }
}