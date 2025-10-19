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

                                        @if(Auth::user()->can('import-products'))
                                        <a href="{{ route('import.product') }}"><button type="button" class="btn btn-info rounded-pill waves-effect waves-light me-2"><i class="mdi mdi-cloud-outline me-1"></i> Import </button></a>
                                            @endif

                                        @if(Auth::user()->can('export-products'))
                                            <a href="{{ route('download.export') }}"><button type="button" class="btn btn-danger rounded-pill waves-effect waves-light me-1"><i class="mdi mdi-cloud-outline me-1"></i> Export </button></a>
                                        @endif

                                        @if(Auth::user()->can('add-products'))
                                            <a href="{{ route('add.product') }}"><button type="button" class="btn btn-dark rounded-pill waves-effect waves-light"><i class="mdi mdi-cloud-outline me-1"></i> Add Product </button></a>
                                            @endif
                                            
                                        </ol>

                                    </div>
                                    <h4 class="page-title">Product Table</h4>
                                </div>
                            </div>
                        </div>     



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body"> <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Expiration</th>
                                                    <th>Code</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                            @foreach ($productData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td><img src="{{ asset($data->product_image) ?? '' }}" style="height: 3rem" ></td>
                                                    <td>{{ $data->product_name }}</td>
                                                    <td>{{ $data->Category->category_name  ?? ''}}</td>
                                                    <td>    @if($data->has_expiration && $data->has_expiration === 1)Yes
                                                            @else No @endif </td>
                                                    <td>{{ $data->product_code }}</td>
                                                    <td>{{ $data->selling_price }}</td>
                                                    <td>

                                                        @If(Auth::user()->can('edit-products'))
                                                        <a href="{{ route('edit.product', $data->id)}}" class="btn btn-success rounded-pill waves-effect waves-light"><i class="fa-solid fa-square-pen"></i> Edit</a>
                                                        @endif
                                                        @If(Auth::user()->can('barcode-products'))
                                                        <a href="{{ route('barcode.product', $data->id)}}" class="btn btn-info rounded-pill waves-effect waves-light"><i class="fa-solid fa-square-pen"></i> Barcode </a>
                                                        @endif
                                                        @If(Auth::user()->can('delete-products'))
                                                        <a href="{{ route('delete.product', $data->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>
                                                        @endif
                                                    </td>
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
                </footer>
                <!-- end Footer --> --}}

            </div>



        </div>
        <!-- END wrapper -->

@endsection
