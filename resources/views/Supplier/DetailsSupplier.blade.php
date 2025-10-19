



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

{{-- 

                                                <form method="POST" action="" enctype="multipart/form-data" >
                                                  @csrf --}}


                                                  <input type="hidden" name="id" value="{{ $supplier->id }}">


                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Supplier Info</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="mb-3">
                                                                <label for="name" class="">Supplier Name</label>
                                                                <p class="text-danger">{{ $supplier->name }} </p>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Email</label>
                                                                <p class="text-danger">{{ $supplier->email }}</p>

                                                              </div>
                                                        </div> <!-- end col -->


                                                        

                                            <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="text" class="">Supplier Address</label>
                                                                <p class="text-danger">{{ $supplier->address }}</p>
 
                                                            </div>
                                                        </div> <!-- end col -->



                                                <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="phone" class="">Supplier Phone</label>
                                                                <p class="text-danger">{{ $supplier->phone }}</p>

                                                            </div>
                                                        </div> <!-- end col -->


                                                        
                                                 <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Shop Name</label>
                                                                <p class="text-danger">{{ $supplier->shopname }}</p>

                                                            </div>
                                                        </div> <!-- end col -->


                                                          <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Type</label>
                                                                <p class="text-danger">{{ $supplier->type }}</p>

                                                            </div>
                                                        </div> <!-- end col -->



                                                       <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Account holder</label>
                                                                <p class="text-danger">{{ $supplier->account_holder }}</p>

                                                            </div>
                                                        </div> <!-- end col -->

                                                        
                                                       <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="phone" class="">Supplier Account Number</label>
                                                                <p class="text-danger">{{ $supplier->account_number }}</p>

                                                            </div>
                                                        </div> <!-- end col -->


                                                                                                                
                                                       <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Bank Name</label>
                                                                <p class="text-danger">{{ $supplier->bank_name }}</p>

                                                            </div>
                                                        </div> <!-- end col -->


                                                        
                                                       <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Supplier Branch Name</label>
                                                                <p class="text-danger">{{ $supplier->bank_branch }}</p>

                                                            </div>
                                                        </div> <!-- end col -->






                                                <div class="col-md-6">
                                                           <div class="mb-3">
                                                                <label for="city" class="form-label">Supplier City</label>
                                                                <p class="text-danger">{{ $supplier->city }}</p>

                                                            </div>
                                                        </div> <!-- end col -->

                    
                        



                                                        {{-- <div class="mb-3">
                                                        <label for="example-fileinput" class="form-label">Customer Image</label>
                                                        <input type="file" name="image" id="image" class="form-control  @error('image') is-invalid @enderror" >
                                                                       @error('image')
                                                                          <span class="text-danger">{{ $message }}</span>
                                                                      @enderror
                                                              </div>

                                                          <div class="col-md-12"> --}}
                                                        <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label">Customer Image</label>
                                                                <img id="showImage" src="{{ (!empty($supplier->image)) ? url($supplier->image) : url('uploads/noimage.png') }}" class="rounded-circle avatar-lg img-thumbnail">
                                                            </div>
                                                        </div> <!-- end col -->


                                                    </div> <!-- end row -->
    

                                                    <div class="text-end">
                                                        <a href="{{ route('all.supplier')}}"><button type="" name="" class="btn btn-info waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Back </button></a>
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