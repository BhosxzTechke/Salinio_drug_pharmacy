@extends('Ecommerce.Layout.ecommerce')

@section('content')




<div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-lg p-8 text-center space-y-6">
    <!-- Success Icon -->


    <div class="animate-bounce text-green-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <!-- Heading -->
    <h1 class="text-3xl font-bold">Thank You for Your Order!</h1>
    <p class="text-gray-600">
      Your order has been successfully placed. You will receive a confirmation email shortly.
    </p>



<!-- Order Summary -->
<div class="bg-gray-100 w-full rounded-xl p-4 space-y-2 text-left">
    <h2 class="text-lg font-semibold">Order Summary</h2>

    <div class="flex justify-between">
        <span>Order Number:</span>
        <span class="font-medium">#{{ $OrderNumber }}</span> <!-- order ID here -->
    </div>



    <div class="flex justify-between">
        <span>Total:</span>
        <span class="font-bold text-lg">₱{{ number_format($total, 2) }}</span>
    </div>
</div>


    <!-- Actions -->
    <div class="grid gap-3 mt-4">
      <a href="{{ route('customer.profile') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl w-full block">Track My Order</a>
      <a href="{{ route('customer.dashboard')}}" class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium py-3 rounded-xl w-full block">Continue Shopping</a>
    </div>
  </div>
</div>




@endsection