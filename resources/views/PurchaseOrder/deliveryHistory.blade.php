
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
                            <ol class="breadcrumb m-0">
                        {{-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#login-modal">Add Category</button> --}}

                            </ol>

                        </div>
                        <h4 class="page-title">All Complete Orders</h4>
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
                                        <th>Delivery Date</th>
                                        <th>Reference Number</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>

                            </thead>
                            
                            
                                <tbody>

            @php $sl = 1 @endphp
                @foreach ($delivery as $data)
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $data->delivery_date }}</td>
                    <td>{{ $data->reference_number ?? '' }}</td>
                    <td>{{ $data->remarks }}</td>
                    <td>  <span class="badge badge-pill bg-info">{{ $data->purchaseOrder->status }}</span></td>



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

                <!-- Footer Start -->
                {{-- <footer class="footer">
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
                </footer> --}}
                <!-- end Footer -->

            </div>



        </div>
        <!-- END wrapper -->

@endsection
