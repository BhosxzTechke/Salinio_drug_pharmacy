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
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>
                    
                    <h4 class="page-title">Edit User</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->


  <div class="row">

            @php
                $superadminCount = \App\Models\User::role('Super Admin')->count();
                $superadminLimit = config('roles.superadmin_limit');
            @endphp

            <div class="alert alert-info">
                Superadmins: <strong>{{ $superadminCount }}</strong> / {{ $superadminLimit }}
            </div>

        <div class="col-lg-8 col-xl-12">
                <div class="card">
                    <div class="card-body">

                            <div class="tab-pane" id="settings">



        <form id="myForm" method="POST" action="{{ route('update.admin')}}" enctype="multipart/form-data" >
            @csrf

            <input name="id" type="hidden" value="{{ $user->id }}">

            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>User Info</h5>
            <div class="row">
                <div class="col-md-6">


                    <div class="form-group mb-3">
                        <label for="name" class="">Name</label>
                        <input type="text" value="{{ $user->name }}"  name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name">
                
                        @error('name')
                    <span class="text-danger"> {{ $message }} </span>
                    @enderror 
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="text" class="">Email</label>
                        <input type="email" value="{{ $user->email }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email">
                                @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                        </div>
                </div> <!-- end col -->





        <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="phone" class="">Phone</label>
                        <input type="number" value="{{ $user->phone }}" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Phone">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                    </div>
                </div> <!-- end col -->



                                        
<div class="col-md-3">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Assigned Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" id="example-select">
                            <option selected disabled >Select Role </option>
                            @foreach ($role as $data)

                            <option value="{{ $data->name }}" {{ $user->hasRole($data->name) ? 'selected' : '' }}
                              @if($data->name === 'Super Admin' && $superadminCount >= $superadminLimit) disabled
                               @endif> {{ $data->name }}</option>

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
            


                <hr>
                <h5 class="mb-3 text-uppercase"><i class="mdi mdi-lock-reset me-1"></i>Reset Password</h5>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="resetPasswordSwitch" name="reset_password" onchange="toggleConfirmPassword()">
                    <label class="form-check-label" for="resetPasswordSwitch">Reset this user's password</label>
                </div>

                <div id="adminPasswordConfirm" style="display: none;">
                    <div class="form-group mb-3">
                        <label for="admin_password">Your Password (to confirm reset)</label>
                        <input 
                            type="password" 
                            name="admin_password" 
                            class="form-control" 
                            id="admin_password" 
                            placeholder="Enter your admin password"
                            autocomplete="new-password"
                            value=""
                        >

                        @error('admin_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Changes</button>
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
    function toggleConfirmPassword() {
        const checkbox = document.getElementById('resetPasswordSwitch');
        const confirmBox = document.getElementById('adminPasswordConfirm');
        confirmBox.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>




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