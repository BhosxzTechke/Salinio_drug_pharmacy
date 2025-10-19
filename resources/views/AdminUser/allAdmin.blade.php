@extends('admin_dashboard')
@section('admin')


                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">

                                            @if(Auth::user()->can('create-admin'))
                                            <a href="{{ route('create.admin') }}">
                                                <button type="button" class="btn btn-success px-4 py-2 shadow" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); font-weight: 500;">
                                                    Add Users
                                                </button>
                                            </a>
                                            @endif
                                        </ol>
                                    </div>
                                    <h4 class="page-title">All Users Table</h4>
                                    <span class="badge bg-primary fs-6 px-3 py-2 shadow" style="border-radius: 8px;">Active Users: {{ count($user) }}</span>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->
                        
                        <br>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone </th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>

                        </thead>
                        
                        
                            <tbody>

    @php $sl = 1 @endphp
                @foreach ($user as $data)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>
                                <img src="{{ !empty($data->photo) ? url('uploads/admin_image/'. $data->photo) : url('uploads/noimage.png') }}" 
                                    style="height: 3rem">
                            </td>
                            <td>{{ $data->name ?? '' }}</td>
                            <td>{{ $data->email ?? '' }}</td>
                            <td>{{ $data->phone ?? '' }}</td>
                            <td>
                                @foreach($data->roles as $role)
                                    <span class="badge badge-pill bg-danger"> {{ $role->name ?? '' }} </span>
                                @endforeach
                            </td>

                            <td>
                                @if($data->roles->contains('name', 'Super Admin'))
                                    <span class="text-muted fw-bold">Protected</span>
                                @else

                                
                                    @if(Auth::user()->can('edit-admin-account'))
                                        <a href="{{ route('edit.admin', $data->id) }}" 
                                            class="btn btn-success rounded-pill waves-effect waves-light">
                                            <i class="fa-solid fa-square-pen"></i> Edit
                                        </a>
                                    @endif

                                    @if(Auth::user()->can('delete-admin-account'))
                                        <a href="{{ route('delete.admin', $data->id) }}" 
                                            class="btn btn-danger rounded-pill waves-effect waves-light"
                                            id="delete" title="Delete Data">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </a>
                                    @endif


                                    @if(auth::user()->can('view-temporary-password'))
                                    <button 
                                        type="button" 
                                        class="btn btn-secondary rounded-pill waves-effect waves-light" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#tempPassModal" 
                                        data-password="{{ $data->temp_password ?? 'Not Available' }}" 
                                        {{ $data->must_change_password ? '' : 'disabled' }}>
                                        Show Temp Password
                                    </button>
                                @endif
                            @endif
                            </td>
                        </tr>

                        
                @endforeach




                            </tbody>
                                        </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->



                        
                    </div> <!-- container -->





                </div> <!-- content -->




                        {{--  TEMPORARY PASSWORD MODAL  --}}
        <div class="modal fade" id="tempPassModal" tabindex="-1" aria-labelledby="tempPassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tempPassModalLabel">Temporary Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your temporary password is: <strong id="modalPassword"></strong></p>
                <button class="btn btn-sm btn-light" onclick="copyModalPassword()">📋 Copy</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>





                <!-- Footer Start -->
                {{-- <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; boss <a href="">ItsAntiks</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javasc
                                    ript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> --}}
                <!-- end Footer -->

            </div>



        </div>


<script>
var tempPassModal = document.getElementById('tempPassModal');

// Update modal content every time it opens
tempPassModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    var password = button.getAttribute('data-password'); // Get password from button
    var modalPassword = tempPassModal.querySelector('#modalPassword');
    modalPassword.textContent = password; // Update content
});



// Optional: clear modal content when hidden
tempPassModal.addEventListener('hidden.bs.modal', function () {
    tempPassModal.querySelector('#modalPassword').textContent = '';
});



function copyModalPassword() {
    const password = document.getElementById('modalPassword').textContent;
    navigator.clipboard.writeText(password)
        .then(() => alert('Password copied!'))
        .catch(() => alert('Failed to copy'));
}
</script>




@endsection
