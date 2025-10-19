
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
                                            @if(Auth::user()->can('add-category'))
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#login-modal">Add Category</button>
                                            @endif
                                        </ol>

                                    </div>
                                    <h4 class="page-title">Category Table</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 



                        

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">


                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Category Name</th>
                                                    <th>Action</th>
                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>

                                            @php $sl = 1 @endphp
                                            @foreach ($CategoryData as $data)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>{{ $data->category_name }}</td>
                                                    <td>
                                                        @if(Auth::user()->can('edit-category'))
                                                        <a href="{{ route('edit.category', $data->id) }}" class="btn btn-success rounded-pill waves-effect waves-light"><i class="fa-solid fa-square-pen"></i> Edit</a>
                                                        @endif

                                                        @if(Auth::user()->can('delete-category'))
                                                        <a href="{{ route('delete.category', $data->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"  title="Delete Data"><i class="fa-solid fa-trash"></i> Delete</a>
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







{{--  MODAL --}}
                    <!-- Save Category  content -->
                    <div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="height: 100vh">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">

                                    <form method="post" id="MyForm" action="{{ route('store.category') }}" class="px-3">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="emailaddress1" class="form-label">Category Name</label>
                                            <input name="category" class="form-control" type="text" id="category" required="">
                                        </div>


                                        

                                        <div class="mb-2 text-center">
                                            <button class="btn rounded-pill btn-primary" type="submit">Save </button>
                                        </div>

                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->






                        
                    </div> <!-- container -->

                </div> <!-- content -->


            </div>



        </div>
        <!-- END wrapper -->





<script>
$(document).ready(function () {
    $('#MyForm').validate({
        rules: {
            category: {
                required: true,
                maxlength: 100
            },

        },
        messages: {
            category: {
                required: "Please enter a Category name",
                maxlength: "Category name cannot be more than 100 characters"
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
