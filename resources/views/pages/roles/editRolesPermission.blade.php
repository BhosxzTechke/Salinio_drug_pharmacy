@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


<style class="text/css">
    .form-check-label {
        margin-left: 0.5em;
    }
    .form-check {
        margin-bottom: 1rem;
    }
    .form-check-primary .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
    .form-check-label{
        text-transform: capitalize;
    }

</style>

 <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Edit Role Permission</a></li>
                                            
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Edit Role Permission</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

<div class="row">
    

  <div class="col-lg-8 col-xl-12">
<div class="card">
    <div class="card-body">
                                    
                                      
                                         
                                           

    <!-- end timeline content-->

    <div class="tab-pane" id="settings">
        <form id="myForm" method="post" action="{{ route('role.permission.update', $roles->id) }}" enctype="multipart/form-data">
            @csrf


            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Role Permission</h5>

            <div class="row">


<div class="col-md-6">
    <div class="form-group mb-3">
        <span class="badge bg-primary fs-5 py-2 px-3">

            {{ $roles->name }}
        </span>
    </div>
</div>

    <div class="col-md-9">
        <div class="form-check mb-2 form-check-primary">

        
            <input class="form-check-input" type="checkbox" value="" id="custome_selectAll" >
            <label class="form-check-label"  for="custome_selectAll">Select All</label>
    </div>     

   </div> <!-- end row -->
            
    <br>
    <br>
    

    @foreach ($permissionGroups as $group)
        <div class="row">
            <div class="col-3">



    @php

        $permissions = App\Models\User::getPermissionByGroup($group->group_name);

        // Like CATEGORY , EMPLOYEE , SUPPLIER  
    @endphp

                            
                <div class="form-check mb-2 form-check-primary">

        {{-- Checked Category , Supplier --}}
        <input class="form-check-input rounded-circle" type="checkbox" value=""
            id="customckeck1" {{ App\Models\User::roleHasPermissions($roles, $permissions) ? 'checked' : ''}} >
        <label class="form-check-label"  for="customckeck1">{{ $group->group_name }}</label>
    </div>  
</div>




               
    <div class="col-md-9">
        @foreach ($permissions as $permission)
        <div class="form-check mb-2 form-check-primary">
                <input class="form-check-input rounded-circle" type="checkbox" name="permission[]" 
                {{ $roles->hasPermissionTo($permission->name) ? 'checked' : '' }}
                value="{{ $permission->name }}" id="customcheck{{ $permission->id }} ">
                <label class="form-check-label" for="customcheck{{ $permission->id }}">{{ $permission->name }}</label>
        </div>
        @endforeach 
            <br>
        
    </div>

                    
                </div>

@endforeach

           


            </div> <!-- end row -->
 
        
            
            <div class="text-end">
                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                group_name: {
                    required : true,
                }, 
                
            },
            messages :{
                name: {
                    required : 'Please Enter Permission Name',
                }, 
                group_name: {
                    required : 'Please Select Group Name',
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




<script type="text/javascript">
        $('#custome_selectAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[type= checkbox').prop('checked', true);
            } else {
                $('input[type= checkbox]').prop('checked', false);
            }
        });
    
    </script>



@endsection