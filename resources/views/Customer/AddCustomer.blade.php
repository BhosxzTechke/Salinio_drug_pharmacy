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
                                            <li class="breadcrumb-item active">Customer</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">CREATE CUSTOMER</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


                                        <div class="row">

                                                                <div class="col-lg-8 col-xl-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                            
                                                                                    <div class="tab-pane" id="settings">


                    <form method="POST" id="CustomerForm" action="{{ route('store.customer') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- 🔹 Global Error Messages --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops! There were some problems with your input.</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h5 class="mb-4 text-uppercase">
                            <i class="mdi mdi-account-circle me-1"></i> Customer Info
                        </h5>

                        <div class="row">
                            {{-- Customer Name --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Enter Customer name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Customer Email --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email">Customer Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Enter Customer Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Customer Address --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="address">Customer Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address"
                                        value="{{ old('address') }}"
                                        class="form-control @error('address') is-invalid @enderror"
                                        id="address" placeholder="Enter Customer Address">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Customer Phone --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Customer Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone"
                                        value="{{ old('phone') }}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" placeholder="Enter Customer Phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            {{-- Customer Image --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Customer Image</label>
                                    <input type="file" name="image"
                                        id="image" class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Image Preview --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <img id="showImages"
                                        src="{{ url('uploads/noimage.png') }}"
                                        class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">
                                </div>
                            </div>
                        </div> <!-- end row -->



                        <div class="text-end">
                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2">
                                <i class="mdi mdi-content-save"></i> Save Changes
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
                    $('#showImages').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
                });
            });

            </script>
                    


                            <script>
$(document).ready(function () {
    $('#CustomerForm').validate({
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
                minlength: 11,
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
        },
        messages: {
            name: {
                required: "Please enter the Customer's name",
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
                minlength: "Phone number must be at least 11 digits",
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