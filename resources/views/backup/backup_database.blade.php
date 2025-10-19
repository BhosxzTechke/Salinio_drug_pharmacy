
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
                    <form method="POST" action="{{ route('backup.now') }}">
                        @csrf
                        <button class="btn btn-primary rounded-pill waves-effect waves-light">
                            Backup Now
                        </button>
                    </form>                                 
                
                </ol>

                                    </div>
                                    <h4 class="page-title">Backup Database Table</h4>
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
                                                    <th>File Name</th>
                                                    <th>Size</th>
                                                    <th>Path</th>
                                                    <th>Action</th>
                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>

                @php $sl = 1 @endphp
                    @foreach ($files as $data)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $data->getFilename() }}</td>
                        <td>{{ $data->getSize() }}</td>
                        <td>{{ $data->getPath() }}</td>
                        <td>
                            @if(Auth::user()->can('download-backup'))
                                <a href="{{ url($data->getFilename()) }}" class="btn btn-blue rounded-pill waves-effect waves-light">Download </a> 
                            @endif
                @if(Auth::user()->can('delete-backup'))
                    <a href="{{ url('backup/delete/'. $data->getFilename()) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>
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
                </footer> --}}
                <!-- end Footer -->

            </div>



        </div>
        <!-- END wrapper -->

@endsection
