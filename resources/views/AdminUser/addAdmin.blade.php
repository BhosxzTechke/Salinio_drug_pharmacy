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
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                    
                    <h4 class="page-title">Users</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->


  <div class="row">

        <div class="col-lg-8 col-xl-12">
                <div class="card">
                    <div class="card-body">

                            <div class="tab-pane" id="settings">



<form id="myForm" method="POST" action="{{ route('Store.admin')}}" enctype="multipart/form-data">
    @csrf

    <h5 class="mb-4 text-uppercase">
        <i class="mdi mdi-account-circle me-1"></i>User Info
    </h5>

    <div class="row">



        @php
                $superadminCount = \App\Models\User::role('Super Admin')->count();
                $superadminLimit = config('roles.superadmin_limit');
            @endphp

            <div class="alert alert-info">
                Superadmins: <strong>{{ $superadminCount }}</strong> / {{ $superadminLimit }}
            </div>



        <!-- Name -->
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text"  
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       placeholder="Enter User name" 
                       required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror 
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       placeholder="Enter User Email" 
                       required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Hidden Default Password -->
        <input type="hidden" name="password" value="12345678">

        <!-- Phone -->
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="phone">Phone <span class="text-danger">*</span></label>
                <input type="number" 
                       name="phone" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" 
                       placeholder="Enter User Phone" 
                       required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Role -->
        <div class="col-md-3">
            <div class="form-group mb-3">
                <label for="role" class="form-label">Assigned Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option selected disabled>Select Role</option>
                    @foreach ($role as $data)
                        <option value="{{ $data->name }}" 
                            @if($data->name === 'Super Admin' && $superadminCount >= $superadminLimit) disabled @endif>
                            {{ $data->name }}
                            @if($data->name === 'Super Admin' && $superadminCount >= $superadminLimit)
                                (Limit Reached)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>



        {{-- <!-- Notice about default password -->
        <div class="col-12">
            <div class="alert alert-warning p-2">
                <strong>Default Password:</strong> <code>12345678</code><br>
                For security reasons, the user will be required to change this password after their first login.
            </div>
        </div>
    </div> <!-- end row --> --}}

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
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
            });
        });

        </script>


                  <script type="text/javascript">
$(document).ready(function (){
$('#myForm').validate({
rules: {
name: {
required : true,
},
email: {
required : true,
},
phone: {
required : true,
},
role: {
required : true,
},



},
messages :{
name: {
required : 'Please Enter Name',
},
email: {
required : 'Please Select Email',
},
phone: {
required : 'Please Select Phone',
},
role: {
required : 'Please Enter User Role',
},


  },
        errorElement : 'span',
        errorPlacement: function (error,element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight : function(element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight : function(element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        },
    });
});


</script>


                          



@endsection