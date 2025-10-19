@extends('admin_dashboard')
@section('admin')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



                                                <form method="POST" action="{{ route('salary.store') }}" >
                                                  @csrf


                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Employee Salary Form</h5>
                                                    <div class="row">
           

                                                                <div class="col-md-6">
                                                                      <div class="mb-3">
                                                                          <label for="name" class="form-label">Employee Name</label>
                                                                        <select name="employeeID" class="form-control @error('experience') is-invalid @enderror" id="example-select">
                                                                                  <option selected disabled >Select Year </option>
                                                                                  @foreach ($Employee as $data)

                                                                                  <option value="{{ $data->id }}">{{ $data->name }}</option>

                                                                            @endforeach
                                                                              </select>
                                                                        @error('experience')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                      
                                                                      </div>
                                                                  </div>

                                                                  
                                                                <div class="col-md-6">
                                                                      <div class="mb-3">
                                                                          <label for="month" class="form-label">Salary Month</label>
                                                                        <select name="month" class="form-control @error('month') is-invalid @enderror" id="example-select">
                                                                                <option selected disabled >Select Year </option>
                                                                                <option value="january">January</option>
                                                                                <option value="february">February</option>
                                                                                <option value="march">March</option>
                                                                                <option value="april">April</option>
                                                                                <option value="may">May</option>
                                                                                <option value="june">June</option>
                                                                                <option value="july">July</option>
                                                                                <option value="august">August</option>
                                                                                <option value="september">September</option>
                                                                                <option value="october">October</option>
                                                                                <option value="november">November</option>
                                                                                <option value="december">December</option>



                                                                              </select>
                                                                        @error('month')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                      
                                                                      </div>
                                                                  </div>


                                                            <div class="col-md-6">
                                                                      <div class="mb-3">
                                                                          <label for="year" class="form-label">Salary Year</label>
                                                                        <select name="year" class="form-control @error('year') is-invalid @enderror" id="example-select">
                                                                                <option selected disabled >Select Year </option>
                                                                                <option value="2025">2025</option>
                                                                                <option value="2026">2026</option>
                                                                                <option value="2027">2027</option>
                                                                                <option value="2028">2028</option>
                                                                                <option value="2029">2029</option>
                                                                                <option value="2030">2030</option>

                                                                              </select>
                                                                        @error('year')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                      
                                                                      </div>
                                                                  </div>





                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="lastname" class="">Advanced Salary</label>
                                                                <input type="number" name="advance_salary" class="form-control @error('advance_salary') is-invalid @enderror" id="advance_salary" placeholder="Enter Adanced Salary">
                                                                     @error('advance_salary')
                                                                          <span class="text-danger"> {{ $message }} </span>
                                                                     @enderror
                                                              </div>
                                                        </div> <!-- end col -->





                                                    <div class="text-end">
                                                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save Changes</button>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            <!-- end settings content-->
    
                                    </div>
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->


                            




@endsection