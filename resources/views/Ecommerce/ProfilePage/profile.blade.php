@extends('Ecommerce.Layout.ecommerce')

@section('content')

<div class="min-h-screen bg-base-200 p-6 flex justify-center">
  <div class="w-full max-w-5xl">
    <!-- Profile Header -->
    <div class="card bg-base-100 shadow-xl mb-6">
      <div class="card-body flex flex-col md:flex-row items-center gap-6">
        <div class="avatar">
          <div class="w-24 rounded-full">
            <img src="{{ asset(Auth::guard('customer')->user()->image ?? 'uploads/noimage.png') }}" alt="User Avatar" />
          </div>
        </div>
        <div class="flex-1 text-center md:text-left">
          <h2 class="text-2xl font-bold">{{ Auth::guard('customer')->user()->name }}</h2>
          <p class="text-sm text-gray-500">{{ Auth::guard('customer')->user()->email }}</p>
          <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-2">
            <a href="{{ route('customer.profile.edit') }}">
            <button class="btn btn-inverse">Edit Profile</button></a>


        <form method="POST" action="{{ route('customer.logout') }}">
        @csrf
            <button class="btn btn-inverse">Logout</button></a>
        </form>

          </div>
        </div>
      </div>
    </div>





    <!-- Tabs -->
    <div role="tablist" class="tabs tabs-bordered w-full">
      <input type="radio" name="profile_tabs" role="stab" class="tab text-green-500 [checked]:text-black" aria-label="Account Info" checked />
      <div role="tabpanel" class="tab-content mt-4">
        <div class="card bg-base-100 shadow">
           
          <div class="card-body space-y-4">


            
            <div>
              <label class="label">Name</label>
              <input type="text" value="{{ Auth::guard('customer')->user()->name }}" class="input input-bordered w-full" readonly/>
            </div>
            <div>
              <label class="label">Email</label>
              <input type="email" value="{{ Auth::guard('customer')->user()->email }}" class="input input-bordered w-full" readonly/>
            </div>
            <div>
              <label class="label">Phone</label>
              <input type="tel" value="{{ Auth::guard('customer')->user()->phone }}" class="input input-bordered w-full" readonly/>
            </div>
          </div>
        </div>
      </div>





<!-- Order History Tab -->
<input 
  type="radio" 
  name="profile_tabs" 
  role="tab" 
  class="tab text-green-500 checked:text-black" 
  aria-label="Order History" 
  checked
/>

<!-- Order History Panel -->
<div role="tabpanel" class="tab-content mt-4">
  <div class="rounded-2xl border border-gray-200 shadow-sm overflow-hidden bg-white">
    <div class="overflow-x-auto">
      <table class="table-auto w-full text-sm border-collapse">
        
        <!-- Header -->
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wide hidden md:table-header-group">
          <tr>
            <th class="px-6 py-3 text-left">Order Number</th>
            <th class="px-6 py-3 text-center">Order Date</th>
            <th class="px-6 py-3 text-right">Total Amount</th>
            <th class="px-6 py-3 text-center">Status</th>
            <th class="px-6 py-3 text-center">Cancel / Refund</th>
            <th class="px-6 py-3 text-center">Items</th> 
          </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y divide-gray-200">
          @forelse($orders as $order)
            @php
              $totalAmount = $order->orderdetails->sum(fn($detail) => 
                $detail->product ? $detail->product->selling_price * $detail->quantity : 0
              );
            @endphp

            <tr class="flex flex-col md:table-row border-b md:border-0 p-4 md:p-0 hover:bg-gray-50 transition">
              
              <!-- Order Number -->
              <td class="md:table-cell px-0 md:px-6 py-2 font-medium text-gray-900">
                <span class="md:hidden font-semibold block">Order #:</span>
                {{ $order->invoice_no ?? 'Unknown' }}
              </td>

              <!-- Date -->
              <td class="md:table-cell px-0 md:px-6 py-2 text-gray-600 md:text-center">
                <span class="md:hidden font-semibold block">Date:</span>
                {{ $order->order_date }}
              </td>

              <!-- Total -->
              <td class="md:table-cell px-0 md:px-6 py-2 font-semibold text-gray-900 md:text-right">
                <span class="md:hidden font-semibold block">Total:</span>
                ${{ number_format($totalAmount, 2) }}
              </td>

              <!-- Status -->
              <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                <span class="md:hidden font-semibold block">Status:</span>
                <span class="px-3 py-1 text-xs font-medium rounded-full
                  @if($order->order_status === 'shipped' || $order->order_status === 'complete')
                    bg-green-100 text-green-700
                  @elseif($order->order_status === 'cancelled')
                    bg-red-100 text-red-700
                  @else
                    bg-yellow-100 text-yellow-700
                  @endif">
                  {{ ucfirst($order->order_status) }}
                </span>
              </td>

              <!-- Cancel / Refund -->
              <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                @if (!in_array($order->order_status, ['cancelled', 'shipped', 'complete']))
                  <button class="btn btn-sm btn-error mark-cancelled" data-id="{{ $order->id }}">
                    Cancel
                  </button>
                @else
                  <span class="text-gray-400 text-xs">Not Available</span>
                @endif
              </td>



              <!-- View Items -->
              <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                <a href="{{ route('customer.view.item', $order->id) }}" 
                   class="btn btn-primary btn-xs">
                  View Items
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-6 text-gray-500">
                No orders found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t bg-gray-50 flex justify-center">
      {{ $orders->links() }}
    </div>
  </div>
</div>








<!-- Tab -->
<input 
  type="radio" 
  name="profile_tabs" 
  role="tab" 
  class="tab text-green-500 [checked]:text-black" 
  aria-label="Cancelled Orders" 
/>




<!-- Tab Panel -->
<div role="tabpanel" class="tab-content mt-4">
<div class="rounded-2xl border border-base-300 shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table-auto w-full text-sm border-collapse">
      
      <!-- Header -->
      <thead class="bg-base-200/70 text-gray-700 uppercase text-xs tracking-wide hidden md:table-header-group">
        <tr>
          <th class="px-6 py-3 text-left">Order Number</th>
          <th class="px-6 py-3 text-center">Order Date</th>
          <th class="px-6 py-3 text-right">Total Amount</th>
          <th class="px-6 py-3 text-center">Order Status</th>
          <th class="px-6 py-3 text-center">Invoice</th>
          <th class="px-6 py-3 text-center">View Items</th> <!-- ✅ New Column -->
        </tr>
      </thead>

      <!-- Body -->
      <tbody class="divide-y divide-base-300 bg-white">
        @foreach($orderCancel as $order)
          @foreach ($order->orderdetails as $detail)
            <tr class="flex flex-col md:table-row border-b md:border-0 p-4 md:p-0 hover:bg-base-100/50 transition" id="order-row-{{ $order->id }}" >

              <!-- Order Number -->
              <td class="md:table-cell px-0 md:px-3 py-1 font-medium text-gray-900">
                <span class="md:hidden font-semibold block">Order #:</span>
                {{ $order->invoice_no ?? 'Unknown' }} 
              </td>

              <!-- Order Date -->   
              <td class="md:table-cell px-0 md:px-6 py-2 text-gray-600 md:text-center">
                <span class="md:hidden font-semibold block">Date:</span>
                {{ $order->order_date }}
              </td>

              <!-- Total Amount -->
              <td class="md:table-cell px-0 md:px-6 py-2 font-semibold text-gray-900 md:text-right">
                <span class="md:hidden font-semibold block">Total:</span>
                @if($detail->product && $detail->product->selling_price !== null)
                  ${{ number_format($detail->product->selling_price * $detail->quantity, 2) }}
                @else
                  N/A
                @endif   
                         </td>

              <!-- Order Status -->
                <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                <span class="md:hidden font-semibold block">Status:</span>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-300">
                  {{ $order->order_status }}  
                </span>
                </td>



              <!-- Invoice Link -->
              <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                <a href="" class="btn btn-outline btn-xs">
                  View Invoice
                </a>
              </td>

              <!-- ✅ View Item Button -->
              <td class="md:table-cell px-0 md:px-6 py-2 md:text-center">
                <a href="{{ route('customer.view.item', $order->id ) }}" 
                   class="btn btn-primary btn-xs">
                  View Items
                </a>
              </td>

            </tr>
          @endforeach
    @endforeach



        
      </tbody>


    </table>
  </div>
</div>

</div>








{{-- 
    <!-- Modal for this specific order -->
    <div id="OrderDetailsModal{{ $item->id }}"
         class="fixed inset-0 hidden z-50 flex items-center justify-center">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50"
             onclick="document.getElementById('OrderDetailsModal{{ $item->id }}').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 z-10">
            <h3 class="text-xl font-bold mb-4">Order Details</h3>

            <!-- Order Info -->
            <div class="space-y-2 mb-4">
                <p><span class="font-semibold">Order ID:</span> #{{ $item->id }}</p>
                <p><span class="font-semibold">Date:</span> {{ $item->created_at->format('M d, Y') }}</p>
                <p><span class="font-semibold">Customer:</span> {{ $item->customer->name }}</p>
                <p><span class="font-semibold">Status:</span> 
                    <span class="badge {{ $item->status === 'Processing' ? 'badge-success' : 'badge-warning' }}">
                        {{ $item->status }}
                    </span>
                </p>
            </div>



            <!-- Actions -->
            <div class="flex justify-end gap-3 mt-4">
                <button type="button"
                        onclick="document.getElementById('OrderDetailsModal{{ $item->id }}').classList.add('hidden')"
                        class="btn btn-ghost">
                    Close
                </button>
                <form action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-error text-white">Cancel Order</button>
                </form>
            </div>
        </div>
    </div> --}}



    

      
      <input type="radio" name="profile_tabs" role="tab" class="tab text-green-500 [checked]:text-black" aria-label="Addresses" />
      <div role="tabpanel" class="tab-content mt-4">
        <div class="card bg-base-100 shadow">
          <div class="card-body space-y-4">

            @foreach($address as $CustomerAddress)
            <div class="border p-4 rounded-lg">
              <p class="font-semibold">Home</p>
              <p class="text-sm text-gray-500">{{ $CustomerAddress->full_address }}</p>
              <button class="btn btn-ghost btn-sm mt-2">Edit</button>
            </div>
            @endforeach


            <button class="btn btn-primary mt-4">+ Add New Address</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>






<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
      $(document).ready(function() {
      $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
      });


      // Cancel Order
      $('.mark-cancelled').click(function() {
          let id = $(this).data('id');

          Swal.fire({
              title: 'Cancel this order?',
              text: 'This action cannot be undone!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, Cancel it!',
              cancelButtonText: 'No, go back'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.post("{{ route('Customer.order.cancelled') }}", { id: id }, function(data) {
                      if (data.success) {
                          $('#order-row-' + id).fadeOut();
                          Swal.fire('Cancelled', data.message, 'success');
                      }
                  });
              }
          });
      });


});
</script>


@endsection