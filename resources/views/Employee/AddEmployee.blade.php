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



                                                <form method="POST" action="{{ route('employee.store')}}" enctype="multipart/form-data" >
                                                  @csrf


                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Employee Info</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="mb-3">
                                                                <label for="firstname" class="">Employee Name</label>
                                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter first name">
                                                        
                                                                @error('name')
                                                          <span class="text-danger"> {{ $message }} </span>
                                                          @enderror 
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="lastname" class="">Employee Email</label>
                                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="lastname" placeholder="Enter Email">
                                                                     @error('email')
                                                                          <span class="text-danger"> {{ $message }} </span>
                                                                     @enderror
                                                              </div>
                                                        </div> <!-- end col -->
                                                <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="phone" class="">Employee Phone</label>
                                                                <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="lastname" placeholder="Enter Phone">
                                                                      @error('phone')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                            </div>
                                                        </div> <!-- end col -->

                                                         <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="phone" class="">Employee Address</label>
                                                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Enter Address">
                                                                      @error('address')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                            </div>
                                                        </div> <!-- end col -->




                                                                <div class="col-md-6">
                                                                      <div class="mb-3">
                                                                          <label for="firstname" class="form-label">Employee Experience    </label>
                                                                        <select name="experience" class="form-control @error('experience') is-invalid @enderror" id="example-select">
                                                                                  <option selected disabled>Select Year </option>
                                                                                  <option value="1 Year">1 Year</option>
                                                                                  <option value="2 Year">2 Year</option>
                                                                                  <option value="3 Year">3 Year</option>
                                                                                  <option value="4 Year">4 Year</option>
                                                                                  <option value="5 Year">5 Year</option>
                                                                              </select>
                                                                        @error('experience')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                      
                                                                      </div>
                                                                  </div>

                                                        <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="phone" class="form-label">Employee Salary</label>
                                                                <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" id="lastname" placeholder="Enter Salary">
                                                                      @error('salary')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                            </div>
                                                        </div> <!-- end col -->

                                                        
                                                        <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="phone" class="form-label">Employee Vacation</label>
                                                                <input type="text" name="vacation" class="form-control @error('vacation') is-invalid @enderror" id="lastname" placeholder="Enter Vacation">
                                                                      @error('vacation')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                            </div>
                                                        </div> <!-- end col -->



                                                        
                                                        <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="phone" class="form-label">Employee City</label>
                                                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="lastname" placeholder="Enter City">
                                                                      @error('city')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                            </div>
                                                        </div> <!-- end col -->




                                                        <div class="mb-3">
                                                        <label for="example-fileinput" class="form-label">Employee Image</label>
                                                        <input type="file" name="image" id="image" class="form-control  @error('image') is-invalid @enderror" >
                                                                       @error('image')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                              </div>


                                                          <div class="col-md-12">
                                                        <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label"> </label>
                                                                <img id="showImage" src="{{ url('uploads/noimage.png') }}" class="rounded-circle avatar-lg img-thumbnail"
                                                                        alt="profile-image">
                                                            </div>
                                                        </div> <!-- end col -->


                                                    </div> <!-- end row -->
    

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


                  <script type="text/javascript">
                    
                    $(document).ready(function(){
                      $('#image').change(function(e){
                        var reader = new FileReader();
                        reader.onload =  function(e){
                          $('#showImage').attr('src',e.target.result);
                        }
                        reader.readAsDataURL(e.target.files['0']);
                      });
                    });

                  </script>
                            




@endsection