
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
                                            <li class="breadcrumb-item active">Product</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Add Product</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



<form id="myForm" method="POST" action="{{ route('store.product') }}" enctype="multipart/form-data">
    @csrf

    <h5 class="mb-4 text-uppercase">
        <i class="mdi mdi-account-circle me-1"></i> Product Info
    </h5>
    <div class="row">
        {{-- Product Name --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name"
                        class="form-control @error('product_name') is-invalid @enderror"
                        id="product_name" placeholder="Enter Product name">
                @error('product_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Category --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select name="category_id"
                        class="form-control @error('category_id') is-invalid @enderror"
                        id="category_id">
                    <option selected disabled>Select Category</option>
                    @foreach ($cat as $data)
                        <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Subcategory --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="subcategory_id">Subcategory</label>
                <select name="subcategory_id" class="form-control" id="subcategory_id">
                    <option selected disabled>Select Subcategory</option>
                    @foreach ($sub as $data)
                        <option value="{{ $data->id }}">{{ $data->subcategory_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>




        {{-- Brand --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="brand_id">Brand</label>
                <select name="brand_id"
                        class="form-control @error('brand_id') is-invalid @enderror"
                        id="brand_id">
                    <option selected disabled>Select Brand</option>
                    @foreach ($brand as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>



        {{-- Dosage Form --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="dosage_form">Dosage Form</label>
                <select name="dosage_form" class="form-control" id="dosage_form">
                    <option selected disabled>Select Dosage</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Capsule">Capsule</option>
                    <option value="Syrup">Syrup</option>
                    <option value="Cream">Cream</option>
                    <option value="Ointment">Ointment</option>
                </select>
            </div>
        </div>

        {{-- Target Gender --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="target_gender">Target Gender</label>
                <select name="target_gender" class="form-control" id="target_gender">
                    <option selected disabled>Select Gender</option>
                    <option value="Unisex">Unisex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>



        {{-- Age Group --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="age_group">Age Group</label>
                <select name="age_group" class="form-control" id="age_group">
                    <option selected disabled>Select Age Group</option>
                    <option value="All">All</option>
                    <option value="Kids">Kids</option>
                    <option value="Adults">Adults</option>
                    <option value="Seniors">Seniors</option>
                </select>
            </div>
        </div>

        {{-- Health Concern --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="health_concern">Health Concern</label>
                <input type="text" name="health_concern" class="form-control" id="health_concern">
            </div>
        </div>





        {{-- Selling Price --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="selling_price">Selling Price</label>
                <input type="text" name="selling_price" class="form-control" id="selling_price" required>
            </div>
        </div>




        {{-- Prescription Required --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="prescription_required">Prescription Required</label>
                <select name="prescription_required" class="form-control" id="prescription_required">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>

        <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="has_expiration" name="has_expiration" value="1" checked>
                    <label class="form-check-label" for="has_expiration">Has Expiration</label>
                </div>





        {{-- Description --}}
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="3" id="description"></textarea>
            </div>
        </div>

        {{-- Product Image --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="image">Product Image</label>
                <input type="file" name="product_image" id="image" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label>Preview</label>
                <img id="showImage" src="{{ url('uploads/noimage.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
            </div>
        </div>

    </div> <!-- end row -->

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> Save Product
        </button>
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
                            
<script type="text/javascript">
$(document).ready(function () {
    $('#myForm').validate({
        rules: {
            product_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            category_id: {
                required: true
            },
            subcategory_id: {
                required: true
            },
            brand_id: {
                required: true
            },
            dosage_form: {
                required: true
            },
            age_group: {
                required: true
            },
            target_gender: {
                required: true
            },
            health_concern: {
                required: true
            },
            prescription_required: {
                required: true
            },
            description: {
                required: true,
                minlength: 10
            },
            selling_price: {
                required: true,
                number: true,
                min: 0
            },
            product_image: {
                required: true,
                extension: "jpg|jpeg|png|webp"
            }
        },

        messages: {
            product_name: {
                required: 'Please enter product name',
                minlength: 'Product name must be at least 3 characters',
                maxlength: 'Product name must not exceed 100 characters'
            },
            category_id: {
                required: 'Please select a category'
            },
            subcategory_id: {
                required: 'Please select a subcategory'
            },
            brand_id: {
                required: 'Please select a brand'
            },
            dosage_form: {
                required: 'Please select a dosage form'
            },
            age_group: {
                required: 'Please select an age group'
            },
            target_gender: {
                required: 'Please select a target gender'
            },
            health_concern: {
                required: 'Please select a health concern'
            },
            prescription_required: {
                required: 'Please select if prescription is required'
            },
            description: {
                required: 'Please enter a description',
                minlength: 'Description must be at least 10 characters'
            },
            selling_price: {
                required: 'Please enter a selling price',
                number: 'Please enter a valid number',
                min: 'Price cannot be negative'
            },
            product_image: {
                required: 'Please select a product image',
                extension: 'Only image files (jpg, jpeg, png, webp) are allowed'
            }
        },

        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                element.closest('.form-group').append(error);
            } else {
                element.closest('.form-group').append(error);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#category_id').on('change', function () {
            var category_id = $(this).val();

            if (category_id) {
                $.ajax({
                    url: '/get-subcategories/' + category_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#subcategory_id').empty().append('<option selected disabled>Select Subcategory</option>');

                        $.each(data, function (key, value) {
                            $('#subcategory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory_id').empty().append('<option selected disabled>Select Subcategory</option>');
            }
        });
    </script>



@endsection