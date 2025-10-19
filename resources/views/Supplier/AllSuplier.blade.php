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

                                            @if(Auth::user()->can('add-supplier'))
                                            <a href="{{ route('supplier.create')}}"><button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Add Supplier</button></a>
                                            @endif
                                        </ol>

                                    </div>
                                    <h4 class="page-title">Manage Supplier</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Supplier Data Table</h4>


                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                            @foreach ($SupplierData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td><img src="{{ asset($data->image) }}" style="height: 3rem" ></td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->phone }}</td>


                                                    <td>
                                                        @if(Auth::user()->can('edit-supplier'))
                                                        <a href="{{ route('edit.supplier', $data->id )}}" class="btn btn-success rounded-pill waves-effect waves-light" title="Edit"><i class="fa-solid fa-square-pen"></i> Edit</a>
                                                        @endif

                                                        @if(Auth::user()->can('delete-supplier'))
                                                        <a href="{{ route('delete.supplier', $data->id ) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>
                                                        @endif

                                                        @if(Auth::user()->can('view-supplier-details'))
                                                        <a href="{{ route('details.supplier', $data->id ) }}" class="btn btn-primary rounded-pill waves-effect waves-light" id="details"  title="Details"><i class="fa-solid fa-circle-info"></i> Details</a>
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
{{-- 
                <!-- Footer Start -->
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

@endsection
