@extends('Ecommerce.Layout.ecommerce')

@section('content')

        <livewire:global-loader />

 @livewireStyles





        @php $ProductsCart = Cart::instance('ecommerce')->content(); @endphp


<div class="flex flex-col md:flex-row py-16 max-w-6xl w-full px-6 mx-auto">
    <div class="flex-1 max-w-4xl">

        <h1 class="text-3xl font-medium mb-6">
            Shopping Cart
        </h1>


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
            <form action="{{route('removeProd', $item->rowId)}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="cursor-pointer mx-auto">
                <svg width="30" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="m12.5 7.5-5 5m0-5 5 5m5.833-2.5a8.333 8.333 0 1 1-16.667 0 8.333 8.333 0 0 1 16.667 0" stroke="#FF532E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            </form>
        </div>
        <!-- Repeat above block for each product -->

        @endforeach

        <a href="{{ route('customer.dashboard') }}" class="group cursor-pointer flex items-center mt-8 gap-2 text-indigo-500 font-medium">
            <svg width="15" height="11" viewBox="0 0 15 11" fill="none">
                <path d="M14.09 5.5H1M6.143 10 1 5.5 6.143 1" stroke="#615fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Continue Shopping
        </a>
    </div>

    <div class="max-w-[360px] w-full bg-gray-100/40 p-5 max-md:mt-16 border border-gray-300/70">
        <h2 class="text-xl md:text-xl font-medium">Order Summary</h2>
        <span class="text-sm text-indigo-500">{{ $ProductsCart->count() }} Items</span>
      
        <hr class="border-gray-300 my-5" />





        <div class="text-gray-500 mt-4 space-y-2">


            <p class="flex justify-between">
                <span>Subtotal</span><span>₱{{ $subtotal }}</span>
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
                    <span>Total </span> ₱{{ number_format($subtotal, 2) }}
            </p>

        </div>

        <livewire:go-to-checkout />


    </form>

    </div>
</div>
<livewire:global-loader />


  @livewireScripts














@endsection






