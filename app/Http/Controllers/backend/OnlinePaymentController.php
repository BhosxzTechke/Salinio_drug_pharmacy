<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;

use Srmklive\PayPal\Services\PayPal as PayPalClient;


class OnlinePaymentController extends Controller
{
    //


// public function PaypalPayment($id)
// {
//     $provider = new PayPalClient;

//     // Load credentials from config
//     $provider->setApiCredentials(config('paypal'));

//     // Get token (forces auth handshake)
//     $paypalToken = $provider->getAccessToken();

//     // Now create the order
//     $order = [
//         "intent" => "CAPTURE",
//         "application_context" => [
//             "return_url" => route("paypal.payment.success"),
//             "cancel_url" => route("paypal.payment.cancel"),
//         ],
//         "purchase_units" => [
//             [
//                 "amount" => [
//                     "currency_code" => "USD",
//                     "value" => "100.00"
//                 ]
//             ]
//         ]
//     ];

//     $order = $provider->createOrder($order);

   
//     $url = collect($order['links'])->where('rel', 'approve')->first()['href'];
//     return redirect()->away($url);

// }



    // public function PaypalSucess(Request $request){


    //     $provider = new PayPalClient;
    //     $provider->setApiCredentials(config('paypal'));
    //     $paypalToken = $provider->getAccessToken();
    //     $provider->setAccessToken($paypalToken);


    //     $response = $provider->capturePaymentOrder($request->token);


    //     if (isset($response['status']) && $response['status'] == 'COMPLETED') {
    //         // return $response;
    //         return redirect()->route('admin.dashboard')->with('success', 'Payment is successful. Your Transaction ID is: ' . $response['id']);
    //     } else {
    //         return redirect()->route('admin.dashboard')->with('error', $response['message'] ?? 'Something went wrong.');
    //     }
    // }



    // public function PaypalCancel(){
    //     return redirect()->route('admin.dashboard')->with('error', 'You have canceled the transaction.');
    // }       



}
