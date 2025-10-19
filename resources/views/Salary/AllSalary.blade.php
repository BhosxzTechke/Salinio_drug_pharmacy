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
                                           <a href=""><button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Add Employee</button></a>
                                        </ol>

                                    </div>
                                    <h4 class="page-title">Datatables</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Employee Data Table</h4>


                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Salary</th>
                                                    <th>Status</th>
                                                    <th>Advance Salary</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>

                                                          @php $sl = 1 @endphp
                                                                        @foreach($SalaryData as $key=> $item)
                                                                        <tr>
                                                                            <td>{{ $key+1 }}</td>
                                                                            <td> <img src="{{ asset($item->employee->image) }}" style="width:50px; height: 40px;"> </td>
                                                                            <td>{{ $item['employee']['name'] }}</td>
                                                                            <td>{{ $item->month }}</td>
                                                                            <td>{{ $item['employee']['salary'] }}</td>
                                                                          

                                                                             <td>
                                                                                @if($employee->is_paid)
                                                                                    <span class="badge bg-success">Paid</span>
                                                                                @else
                                                                                    <span class="badge bg-danger">Not Paid</span>
                                                                                @endif
                                                                                </td>


                                                                                    <td>
                                                                                @if($item->advance_salary == NULL )
                                                                                    <p>No Advance</p>
                                                                                @else
                                                                                {{ $item->advance_salary }}
                                                                                @endif

                                                                            </td>
                                                                            <td>                
                                                           <a href="{{ route('salary.edit', $item->id ) }}" class="btn btn-success rounded-pill waves-effect waves-light" title="Edit"><i class="fa-solid fa-square-pen"></i> Edit</a>
                                                        <a href="{{ route('salary.delete', $item->id ) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>

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
