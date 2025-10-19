
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
                                  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#login-modal">Add Category</button>

                                        </ol>

                                    </div>
                                    <h4 class="page-title">Hero Slide Table</h4>
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
                                                    <th>title</th>
                                                    <th>subtitle</th>
                                                    <th>image</th>
                                                    <th>link</th>
                                                    <th>position</th>
                                                    <th>status</th>

                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                             @foreach ($ImageData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>{{ $data->title }}</td>
                                                    <td>{{ $data->subtitle }}</td>
                                                    <td><img src="{{ asset($data->image) }}" style="height: 3rem" ></td>
                                                    <td>{{ $data->link }}</td>
                                                    <td>{{ $data->position }}</td>
                                                    <td>{{ $data->is_active == 1 ? 'Active' : 'Inactive' }}</td>

                                                    <td>
                                                        @if(Auth::user()->can('Delete Imageslider'))
                                                        <a href="{{ route('edit.heroslider', $data->id) }}" class="btn btn-success rounded-pill waves-effect waves-light"><i class="fa-solid fa-square-pen"></i> Edit</a>
                                                        @endif
                                                        @if(Auth::user()->can('Edit Imageslider'))
                                                        <a href="{{ route('delete.heroslider', $data->id)}}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>
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



                    </div> <!-- end container-fluid -->



       
                        
                    </div> <!-- container -->

                </div> <!-- content -->

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
                <!-- end Footer -->

            </div>



        </div>
        <!-- END wrapper -->

@endsection
