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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Add Role Permission</a></li>
                                            
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Role Permission</h4>
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
        <form id="permissionForm" method="post" action="{{ route('role.permission.store') }}" enctype="multipart/form-data">
            @csrf

            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Role Permission</h5>

            <div class="row">


    {{-- <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="firstname" class="form-label">Permission Name</label>
            <input type="text" name="name" class="form-control"   >
           
        </div>
    </div> --}}


   <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="firstname" class="form-label">Role Name </label>

            <select name="role_id" class="form-select" id="example-select">
                <option selected disabled>Select Role</option>
                @foreach($roles as $item)
                    @if($item->name !== 'Super Admin')
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endif
                @endforeach
            </select>

        </div>
    </div>


    

<div class="col-md-9 mb-3">
    <div class="form-check mb-2 form-check-primary">
        <input class="form-check-input" type="checkbox" id="custome_selectAll">
        <label class="form-check-label" for="custome_selectAll">Select All</label>
    </div>
</div>

@foreach ($permissionGroups as $group)
    @php $groupSlug = \Illuminate\Support\Str::slug($group->group_name); @endphp
    <div class="row mb-3">
        <div class="col-3">
            <div class="form-check mb-2 form-check-primary">
                <input 
                    class="form-check-input group-checkbox" 
                    type="checkbox" 
                    id="group_{{ $groupSlug }}">
                <label class="form-check-label" for="group_{{ $groupSlug }}">{{ $group->group_name }}</label>
            </div>
        </div>

        @php
            $permissions = \App\Models\User::getPermissionByGroup($group->group_name);
        @endphp

        <div class="col-md-9">
            @foreach ($permissions as $permission)
                @php $permSlug = \Illuminate\Support\Str::slug($permission->name); @endphp
                <div class="form-check mb-2 form-check-primary">
                    <input 
                        class="form-check-input permission-checkbox" 
                        type="checkbox" 
                        name="permission[]" 
                        value="{{ $permission->id ?? $permSlug }}" 
                        id="perm_{{ $permSlug }}" 
                        data-group="{{ $groupSlug }}">
                    <label class="form-check-label" for="perm_{{ $permSlug }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach









<div class="text-end">
    <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
        <i class="mdi mdi-content-save"></i> Save
    </button>
</div>




                         <br>
                        
                    </div>

                    
                </div>


           


            </div> <!-- end row -->
 
        
        
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
document.getElementById('permissionForm').addEventListener('submit', function (event) {
    const checkboxes = document.querySelectorAll('.group-checkbox');
    const isChecked = Array.from(checkboxes).some(cb => cb.checked);

    // Remove old error message if it exists
    let errorEl = document.getElementById('group-error');
    if (errorEl) errorEl.remove();

    if (!isChecked) {
        event.preventDefault();

        // Show error message
        const firstCheckbox = checkboxes[0];
        const errorMessage = document.createElement('span');
        errorMessage.id = 'group-error';
        errorMessage.classList.add('text-danger', 'd-block', 'mt-1');
        errorMessage.innerText = 'Please select at least one permission group.';
        firstCheckbox.closest('.form-check').appendChild(errorMessage);
    }
});
</script>




<script type="text/javascript">
$(document).ready(function () {
    // Select All
    $('#custome_selectAll').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('input.permission-checkbox, input.group-checkbox').prop('checked', isChecked);
    });

    // Group checkbox → select all its permissions
    $('.group-checkbox').on('change', function () {
        const groupSlug = $(this).attr('id').replace('group_', '');
        $(`.permission-checkbox[data-group="${groupSlug}"]`).prop('checked', $(this).is(':checked'));
        updateSelectAll();
    });

    // Permission checkbox → update group checkbox
    $('.permission-checkbox').on('change', function () {
        const groupSlug = $(this).data('group');
        const groupPermissions = $(`.permission-checkbox[data-group="${groupSlug}"]`);
        const groupCheckedCount = groupPermissions.filter(':checked').length;
        $(`#group_${groupSlug}`).prop('checked', groupCheckedCount > 0);
        updateSelectAll();
    });

    // Update Select All status
    function updateSelectAll() {
        const allChecked = $('.permission-checkbox').length === $('.permission-checkbox:checked').length;
        $('#custome_selectAll').prop('checked', allChecked);
    }
});

</script>



@endsection