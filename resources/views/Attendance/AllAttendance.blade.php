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
                                            @if(Auth::user()->can('add-attendance'))
                                            <a href="{{ route('employee.add.attendance')}}"><button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Add Attendance</button></a>
                                            @endif
                                        </ol>

                                    </div>
                                    <h4 class="page-title">All Attendance Employee</h4>
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
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
            <tbody>

                            @php $sl = 1 @endphp
                                        @foreach($AttendanceData as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>       
                        @if(Auth::user()->can('edit-attendance'))        
                        <a href="{{ route('employee.attendance.edit', $item->date ) }}" class="btn btn-success rounded-pill waves-effect waves-light" title="Edit"><i class="fa-solid fa-square-pen"></i> Edit</a>
                        @endif
                        
                        @if(Auth::user()->can('view-attendance'))
                        <a href="{{ route('employee.attendance.view', $item->date )}}" class="btn btn-info rounded-pill waves-effect waves-light" id="view"  title="view Data"><i class="fa-regular fa-eye"></i> View</a>
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
