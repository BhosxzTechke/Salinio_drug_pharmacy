
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
                                    <h4 class="page-title">Employee Pay Salary</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                         <h4 class="header-title">{{ date("F Y")}}</h4>


                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Salary</th>
                                                    <th>Advanced</th>
                                                    <th>due</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                             @foreach ($EmployeeData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td><img src="{{ asset($data->Employee->image ?? 'No Employee') }}" style="height: 3rem" ></td>
                                                    <td>{{ $data->name }}</td>
                                                    <td><span class="badge bg-info">{{ date("F", strtotime('-1 month') )}}</span></td>
                                                    <td>{{ $data->salary }}</td>


                                            <td>
                                                @if(optional($data->advance)->advance_salary == null)
                                                    <p>No Advance</p>
                                                @else
                                                    {{ $data->advance->advance_salary }}
                                                @endif
                                            </td>


                                                  <td>
                                                      <strong style="color: #1f0707;">
                                                          {{ round($data->salary - (optional($data->advance)->advance_salary ?? 0)) }}
                                                      </strong>
                                                  </td>


                                                    <td>    
                                                              <a href="{{ route('pay.salary.form', $data->id) }}" class="btn btn-success rounded-pill" title="Pay">
                                                                  <i class="fa-solid fa-square-pen"></i> Pay
                                                              </a>
                                                         

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
