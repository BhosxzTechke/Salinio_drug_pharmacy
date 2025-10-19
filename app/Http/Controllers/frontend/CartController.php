<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Inventory;
use PDO;

class CartController extends Controller
{
    //







public function EcommerceAddCart(Request $request)
{
    
            $inventoryItem = Inventory::where('product_id', $request->id)
                        ->where('quantity', '>', 0)
                        ->orderBy('created_at') // FIFO
                        ->first();

                    if (!$inventoryItem) {
                        return redirect()->back()->with([
                            'message' => 'Product out of stock',
                            'alert-type' => 'error'
                        ]);
                    }

                    Cart::instance('ecommerce')->add([
                        'id' => $inventoryItem->id,  // Use actual inventory row ID
                        'name' => $inventoryItem->product->product_name ?? 'Unnamed Product',
                        'qty' => $request->qty,
                        'price' => $inventoryItem->product->selling_price ?? 'Price',
                        'weight' => 20,
                        'options' => [
                            'image' => $request->product_image,
                            'product_id' => $inventoryItem->product_id, // keep original product_id
                        ]
                    ]);


            $notification = array(
                'message' => 'Product Added Successfully',
                'alert-type' => 'success'
            );

    return redirect()->back()->with($notification);
}






    public function EcommerceChangeQty(Request $request, $rowId)
    {
    $cartItem = Cart::instance('ecommerce')->get($rowId);

    if (!$cartItem) {
        return back()->with('error', 'Item not found in cart.');
    }

    $qty = $cartItem->qty;

    if ($request->action === 'increase') {
        $qty++;
    } elseif ($request->action === 'decrease' && $qty > 1) {
        $qty--;
    } elseif ($request->has('qty')) {
        $qty = max(1, (int) $request->qty); // manual input
    }

    Cart::instance('ecommerce')->update($rowId, $qty);

    return back()->with('success', 'Cart updated.');
    }




    /// for testing
   public function CartContent(Request $Request)
        {

              // ID FOR CUSTOMER AND ALL CONTENT IN THE CART
           $customer_id = $Request->customer_id;
           $Customer = Customer::where('id', $customer_id)->first();
           $products = Cart::instance('ecommerce')->content();  // Customer's cart

            $notification = array(
                'message' => 'Cart Content Retrieved Successfully',
                'alert-type' => 'success'
            );

            return view('Ecommerce.EcommercePage.carting', compact('products','Customer'))->with($notification);
        }





     public function RemoveEcommProduct($rowId)
        {
            Cart::instance('ecommerce')->remove($rowId);

            $notification = array(
                'message' => 'Product Removed Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }
                


 



}