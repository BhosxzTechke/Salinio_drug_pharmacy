@extends('admin_dashboard')
@section('admin')


                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                    

                                    </div>
                                    <h4 class="page-title">Complete Pickup Orders</h4>
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
                                        <th>SL</th>
                                        <th>Order #</th>
                                        <th>Order Source</th>
                                        <th>Name</th>
                                        <th>Order Date</th>
                                        <th>Payment</th>
                                        <th>Invoice</th>
                                        <th>Pay</th>
                                        <th>Order Status</th>
                                        <th>Order Type</th>
                                    </tr>


                    </thead>
                    
                    
    <tbody>
        {{-- Order table Fillable --}}
    @php $sl = 1 @endphp
    @foreach ($Orders as $data)
        <tr id="order-row-{{ $data->id }}">
    
            <td>{{ $sl++ }}</td>
            <td>Order#:{{$data->id }}</td>
            <td>{{ $data->order_source }}</td>
            <td>{{ $data->customer->name ?? '' }}</td>
            <td>{{ $data->order_date }}</td>
            <td>{{ $data->payment_status }}</td>
            <td>{{ $data->invoice_no }}</td>
            <td>{{ $data->pay }}</td>
            <td><span class="badge bg-success"> {{ $data->order_status ?? '' }}</span></td>
            <td><span class="badge bg-warning"> {{ $data->order_type ?? '' }}</span></td>

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

                {{-- <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javasc
                                    ript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer --> --}}

            </div>



        </div>
        <!-- END wrapper -->


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@endsection
