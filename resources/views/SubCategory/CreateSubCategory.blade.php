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
                                            <li class="breadcrumb-item active">Sub-Category</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Sub-Category Form</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

            <div class="col-lg-8 col-xl-6">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



                <form method="POST" id="SubCatForm" action="{{ route('sub-category.store')}}" enctype="multipart/form-data" >
                    @csrf

                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Sub Category Info</h5>
                    <div class="row">


                        <div class="col-md-9">

                            <div class="form-group mb-3">
                                <label for="brand" class="">Sub-Category Name</label>
                                <input type="text" name="name" class="form-control @error('sub-category') is-invalid @enderror" id="sub-category" placeholder="Enter Sub-Category name">
                        
                                @error('sub-category')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>
                        </div>



                            <div class="col-md-9">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Category Name</label>
                                <select name="category_id" class="form-control @error('category') is-invalid @enderror" id="example-select">
                                            <option selected disabled >Select Category </option>
                                            @foreach ($categories as $data)

                                            <option value="{{ $data->id }}">{{ $data->category_name }}</option>

                                    @endforeach
                                        </select>

                                        
                                @error('category')
                                    <span class="text-danger">{{ $message }}</span>
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


<script>
$(document).ready(function () {
    $('#SubCatForm').validate({
        rules: {
            name: {
                required: true,
                maxlength: 100
            },
            category_id: {
                required: true,
                maxlength: 100
            }
        },
        messages: {
            name: {
                required: "Please enter a Sub Category name",
                maxlength: "Sub Category name cannot be more than 100 characters"
            },
            logo: {
                required: "Please enter a Category name",
                maxlength: "Category name cannot be more than 100 characters"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>


@endsection