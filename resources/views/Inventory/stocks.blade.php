@extends('admin_dashboard')
@section('admin')

<div class="content">


<br>
    

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">-- Filter by Status --</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
    </div>

    <div class="col-md-3">
        <input type="text" name="product" value="{{ request('product') }}" class="form-control" placeholder="Search by Product name">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>

    <div class="col-md-2">
        <a href="{{ route('show.inventory') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
</form>



                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
@if(Auth::user()->can('export-inventory'))
<a href="{{ route('download.export') }}" class="btn btn-danger rounded-pill waves-effect waves-light">Export </a>  
&nbsp;&nbsp;&nbsp;
@endif



    {{-- <a href="" class="btn btn-primary rounded-pill waves-effect waves-light">Add Product </a>   --}}
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Inventory</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Code</th>
                                <th>Stock</th> 
                                <th>Expiration Date</th> 
                                <th>Status</th> 
                            </tr>
                        </thead>
                    
    
        <tbody>
        	@foreach($inventory as $key=> $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td> <img src="{{ asset($item->product->product_image) }}" style="width:50px; height: 40px;"> </td>
                <td>{{ $item->product->product_name ?? '' }}</td>
                <td>{{ $item['product']['category']['category_name'] ?? '' }}</td>
                <td>{{ $item['Supplier']['name'] ?? '' }}</td>
                <td>{{ $item->product->product_code ?? '' }}</td>
                <td>
                    @if($item->quantity == 0)
                        <button class="btn btn-danger waves-effect waves-light">{{ $item->quantity }}</button>
                    @elseif($item->quantity < 10)
                        <button class="btn btn-warning waves-effect waves-light">{{ $item->quantity }}</button>
                    @else
                        <button class="btn btn-success waves-effect waves-light">{{ $item->quantity }}</button>
                    @endif
                </td>
                <td>{{ $item->expiry_date ?? '' }}</td>
                <td><button class="btn btn-dark waves-effect waves-light">{{ $item->status }}</button></td>


            </tr>
            @endforeach
        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->


                        
                    </div> <!-- container -->

                </div> <!-- content -->


@endsection 