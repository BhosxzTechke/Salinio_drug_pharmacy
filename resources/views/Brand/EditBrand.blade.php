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



                <form method="POST" action="{{ route('update.brand')}}" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $brand->id }}">

                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Brand Info</h5>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="brand" class="">Brand Name</label>
                                <input type="text" value="{{ $brand->name }}" name="name" class="form-control @error('brand') is-invalid @enderror" id="brand" placeholder="Enter brand name">
                        
                                @error('brand')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>
                        </div>




                        <div class="mb-3">
                        <label for="example-fileinput" class="form-label">Brand Logo Image</label>
                        <input type="file" value="{{ $brand->logo }}" name="image" id="image" class="form-control  @error('image') is-invalid @enderror" >
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>



               <div class="row mb-3">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Blog Description </label>
                                <div class="col-sm-10">
                                <textarea id="elm1" name="blog_description">{{ $brand->description }}
                                    
                                </textarea>
                         </div>
            </div>



                            <div class="col-md-12">
                        <div class="mb-3">
                                <label for="example-fileinput" class="form-label"> </label>
                                <img id="showImage" src="{{ !empty($brand->logo) ? asset($brand->logo) : asset('uploads/brand_image') }}" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="Brand-image">

                                        
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