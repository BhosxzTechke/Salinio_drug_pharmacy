@extends('admin_dashboard')
@section('admin')
>


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



                                                <form method="POST" action="{{ route('update.category') }}"  >
                                                  @csrf
                                                  @method('PUT')

                                                  <input type="hidden" name="id" value="{{ $CatData->id }}">


                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Category Info</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="mb-3">
                                                                <label for="name" class="">Category Name</label>
                                                                <input type="text" name="name" value="{{ $CatData->category_name }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Customer name">
                                                        
                                                                @error('name')
                                                          <span class="text-danger"> {{ $message }} </span>
                                                          @enderror 
                                                            </div>
                                                        </div>


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

                            




@endsection