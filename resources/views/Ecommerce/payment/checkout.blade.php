<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Pharmacy Shop')</title>

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

<link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <!-- Page-specific CSS -->

   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

</head>



<body >





<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  






    <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">

        <h2 class="flex flex-wrap mr-10"> Secure Check</h2>
  <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Salino Drug</span>
  </a>




  </div>
</nav>





        @php $ProductsCart = Cart::instance('ecommerce')->content(); @endphp


<div class="flex flex-col md:flex-row py-16 max-w-6xl w-full px-6 mx-auto">
    <div class="flex-1 max-w-4xl">

        <br>


        <div class="grid grid-cols-[2fr_1fr_1fr] text-gray-500 text-base font-medium pb-3">
            <p class="text-left">Product Details</p>
            <p class="text-center">Subtotal</p>
        </div>




        

        @foreach($ProductsCart as $item)

        <!-- Example Product Rows (Repeat for each product) -->
        <div class="grid grid-cols-[2fr_1fr_1fr] text-gray-500 items-center text-sm md:text-base font-medium pt-3">
            <div class="flex items-center md:gap-6 gap-3">
                <div class="cursor-pointer w-24 h-24 flex items-center justify-center border border-gray-300 rounded overflow-hidden">
                    <img class="max-w-full h-full object-cover" src="{{ asset($item->options->image)}}" alt="Item not found" />
                </div>

                <div>
                    <p class="hidden md:block font-semibold">{{ $item->name}}</p>
                    <div class="font-normal text-gray-500/70">
                        <p>Category: <span>walapa</span></p>
                        <div class="flex items-center">
                            <p>Qty:</p>
                            <select class="outline-none">
                                <option value="1">{{ $item->qty}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center">₱{{ $item->subtotal}}</p>

        </div>
        <!-- Repeat above block for each product -->

        @endforeach

    </div>




    <div class="max-w-[360px] w-full bg-lime-200/40 p-5 max-md:mt-16 border border-gray-300/70">
        <h2 class="text-xl md:text-xl font-medium">Order Summary</h2>
        <span class="text-sm text-indigo-500">{{ $ProductsCart->count() }} Items</span>
      
        <hr class="border-gray-300 my-5" />




<div class="mb-6">
    <form method="POST" action="{{ route('cart.checkout') }}" class="space-y-3">
    @csrf
    
        <p class="text-sm font-medium uppercase">Delivery Address</p>
        <div class="mt-2 flex justify-between items-start">

            @php
                $customer = Auth::guard('customer')->user();

                // First check temporary session address
                $tempAddress = session('shipping_address_temp');

                // Then check saved address
                $savedAddress = null;
                if (session('shipping_address_id')) {
                    $savedAddress = \App\Models\Address::find(session('shipping_address_id'));
                }

                // Fallback to default address
                $defaultAddress = $customer?->defaultAddress;
            @endphp


            <p class="text-gray-700">
                @if ($tempAddress)
                    {{ $tempAddress['full_address'] }}

                @elseif ($savedAddress)
                    {{ $savedAddress->full_address }}
                    
                @elseif ($defaultAddress)
                    {{ $defaultAddress->full_address }}
                @else
                    No address found
                @endif
            </p>




            @auth('customer')
                <button type="button"
                        class="ml-4 px-3 py-1 rounded bg-violet-600 text-white hover:bg-violet-700"
                        onclick="document.getElementById('addressModal').classList.remove('hidden')">
                    Change Address
                </button>
            @endauth


        {{-- Safe hidden fields --}}
        <input type="hidden" name="customer_id" value="{{ $Customer->id ?? '' }}">
        <input type="hidden" name="order_date" value="{{ now() }}">
        <input type="hidden" name="order_status" value="pending">
        <input type="hidden" name="total_products" value="{{ Cart::instance('ecommerce')->count() }}">
        <input type="hidden" name="shipping_address_id" value="{{ $Customer->shipping_address_id ?? '' }}">

                    
            
  
        <input type="hidden" name="shipping_address_id" 
           value="{{ session('shipping_address_id') ?? Auth::guard('customer')->user()->defaultAddress?->id ?? '' }}">

            </div>

            <p class="text-sm font-medium uppercase mt-6">Payment Method</p>
            <select name="payment_method" class="w-full border border-gray-300 bg-white px-3 py-2 mt-2 outline-none">
                <option value="paypal">Paypal</option>
            </select>
        </div>

        <hr class="border-gray-300" />

        <div class="text-gray-500 mt-4 space-y-2">


            <p class="flex justify-between">
                <span>Subtotal</span><span>₱{{ $totalInclusive }}</span>
            </p>
            <p class="flex justify-between">
                <span>Shipping Fee</span><span class="text-green-600">Free</span>
            </p>
            <p class="flex justify-between">
                <span>VAT - Inclusive (12%)</span><span>({{ config('cart.tax') }}%):</strong> ₱{{ number_format($totalVat, 2) }} </span>
            </p>


             <p class="flex justify-between">
                   <span>Vatable Sales:</span> <span> ₱{{ number_format($totalVatable, 2) }}</span>
                </p>

            <p class="flex justify-between text-lg font-medium mt-3">
                    <span>Total </span> ₱{{ number_format($totalInclusive, 2) }}
            </p>

        </div>

            <button
            type="submit"
            class="w-full py-3 mt-6 flex items-center justify-center gap-2 cursor-pointer bg-indigo-500 text-white font-medium hover:bg-indigo-600 transition rounded-lg"
            >
            <!-- Lock Icon (Heroicons or Lucide) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c-1.105 0-2 .895-2 2v3a2 2 0 104 0v-3c0-1.105-.895-2-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 11V7a5 5 0 10-10 0v4h10z" />
            </svg>
            Place Order
          </button>


           <a href="{{ route(('cart.show'))}}"
            type="submit"
            class="w-full py-3 mt-6 flex items-center justify-center gap-2 cursor-pointer bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31] text-white font-medium hover:bg-indigo-600 transition rounded-lg"
            >
            <!-- Lock Icon (Heroicons or Lucide) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c-1.105 0-2 .895-2 2v3a2 2 0 104 0v-3c0-1.105-.895-2-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 11V7a5 5 0 10-10 0v4h10z" />
            </svg>
            Back to cart
        </a>


    </form>

    </div>
</div>






<!-- Address Modal -->
<div id="addressModal"
     class="fixed inset-0 hidden z-50 flex items-center justify-center">
  
  <!-- Backdrop -->
  <div class="absolute inset-0 bg-black/50"
       onclick="document.getElementById('addressModal').classList.add('hidden')"></div>

  <!-- Modal panel -->
  <div class="relative bg-white rounded-lg shadow-lg max-w-md w-full p-6 z-10">
    <h3 class="text-lg font-semibold mb-4">Change Shipping Address</h3>

    <!-- Form -->
<form method="POST" action="{{ route('cart.updateAddress') }}" class="space-y-3">
    @csrf

            <!-- Select from saved addresses -->
            <label class="block text-sm font-medium">Choose saved address</label>
            <select name="saved_address" class="w-full border rounded p-2">
                <option value="">-- Select --</option>

                    @foreach($addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                    @endforeach
                
            </select>

    <div class="text-center text-gray-500">OR</div>

    <!-- Enter new address -->
    <label class="block text-sm font-medium">New Address</label>
    <textarea name="new_address" class="w-full border rounded p-2" rows="3"></textarea>

    <!-- Checkbox: save permanently -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="save_to_profile" id="save_to_profile" value="1">
        <label for="save_to_profile" class="text-sm">Save this address to my profile</label>
    </div>

    <div class="flex justify-end space-x-2">
        <button type="button" onclick="document.getElementById('addressModal').classList.add('hidden')"
                class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">
            Cancel
        </button>
        <button type="submit" class="px-3 py-1 rounded bg-violet-600 text-white hover:bg-violet-700">
           Submit
        </button>
    </div>
</form>


  </div>
</div>












<script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
            case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

            case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

            case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

            case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
            }
            @endif
            </script>
            </body>
</html>



