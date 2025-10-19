
@extends('admin_dashboard')
@section('admin')

<br>

    <h2 class="mb-3">Daily Sales Report</h2>

    <p>Date Range: <strong>{{ $fromDate->toFormattedDateString() }} - {{ $toDate->toFormattedDateString() }}</strong></p>


    <div class="mb-3">
        <form method="GET" action="{{ route('daily.reports') }}">
            <label>From:</label>
            <input type="date" name="from_date" value="{{ $fromDate->format('Y-m-d') }}">
            <label>To:</label>
            <input type="date" name="to_date" value="{{ $toDate->format('Y-m-d') }}">
            <select name="source">
                <option value="">All Sources</option>
                <option value="POS" {{ $sourceFilter == 'POS' ? 'selected' : '' }}>POS</option>
                <option value="ECOM" {{ $sourceFilter == 'ECOM' ? 'selected' : '' }}>ECOM</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>


<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            {{-- <h3 style="color:rgb(255, 255, 255);"> {{ $today }}</style></h4> --}}

            <h4 style="color:rgb(255, 255, 255);"> Daily Reports</style></h4>
        </div>
        <div class="card-body">
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice No.</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Source</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                                <th>Profit</th>
                            </tr>
                </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @foreach ($orders as $order)
                                @foreach ($order->orderDetails as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $order->invoice_no }}</td>
                                        <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : 'N/A'}}</td>
                                        <td>{{ $order->customer->name ?? 'Walk-in' }}</td>
                                        <td>{{ $order->order_source }}</td>
                                        <td>{{ $item->product->product_name ?? 'Unknown' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₱{{ number_format($item->unitcost, 2) }}</td>
                                        <td>₱{{ number_format($item->product->selling_price, 2) }}</td>
                                        <td>₱{{ number_format($item->profit, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>

                                <tfoot class="table-light">
            <tr>
                <th colspan="6" class="text-end">Total Products Sold:</th>
                <th>{{ $totalProductsSold }}</th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th colspan="8" class="text-end">Total Discounts:</th>
                <th>₱{{ number_format($totalDiscounts, 2) }}</th>
            </tr>
            <tr>
                <th colspan="8" class="text-end">Total VAT:</th>
                <th>₱{{ number_format($totalVAT, 2) }}</th>
            </tr>
            <tr>
                <th colspan="8" class="text-end">Grand Total Sales:</th>
                <th>₱{{ number_format($totalSales, 2) }}</th>
            </tr>
        </tfoot>

            </table>
    <p><strong>Total Orders:</strong> {{ $totalOrders }}</p>


        </div>
    </div>




</div>






@endsection