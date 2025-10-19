<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\HeroSlider;    
use App\Models\Order;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Orderdetails;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\Brand;

class FrontendController extends Controller



{

        public function index()
        {
            $categories = Category::latest()->take(6)->get();
            $HeroSlider = HeroSlider::where('is_active', 1)->get();
            $brand = Brand::all();




            //// /FIFO TRACKING
                $inventory = Inventory::where('quantity', '>', 10)
                ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), 'selling_price')
                ->groupBy('product_id', 'selling_price')
                ->latest()->take(8)->inRandomOrder()->get();


            $bestSellers = $inventory
                ->groupBy('product_id')
                ->map(function ($group) {
                    // Sum sold_count from all inventory rows under the same product_id
                    $totalSold = $group->sum(function ($item) {
                        return $item->orderDetails->sum('quantity');
                    });

                    // Pick the first inventory item for display (e.g., price)
                    $first = $group->first();
                    $first->sold_count = $totalSold;

                    return $first;
                })
                ->sortByDesc('sold_count')
                ->take(4)
                ->values();



            
            $newArrivals = Inventory::latest()->take(6)->get();



            // If logged in as customer → show customer dashboard
            if (Auth::guard('customer')->check()) {
                return view('Ecommerce.CustomerDashboard', compact('categories', 'newArrivals', 'bestSellers', 'HeroSlider', 'inventory', 'brand'));
            }

            // If not logged in → fallback to home
            return view('Ecommerce.home', compact('categories', 'newArrivals', 'bestSellers', 'HeroSlider','inventory', 'brand'));
        }


    


    public function ProductDetails($product_id)
    {
        $inventory = Inventory::with('product')->where('product_id', $product_id)->firstOrFail();

        
        return view('Ecommerce.product_detail', compact('inventory'));
    }




    public function VatEcomm(){
        
    }





    public function CartShow()
    {

       $vatRate = config('cart.tax'); // e.g., 12
        $subtotal = (float) str_replace(',', '', Cart::instance('ecommerce')->subtotal());
        $totalVatable = round($subtotal / (1 + ($vatRate / 100)), 2);
        $totalVat = round($subtotal - $totalVatable, 2);


        // if authenticate 
         $Customer = Auth::guard('customer')->user();


        return view('Ecommerce.EcommercePage.cart', compact('subtotal', 'totalVatable', 'totalVat','Customer'));
    }


    public function WishlistShow()
    {

        return view('Ecommerce.EcommercePage.wishlist');
    }
    



    public function ProfileShow()
    {

        
        $customer = Auth::guard('customer')->user();

        $orders = Order::with(['customer','orderDetails'])
            ->where('customer_id', $customer->id)
            ->whereIn('order_status', ['pending', 'complete', 'return', 'shipped']) 
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(4);

        $orderCancel = Order::with(['customer','orderDetails'])
            ->where('customer_id', $customer->id)
            ->whereIn('order_status', ['cancelled']) 
            ->orderBy('created_at', 'desc')
            ->get();


            $address = Address::with('customer')
                ->where('customer_id', $customer->id)
                ->orderByDesc('is_default') // default = 1 comes first
                ->get();


        return view('Ecommerce.ProfilePage.profile', compact('orders','address','customer','orderCancel'));
    }




        public function ProfileEdit()
        {

            return view('Ecommerce.ProfilePage.EditProfile');
        }


    public function ProfileUpdate(Request $request){

     $CustomerID = $request->input('id');


        $data = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('tel'),
        // 'address' => $request->input('address'),
        // 'city' => $request->input('city'),
        'added_by_staff' => '0',
        'updated_at' => Carbon::now(),
    ];


                // Handle image upload if exists
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(300,300)->save('frontend/assets/customer_image/'.$name_gen);
                $data['image'] = 'frontend/assets/customer_image/'.$name_gen;
            }

            Customer::findOrFail($CustomerID)->update($data);

                $notification = [
                    'message' => 'Customer Updated Successfully',
                    'alert-type' => 'success'
                ];

            return redirect()->route('customer.profile')->with($notification); 

      
        }

 


        public function ViewItem($id) {
            $customer = Auth::guard('customer')->user();

            $order = Order::where('id', $id)
                        ->where('customer_id', $customer->id)
                        ->firstOrFail();

            return view('Ecommerce.ProfilePage.ViewOrderItem', compact('order'));
        }

}
