<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Auth\CustomerLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\HeroSlider;
use App\Models\Product;




class AuthCustomerController extends Controller
{
    //
        
    public function create(): View
    {
        return view('Ecommerce.auth.CustomerLogin');
    }


            ////////////////////////// Register /////////////////////////

        public function ShowRegister(): View
    {
        return view('Ecommerce.auth.CustomerRegister');
    }

            ////////////////////////// Customer Dashboard /////////////////////////

    public function index()
    {
        $categories = Category::all();
        $HeroSlider = HeroSlider::where('is_active', 1)->get();

        $bestSellers = Product::withCount([
            'orderDetails as sold_count' => function ($query) {
                $query->select(DB::raw("COALESCE(SUM(quantity),0)"));
            }
        ])
        ->orderByDesc('sold_count')
        ->take(10)
        ->get();

        $newArrivals = Product::latest()->take(8)->get();

        // return your customer dashboard blade
        return view('Ecommerce.CustomerDashboard', compact('categories', 'newArrivals', 'bestSellers', 'HeroSlider'));
    }



        public function store(CustomerLoginRequest $request): RedirectResponse
        {
            // Authenticate the customer
            $request->authenticate();

            $request->session()->regenerate();

            // Restore cart for the authenticated customer
            if (Auth::guard('customer')->check()) {
                
                Cart::restore(Auth::guard('customer')->id());
            }

            $notification = [
                'message' => 'Customer Logged in Successfully',
                'alert-type' => 'success'
            ];

                return redirect()->intended(route('customer.dashboard'))->with($notification);


        }






    //         /**
    //  * Destroy an authenticated session.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

        
    //     return redirect('/');

    // }



       public function destroyCustomer(Request $request): RedirectResponse
    {
            if (Auth::guard('customer')->check()) {
                Cart::store(Auth::guard('customer')->id()); // save cart to DB
            }
            
        Auth::guard('customer')->logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();


            $notification = array(
            'message' => 'Customer Logout Successfully',
            'alert-type' => 'info'
        );    




     return redirect()->route('home')->with($notification);
   }




                            // Redirect to HOME after logout
    public function Logout()
            {
                
         $notification = array(
                        'message' => 'Customer Logout Successfully',
                        'alert-type' => 'success'
           );

             return view('Ecommerce.home')->with($notification);

    }






}

