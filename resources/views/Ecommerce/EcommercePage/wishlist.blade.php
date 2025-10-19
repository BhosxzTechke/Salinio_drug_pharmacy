@extends('Ecommerce.Layout.ecommerce')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">My Wishlist</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <!-- Single Wishlist Item -->
    <div class="card bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
      <!-- Product Image -->
      <img src="https://via.placeholder.com/300x200" alt="Product Image" class="w-full h-48 object-cover">

      <!-- Product Info -->
      <div class="p-4 flex flex-col flex-1">
        <h3 class="text-lg font-semibold mb-1">Panadol Extra Strength</h3>
        <p class="text-gray-500 text-sm mb-2">Brand: GSK • Pain Relief</p>

        <!-- Price & Stock -->
        <div class="flex items-center space-x-2 mb-2">
          <span class="text-violet-600 font-bold">$9.99</span>
          <span class="line-through text-gray-400 text-sm">$12.99</span>
          <span class="badge badge-success ml-auto">In Stock</span>
        </div>

        <!-- Rating -->
        <div class="flex items-center space-x-2 mb-3">
          <div class="rating rating-sm">
            <input type="radio" name="rating1" class="mask mask-star-2 bg-yellow-400" checked/>
            <input type="radio" name="rating1" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating1" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating1" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating1" class="mask mask-star-2 bg-yellow-400"/>
          </div>
          <span class="text-gray-500 text-sm">(58)</span>
        </div>

        <!-- Buttons -->
        <div class="mt-auto flex space-x-2">
          <button class="btn btn-sm flex-1 bg-violet-600 text-white hover:bg-violet-700">Add to Cart</button>
          <button class="btn btn-sm btn-outline btn-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Repeat Wishlist Items -->
    <div class="card bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
      <img src="https://via.placeholder.com/300x200" alt="Product Image" class="w-full h-48 object-cover">
      <div class="p-4 flex flex-col flex-1">
        <h3 class="text-lg font-semibold mb-1">Vicks Vaporub</h3>
        <p class="text-gray-500 text-sm mb-2">Brand: Vicks • Cold & Flu</p>
        <div class="flex items-center space-x-2 mb-2">
          <span class="text-violet-600 font-bold">$7.99</span>
          <span class="line-through text-gray-400 text-sm">$10.99</span>
          <span class="badge badge-error ml-auto">Out of Stock</span>
        </div>
        <div class="flex items-center space-x-2 mb-3">
          <div class="rating rating-sm">
            <input type="radio" name="rating2" class="mask mask-star-2 bg-yellow-400" checked/>
            <input type="radio" name="rating2" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating2" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating2" class="mask mask-star-2 bg-yellow-400"/>
            <input type="radio" name="rating2" class="mask mask-star-2 bg-yellow-400"/>
          </div>
          <span class="text-gray-500 text-sm">(34)</span>
        </div>
        <div class="mt-auto flex space-x-2">
          <button class="btn btn-sm flex-1 bg-violet-600 text-white hover:bg-violet-700">Add to Cart</button>
          <button class="btn btn-sm btn-outline btn-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <!-- End Repeat -->

  </div>
</div>


@endsection