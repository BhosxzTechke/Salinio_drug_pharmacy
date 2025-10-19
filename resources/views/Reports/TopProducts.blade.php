
@extends('admin_dashboard')
@section('admin')

<br>



<form method="GET" action="{{ route('top.sellings') }}" class="mb-3">
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

            <h4 style="color:rgb(255, 255, 255);"> Top Selling Products</style></h4>
        </div>
        <div class="card-body">
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Sales</th>
                        <th>Average Price</th>
                    </tr>
                </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($topProducts as $invent)
                            <tr>
                                <td>{{$i++ }}</td>
                                <td>{{ $invent->product_name }}</td>
                                <td>{{ $invent->total_qty }}</td>
                                <td>{{ number_format($invent->total_sales, 2) }}</td>
                                <td>
                                    {{ $invent->total_qty > 0 
                                        ? number_format($invent->total_sales / $invent->total_qty, 2) 
                                        : '0.00' 
                                    }}
                                </td>
                            </tr>
                        @endforeach
</tbody>

            </table>


        </div>
    </div>




</div>






@endsection