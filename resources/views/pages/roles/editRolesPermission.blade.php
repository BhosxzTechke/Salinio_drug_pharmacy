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



{{-- Select All --}}
<div class="col-md-9">
    <div class="form-check mb-2 form-check-primary">
        <input class="form-check-input" type="checkbox" id="custome_selectAll">
        <label class="form-check-label" for="custome_selectAll">Select All</label>
    </div>     
</div>





            
    <br>
    <br>
    

@foreach ($permissionGroups as $group)
    <div class="row">
        <div class="col-3">
            @php
                $permissions = App\Models\User::getPermissionByGroup($group->group_name);
            @endphp

            <div class="form-check mb-2 form-check-primary">
                <input 
                    class="form-check-input rounded-circle group-checkbox" 
                    type="checkbox" 
                    id="group_{{ Str::slug($group->group_name) }}" 
                    data-group="{{ Str::slug($group->group_name) }}"
                    {{ App\Models\User::roleHasPermissions($roles, $permissions) ? 'checked' : ''}}
                >
                <label class="form-check-label" for="group_{{ Str::slug($group->group_name) }}">{{ $group->group_name }}</label>
            </div>  
        </div>  





<div class="col-md-9">
                                @php
                                    $groupSlug = Str::slug($group->group_name);
                                @endphp

                                @foreach ($permissions as $permission)
                                    @php
                                        $permSlug = Str::slug($permission->name); 
                                    @endphp
                                    <div class="form-check mb-2 form-check-primary">
                                        <input 
                                            class="form-check-input rounded-circle permission-checkbox"
                                            type="checkbox"
                                            name="permission[]" 
                                            value="{{ $permission->name }}"
                                            id="perm_{{ $permSlug }}"
                                            data-group="{{ $groupSlug }}"
                                            {{ $roles->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="perm_{{ $permSlug }}">
                                            {{ $permission->name }}
                                        </label>
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



<script type="text/javascript">
$(document).ready(function () {

    // Select All
    $('#custome_selectAll').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('input[type=checkbox]').prop('checked', isChecked).prop('indeterminate', false);
    });



    // Group checkbox → select all its permissions
    $('.group-checkbox').on('change', function () {
        const groupId = $(this).data('group');
        const isChecked = $(this).is(':checked');
        $(`.permission-checkbox[data-group="${groupId}"]`).prop('checked', isChecked);
        $(this).prop('indeterminate', false);
        updateSelectAll();
    });

    // Permission checkbox → update group checkbox
    $('.permission-checkbox').on('change', function () {
        const groupId = $(this).data('group');
        const groupPermissions = $(`.permission-checkbox[data-group="${groupId}"]`);
        const checkedCount = groupPermissions.filter(':checked').length;

        const groupCheckbox = $(`#group_${groupId}`);
        if (checkedCount === 0) {
            groupCheckbox.prop('checked', false).prop('indeterminate', false);
        } else if (checkedCount === groupPermissions.length) {
            groupCheckbox.prop('checked', true).prop('indeterminate', false);
        } else {
            groupCheckbox.prop('checked', false).prop('indeterminate', true);
        }

        updateSelectAll();
    });

    // Update Select All status
    function updateSelectAll() {
        const totalPermissions = $('.permission-checkbox').length;
        const checkedPermissions = $('.permission-checkbox:checked').length;
        const selectAll = $('#custome_selectAll');

        if (checkedPermissions === 0) {
            selectAll.prop('checked', false).prop('indeterminate', false);
        } else if (checkedPermissions === totalPermissions) {
            selectAll.prop('checked', true).prop('indeterminate', false);
        } else {
            selectAll.prop('checked', false).prop('indeterminate', true);
        }
    }

    // Initialize indeterminate states on page load
    $('.group-checkbox').each(function() {
        const groupId = $(this).data('group');
        const groupPermissions = $(`.permission-checkbox[data-group="${groupId}"]`);
        const checkedCount = groupPermissions.filter(':checked').length;

        if (checkedCount > 0 && checkedCount < groupPermissions.length) {
            $(this).prop('indeterminate', true);
        }
    });

    updateSelectAll();
});
</script>


@endsection