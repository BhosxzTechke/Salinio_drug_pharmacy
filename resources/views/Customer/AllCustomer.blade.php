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
                                            
                                                    @if(Auth::user()->can('add-customer')) 
                                            <a href="{{ route('create.customer')}}"><button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Add Customer</button></a>
                                                    @endif
                                        </ol>

                                    </div>
                                    <h4 class="page-title">Customer Table</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 




                            <form method="GET" class="row g-2 mb-3">
                                <div class="col-md-3">
                                    <select name="source" class="form-control">
                                        <option value="">-- Filter by Source --</option>
                                        <option value="pos" {{ request('source') == 'pos' ? 'selected' : '' }}>POS / Admin</option>
                                        <option value="ecommerce" {{ request('source') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>

                                <div class="col-md-2">
                                    <a href="{{ route('all.customer') }}" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </form>





                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">


                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone </th>
                                                    <th>Source</th>
                                                    <th>Action</th>
                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                            @foreach ($CustomerData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td><img src="{{ $data->image }}" style="height: 3rem" ></td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->phone }}</td>
                                                        <td>
                                                            @if($data->added_by_staff == 1)
                                                                <span class="badge bg-info">POS / Admin</span>
                                                            @else
                                                                <span class="badge bg-success">E-commerce</span>
                                                            @endif
                        </td>
                                                        <td>
                                                            @if($data->added_by_staff == 1)


                                                                @if(Auth::user()->can('edit-customer')) 
                                                                    <a href="{{ route('edit.customer', $data->id) }}" 
                                                                    class="btn btn-success rounded-pill waves-effect waves-light">
                                                                    <i class="fa-solid fa-square-pen"></i> Edit
                                                                    </a>
                                                                @endif



                                                                @if(Auth::user()->can('delete-customer'))
                                                                    <a href="{{ route('delete.customer', $data->id) }}" 
                                                                    class="btn btn-danger rounded-pill waves-effect waves-light" 
                                                                    id="delete" title="Delete Data">
                                                                    <i class="fa-solid fa-trash"></i> Delete
                                                                    </a>
                                                                @endif
                                                            @else

                                                                <button class="btn btn-secondary rounded-pill waves-effect waves-light" disabled>
                                                                    <i class="fa-solid fa-lock"></i> View Only
                                                                </button>
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

@endsection
