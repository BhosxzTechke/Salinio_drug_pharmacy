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
                                            <li class="breadcrumb-item active">Business Name</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Update Business Name</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

        <div class="col-lg-8 col-xl-12">
                <div class="card">
                    <div class="card-body">

                            <div class="tab-pane" id="settings">



                <form method="POST" action="{{ route('businesstitle.update')}}"  >
                    @csrf


                    <input type="hidden" name="id" value="{{ $businessTitle->id }}">


                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Business Name Info</h5>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="brand" class="">Business Title Name</label>
                                <input type="text" value="{{ $businessTitle->business_name }}" name="business_name" class="form-control @error('brand') is-invalid @enderror" id="brand" placeholder="Enter Business name">
                        
                                @error('brand')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>
                        </div>


                    </div> <!-- end row -->
    
                            @if(Auth::user()->can('change-business-name'))
                            <div class="text-end">
                                <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Changes</button>
                            </div>
                            @endif

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