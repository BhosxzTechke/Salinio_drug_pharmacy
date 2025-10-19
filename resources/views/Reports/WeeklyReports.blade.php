
@extends('admin_dashboard')
@section('admin')

<br>



<form method="GET" action="{{ route('weekly.reports') }}" class="mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <label for="source" class="form-label fw-bold mb-0">Filter by Source:</label>
        </div>
        <div class="col-auto">
            <select name="source" id="source" class="form-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="POS" {{ request('source') == 'POS' ? 'selected' : '' }}>POS</option>
                <option value="ECOM" {{ request('source') == 'ECOM' ? 'selected' : '' }}>ECOM</option>
            </select>
        </div>
    </div>
</form>



<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 style="color:rgb(255, 255, 255);"> Start: {{ $start  }} End: {{ $end }}</style></h4>

            <h4 style="color:rgb(255, 255, 255);"> Daily Reports</style></h4>
        </div>
        <div class="card-body">
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Source</th>
                        <th>Total</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                    <tbody>

                        @php $i = 1 @endphp
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $order->customer_name ?? 'Walk-In' }}</td>
                                <td> {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : 'N/A' }}
</td>
                                <td>{{ $order->order_source }}</td>
                                <td>{{ number_format($order->total, 2) }}</td>
                                <td><span class="badge badge-pill bg-danger">{{ ucfirst($order->order_status) }}</span></td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
            </table>


        </div>
    </div>




</div>






@endsection