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



                        <form method="POST" id="SupplierForm" action="{{ route('store.supplier')}}" enctype="multipart/form-data" >
                        @csrf


                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Supplier Info</h5>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group mb-3">
                                        <label for="name" class="">Supplier Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Supplier name">
                                
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="text" class="">Supplier Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Supplier Email">

                                        </div>
                                </div> <!-- end col -->


                                

                    <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="text" class="">Supplier Address</label>
                                        <input type="text" name="address" class="form-control" id="address" placeholder="Enter Supplier Address">
                    
                                    </div>
                                </div> <!-- end col -->



                        <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="">Supplier Phone</label>
                                        <input type="number" name="phone" class="form-control" id="phone" placeholder="Enter Supplier Phone">

                                    </div>
                                </div> <!-- end col -->






                        <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city" class="form-label">Supplier City</label>
                                        <input type="text" name="city" class="form-control" id="city" placeholder="Enter Supplier City">

                                    </div>
                                </div> <!-- end col -->






                                <div class="form-group mb-3">
                                <label for="example-fileinput" class="form-label">Supplier Image</label>
                                <input type="file" name="image" id="image" class="form-control" >

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




<script>
$(document).ready(function () {
    $('#SupplierForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 200
            },
            email: {
                required: true,
                email: true,
                maxlength: 200
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            city: {
                required: true,
                minlength: 2,
                maxlength: 100
            },
            address: {
                required: true,
                minlength: 5,
                maxlength: 400
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            name: {
                required: "Please enter the supplier's name",
                minlength: "Name must be at least 3 characters",
                maxlength: "Name can't be longer than 200 characters"
            },
            email: {
                required: "Please enter an email address",
                email: "Please enter a valid email address",
                maxlength: "Email can't be longer than 200 characters"
            },
            phone: {
                required: "Please enter a phone number",
                digits: "Phone number must contain only digits",
                minlength: "Phone number must be at least 10 digits",
                maxlength: "Phone number can't be longer than 15 digits"
            },
            city: {
                required: "Please enter the city",
                minlength: "City name must be at least 2 characters",
                maxlength: "City name can't be longer than 100 characters"
            },
            address: {
                required: "Please enter the address",
                minlength: "Address must be at least 5 characters",
                maxlength: "Address can't be longer than 400 characters"
            },
            image: {
                required: "Please upload a supplier image",
                extension: "Only JPG, JPEG, PNG, or WEBP formats are allowed"
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