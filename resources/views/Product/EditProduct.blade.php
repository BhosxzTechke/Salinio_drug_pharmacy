
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
                                    
                                    <h4 class="page-title">Edit Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



<form method="POST" action="{{ route('update.product') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ $product->id }}">
    <input type="hidden" name="old_image" value="{{ $product->product_image }}">

    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Product</h5>
    <div class="row">

        {{-- Product Name --}}
        <div class="col-md-6 mb-3">
            <label for="product_name">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                   value="{{ old('product_name', $product->product_name) }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Product Code (readonly) --}}
        <div class="col-md-6 mb-3">
            <label for="product_code">Product Code</label>
            <input type="text" name="product_code" class="form-control"
                   value="{{ old('product_code', $product->product_code) }}" readonly>
        </div>

        {{-- Category --}}
        <div class="col-md-6 mb-3">
            <label for="category_id">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option selected disabled>Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Subcategory --}}
        <div class="col-md-6 mb-3">
            <label for="subcategory_id">Subcategory <span class="text-danger">*</span></label>
            <select name="subcategory_id" id="subcategory_id" class="form-control @error('subcategory_id') is-invalid @enderror">
                <option selected disabled>Select Subcategory</option>
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            </select>
            @error('subcategory_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Brand --}}
        <div class="col-md-6 mb-3">
            <label for="brand_id">Brand <span class="text-danger">*</span></label>
            <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Dosage Form --}}
        <div class="col-md-6 mb-3">
            <label for="dosage_form">Dosage Form <span class="text-danger">*</span></label>
            <select name="dosage_form" class="form-control @error('dosage_form') is-invalid @enderror">
                @php $dosageOptions = ['Tablet','Capsule','Syrup','Cream','Ointment']; @endphp
                @foreach($dosageOptions as $option)
                    <option value="{{ $option }}" {{ old('dosage_form', $product->dosage_form) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            @error('dosage_form')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Target Gender --}}
        <div class="col-md-6 mb-3">
            <label for="target_gender">Target Gender <span class="text-danger">*</span></label>
            <select name="target_gender" class="form-control @error('target_gender') is-invalid @enderror">
                @php $genderOptions = ['Unisex','Male','Female']; @endphp
                @foreach($genderOptions as $option)
                    <option value="{{ $option }}" {{ old('target_gender', $product->target_gender) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            @error('target_gender')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Age Group --}}
        <div class="col-md-6 mb-3">
            <label for="age_group">Age Group <span class="text-danger">*</span></label>
            <select name="age_group" class="form-control @error('age_group') is-invalid @enderror">
                @php $ageOptions = ['All','Kids','Adults','Seniors']; @endphp
                @foreach($ageOptions as $option)
                    <option value="{{ $option }}" {{ old('age_group', $product->age_group) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            @error('age_group')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Health Concern --}}
        <div class="col-md-6 mb-3">
            <label for="health_concern">Health Concern</label>
            <input type="text" name="health_concern" class="form-control @error('health_concern') is-invalid @enderror"
                   value="{{ old('health_concern', $product->health_concern) }}">
            @error('health_concern')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Selling Price --}}
        <div class="col-md-6 mb-3">
            <label for="selling_price">Selling Price <span class="text-danger">*</span></label>
            <input type="text" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
                   value="{{ old('selling_price', $product->selling_price) }}">
            @error('selling_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Prescription Required --}}
        <div class="col-md-6 mb-3">
            <label for="prescription_required">Prescription Required <span class="text-danger">*</span></label>
            <select name="prescription_required" class="form-control @error('prescription_required') is-invalid @enderror">
                <option value="0" {{ old('prescription_required', $product->prescription_required) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('prescription_required', $product->prescription_required) == 1 ? 'selected' : '' }}>Yes</option>
            </select>
            @error('prescription_required')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="col-md-12 mb-3">
            <label for="description">Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Expiration Switch --}}
        <div class="form-check form-switch mb-3">
            <input type="checkbox" class="form-check-input" id="has_expiration" name="has_expiration"
                   value="1" {{ old('has_expiration', $product->has_expiration) == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="has_expiration">Has Expiration</label>
        </div>

        {{-- Product Image --}}
        <div class="col-md-6 mb-3">
            <label for="product_image">Product Image <span class="text-danger">*</span></label>
            <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror">
            @error('product_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Current Image --}}
        <div class="col-md-6 mb-3">
            <label>Current Image</label>
            <img src="{{ $product->product_image ? asset($product->product_image) : url('uploads/noimage.png') }}"
                 class="rounded-circle avatar-lg img-thumbnail" alt="product-image">
        </div>

    </div> <!-- end row -->

    <div class="text-end">
        <button type="submit" class="btn btn-success">Update Product</button>
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
                url: '/product/edit/' + category_id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#subcategory_id').empty().append('<option selected disabled>Select Subcategory</option>');
                    $.each(data, function (key, value) {
                        $('#subcategory_id').append(
                            '<option value="' + value.id + '">' + value.name + '</option>'
                        );
                    });
                }
            });
        } else {
            $('#subcategory_id').empty().append('<option selected disabled>Select Subcategory</option>');
        }
    });
</script>




@endsection