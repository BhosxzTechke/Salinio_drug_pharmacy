@extends('Ecommerce.Layout.ecommerce')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">
  <div class="grid md:grid-cols-2 gap-8">

    <!-- Product Images -->
    <div class="flex flex-col items-center">
      <div class="w-full max-w-md">
        <img src="{{ asset($inventory->product->product_image)}}" alt="{{ $inventory->product->product_name }}" class="rounded-lg shadow-lg w-full" />
      </div>
      <div class="flex space-x-3 mt-4">
        <img src="https://via.placeholder.com/100" class="w-16 h-16 rounded-lg border cursor-pointer hover:border-violet-500" />
        <img src="https://via.placeholder.com/100" class="w-16 h-16 rounded-lg border cursor-pointer hover:border-violet-500" />
        <img src="https://via.placeholder.com/100" class="w-16 h-16 rounded-lg border cursor-pointer hover:border-violet-500" />
      </div>
    </div>


    
<!-- Product Info -->
<div class="space-y-6">

  <!-- Add to Cart Form -->
  <form method="POST" action="{{ url('/ecommerce/add') }}">
    @csrf

    <input type="hidden" name="id" value="{{ $inventory->product_id }}">
    <input type="hidden" name="name" value="{{ $inventory->product->product_name }}">
    <input type="hidden" name="qty" value="1">
    <input type="hidden" name="selling_price" value="{{ $inventory->product->selling_price }}">
    <input type="hidden" name="product_image" value="{{ $inventory->product->product_image }}">



    <!-- Name, Brand, Category -->
    <h1 class="text-2xl font-bold">{{ $inventory->product->product_name }}</h1>
    <p class="text-sm text-gray-500">
      Brand: <span class="font-medium">{{ $inventory->product->brand->brand_name ?? 'N/A' }}</span>
    </p>
    <p class="text-sm text-gray-500">
      Category: <span class="font-medium">{{ $inventory->Product->category->category_name ?? 'No Category' }}</span>
    </p>
    <p class="text-sm text-gray-500">
      Sub-Category: <span class="font-medium">{{ $inventory->Product->subcategory->name ?? 'No Sub-Category' }}</span>
    </p>
    <p class="text-sm text-gray-500">
      Product Code: <span class="font-medium">{{ $inventory->product->product_code ?? 'No Product Code' }}</span>
    </p>

    <!-- Price + Stock -->
    <div class="flex items-center space-x-4">
      <p class="text-3xl font-bold text-violet-600">₱{{ number_format($inventory->product->selling_price,2) }}</p>


      @if($inventory->quantity > 0)
        <span class="badge badge-success ml-2">In Stock</span>
      @else
        <span class="badge badge-error ml-2">Out of Stock</span>
      @endif
    </div>



    <!-- Short Description -->
    <p class="text-gray-700 leading-relaxed">{{ $inventory->product->description }}</p>

    <!-- Add to Cart Button -->
    <div class="mt-4">


      @if($inventory->product->prescription_required)
        <button class="btn bg-violet-600 text-white hover:bg-violet-700 flex-1">Upload Prescription</button>
      @else
        <button type="submit" class="btn bg-violet-600 text-white hover:bg-violet-700 flex-1">Add to Cart</button>
      @endif


    </div>
  </form>


  <!--This ensures each item in the loop is the actual product you want  Cart Items (Separate Section, NOT inside Add to Cart Form) -->
@php
$ProductsItem = Cart::instance('ecommerce')->content()->filter(function($item) use ($inventory) {
    return $item->options->product_id == $inventory->product_id;
});
@endphp


  <div class="space-y-4">
    @foreach ($ProductsItem as $item)
         <div class="flex items-center space-x-3">

      <form method="POST" action="{{ url('/ecommerce/ChangeQty/' . $item->rowId) }}" class="flex items-center space-x-2">
        @csrf
        @method('PATCH')

        <!-- Decrease Quantity -->
        <button type="submit" name="action" value="decrease" class="btn btn-outline join-item">-</button>

        <!-- Input Quantity -->
      <input 
        type="number" 
        name="qty" 
        value="{{ $item->qty }}" 
        min="1" 
        class="input input-bordered join-item w-16 text-center" 
        onchange="this.form.submit()"
      />

        <!-- Increase Quantity -->
        <button type="submit" name="action" value="increase" class="btn btn-outline join-item">+</button>


        
      </form>



        <form action="{{ route('removeProd', $item->rowId) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-trash text-red"></i>
          </button>
        </form>

  </div>

    @endforeach



  </div>




</div>

      <!-- Tabs for Details / Usage / Safety -->
      <div class="mt-6">
        <div class="tabs">
          <a class="tab tab-bordered tab-active">Details</a> 
          <a class="tab tab-bordered">Dosage</a> 
          <a class="tab tab-bordered">Safety Info</a>
          <a class="tab tab-bordered">Storage</a>
          <a class="tab tab-bordered">Reviews</a>
        </div>
        <div class="p-4 border rounded-b-lg text-sm text-gray-600 leading-relaxed">
          <p><strong>Dosage Form:</strong> {{ $inventory->dosage_form ?? 'N/A' }}</p>
          <p><strong>Dosage Instructions:</strong> {{ $inventory->product->usage_instructions ?? 'Consult your physician.' }}</p>
          {{-- <p><strong>Contraindications:</strong> {{ $Product->contraindications ?? 'Not specified' }}</p> --}}


          <p><strong>Storage Instructions:</strong> {{ $inventory->product->storage_instructions ?? 'Store in a cool, dry place below 25°C' }}</p>
          <p><strong>Expiry Date:</strong> {{ $inventory->expiry_date ? date('M d, Y', strtotime($inventory->expiry_date)) : 'N/A' }}</p>
        </div>
      </div>

      <!-- Trust Badges -->
      <div class="flex space-x-4 mt-4">
        <span class="badge badge-outline">✔ Genuine Medicine Guarantee</span>
        <span class="badge badge-outline">🔒 Secure & Confidential</span>
      </div>

    </div>
  </div>
</div>

@endsection
