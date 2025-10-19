@extends('Ecommerce.Layout.ecommerce')

@section('content')


<div class="flex flex-wrap items-center justify-start space-x-2 text-sm text-gray-500 font-medium bg-white py-2 px-4 border border-gray-300 rounded-lg"> 
    <button type="button" aria-label="Home">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 7.609c.352 0 .69.122.96.343l.111.1 6.25 6.25v.001a1.5 1.5 0 0 1 .445 1.071v7.5a.89.89 0 0 1-.891.891H9.125a.89.89 0 0 1-.89-.89v-7.5l.006-.149a1.5 1.5 0 0 1 .337-.813l.1-.11 6.25-6.25c.285-.285.67-.444 1.072-.444Zm5.984 7.876L16 9.5l-5.984 5.985v6.499h11.968z" fill="#475569" stroke="#475569" stroke-width=".094"/>
        </svg>
    </button>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="m14.413 10.663-6.25 6.25a.939.939 0 1 1-1.328-1.328L12.42 10 6.836 4.413a.939.939 0 1 1 1.328-1.328l6.25 6.25a.94.94 0 0 1-.001 1.328" fill="#CBD5E1"/>
    </svg>
    <a href="#">Home</a>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="m14.413 10.663-6.25 6.25a.939.939 0 1 1-1.328-1.328L12.42 10 6.836 4.413a.939.939 0 1 1 1.328-1.328l6.25 6.25a.94.94 0 0 1-.001 1.328" fill="#CBD5E1"/>
    </svg>
    <a href="#" class="text-indigo-500">{{ $brand->name ?? 'Brand Name' }}</a>
</div>




<!-- Brand Header -->
<section class="bg-gradient-to-r from-blue-50 to-indigo-100 py-8 mb-8 rounded-xl shadow">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-6">
        <img src="{{ asset($brand->logo ?? 'images/default-brand.png') }}" alt="{{ $brand->name }}" class="w-24 h-24 rounded-full shadow-lg border-4 border-white mr-6 mb-4 md:mb-0">
        <div>
            <h1 class="text-3xl font-bold text-indigo-700 mb-2">{{ $brand->name ?? 'Brand Name' }}</h1>
            <p class="text-gray-600 text-lg">{{ $brand->description ?? 'Trusted pharmacy products for your health and wellness.' }}</p>
        </div>
    </div>
</section>



<!-- Product Grid with Wishlist -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($inventory as $inventories)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-4 flex flex-col relative">
            <div class="relative">
                <img src="{{ asset($inventories->product->product_image) }}" alt="{{ $inventories->product->product_name }}" class="w-full h-40 object-contain rounded-lg bg-gray-50 mb-4">
                @if($inventories->product->is_new)
                    <span class="absolute top-2 left-2 bg-green-100 text-green-700 text-xs px-2 py-1 rounded">New</span>
                @endif
                @if($inventories->product->discount)
                    <span class="absolute top-2 right-2 bg-red-100 text-red-700 text-xs px-2 py-1 rounded">-{{ $inventories->product->discount }}%</span>
                @endif
                <!-- Wishlist Button -->
                {{-- <form action="{{ route('wishlist.add', $inventories->id) }}" method="POST" class="absolute bottom-2 right-2"> --}}
                    @csrf
                    <button type="submit" class="bg-white border border-gray-300 rounded-full p-2 shadow hover:bg-pink-100 transition" title="Add to Wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                    </button>
                </form>
            </div>
            <h3 class="text-lg font-semibold text-indigo-700 mb-1">{{ $inventories->product->product_name }}</h3>
            {{-- <p class="text-gray-500 text-sm mb-2">{{ $inventories->product->short_description }}</p> --}}
            <div class="flex items-center justify-between mt-auto">
                <span class="text-xl font-bold text-green-600">₱{{ number_format($inventories->product->selling_price, 2) }}</span>
                <a href="{{ route('product.show', $inventories->product_id) }}">
                <button class="bg-neutral-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">View Details</button> </a>
            </div>
        </div>
        @endforeach
    </div>


    

        <div class="mt-6">
            {{-- Pagination --}}
            @if(isset($inventories) && $inventories instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $inventories->links() }}
            @endif
        </div>



</section>


@endsection
