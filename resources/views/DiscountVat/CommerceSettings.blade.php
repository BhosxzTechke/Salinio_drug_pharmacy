
@extends('admin_dashboard')
@section('admin')


<div class="card">
<div class="card-body">
   <h4 class="header-title mb-4">Manage Vat & Discount</h4>


        <div class="row">
                <div class="col-sm-3">
                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active show mb-1" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            VAT Maintanance</a>
                        <a class="nav-link mb-1" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" tabindex="-1">
                            Discount Maintanance</a>
                            
                </div> <!-- end col-->
                </div>

                    <div class="col-sm-9">
                        <div class="tab-content pt-0">


                <br>
                <br>



                {{--                    VAT MAINTANANCE TAB                --}}
              <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <form method="POST" action="{{ route('update.vat')}}"  >
                    @csrf

                    <input type="hidden" name="id" value="{{ $vat->id }}">


                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Manage VAT Settings</h5>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="brand" class="">Modify VAT</label>
                                <input type="text" value="{{ $vat->name ?? '' }}" name="vatName" class="form-control @error('vatName') is-invalid @enderror" id="vatName" placeholder="Enter VAT Name">

                                @error('vatName')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>

                            <div class="mb-3">

                               <input 
                                            type="number" 
                                            step="0.01" 
                                            min="0" 
                                            max="100" 
                                            name="vatRate" 
                                            id="vatRate" 
                                            class="form-control" 
                                            value="{{ old('vatRate', $vat->rate) }}" 
                                            required
                                        >
                                @error('vatRate')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror 
                            </div>

                                    {{-- Dosage Form --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <select name="activeVat" class="form-control" id="dosage_form">
                                <option selected disabled >Select VAT Status </option>
                                <option value="1" {{ $vat->active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $vat->active == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>



                </div>
            </div>
                 {{-- @if(Auth::user()->can('Update Business nam')) --}}
                            <div class="text-end">
                                <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Changes</button>
                            </div>

        </div> <!-- end row -->
    

                            {{-- @endif --}}
                        </form>

  </div>







            {{--          DISCOUNT MAINTANANCE          --}}


 

            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">


                

        <div class="text-end">
            <button type="button" class="btn btn-info add-discount" data-bs-toggle="modal" data-bs-target="#discount-modal">Add Discount</button>
        </div>

                    

                    <!-- Modal -->
                    <div class="modal fade" id="discount-modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="discountModalLabel">Add Discount</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="discount_id" value="">

                                    <div class="mb-2">
                                        <label for="discountname" class="form-label">Discount Name</label>
                                        <input id="discountname" class="form-control" placeholder="Discount Name">
                                    </div>

                                    <div class="mb-2">
                                        <label for="discountrate" class="form-label">Discount Rate (%)</label>
                                        <input id="discountrate" class="form-control" placeholder="Rate" type="number" min="0">
                                    </div>

                                    <div class="mb-2">
                                        <label for="vat_exempt" class="form-label">Is this VAT Exempt?</label>
                                        <select id="vat_exempt" class="form-control">
                                            <option value="" selected disabled>Select option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label for="is_active" class="form-label">Is this Active?</label>
                                        <select id="is_active" class="form-control">
                                            <option value="" selected disabled>Select option</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary submit-discount">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>




<h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Manage Discount Settings</h5>

        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Discount Name</th>
                        <th>Discount Rate</th>
                        <th>VAT Exempt</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

            </thead>
                                        
                                        
        <tbody>

    @php $sl = 1 @endphp
        @foreach ($discount as $data)
        <tr id="discount-row-{{ $data->id }}">
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->rate }}%</td>
            <td>{{ $data->vat_exempt ? 'Yes' : 'No' }}</td>
            <td>{{ $data->active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <button class="btn btn-sm btn-warning edit-discount" 
                            data-id="{{ $data->id }}"
                            data-name="{{ $data->name }}"
                            data-rate="{{ $data->rate }}"
                            data-vat="{{ $data->vat_exempt }}"
                            data-active="{{ $data->active }}">
                        Edit
                    </button>
                        <button class="btn btn-sm btn-danger delete-discount" 
                                data-id="{{ $data->id }}">
                            Delete
                        </button>


                </td>
        </tr>
    @endforeach
                                        


        </tbody>
</table>



     
            </div>




                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
        </div>


</div> <!-- end card body-->
</div> <!-- end card -->



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

$(document).on('click', '.submit-discount', function(e) {
    e.preventDefault();

    let id = $('#discount_id').val();
    let discountname = $('#discountname').val();
    let discountrate = $('#discountrate').val();
    let vat_exempt = $('#vat_exempt').val();
    let is_active = $('#is_active').val();

    if (!discountname || !discountrate) {
        Swal.fire('Error', 'Please fill in all required fields.', 'error');
        return;
    }

    let actionText = id ? 'update' : 'add';
    let confirmTitle = id ? 'Update Discount?' : 'Add Discount?';
    let confirmText = id
        ? 'Are you sure you want to update this discount?'
        : 'Are you sure you want to add this discount?';


    Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText} it!`,
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {

            let url = id 
                ? "{{ route('update.ajax.discount') }}"
                : "{{ route('add.ajax.discount') }}";


                
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id,
                    discountname,
                    discountrate,
                    vat_exempt,
                    is_active,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        $('#discount-modal').modal('hide');
                        Swal.fire('Success', data.message, 'success');
                        
                        if (id) {
                            // Update row
                            let row = $(`#discount-row-${id}`);
                            row.find('td:eq(1)').text(data.data.name);
                            row.find('td:eq(2)').text(data.data.rate + '%');
                            row.find('td:eq(3)').text(data.data.vat_exempt == 1 ? 'Yes' : 'No');
                            row.find('td:eq(4)').text(data.data.is_active == 1 ? 'Active' : 'Inactive');
                            $('#discount-modal').modal('hide');
                        } else {
                            // Add new row

                            let newRow = `
                                <tr id="discount-row-${data.data.id}">
                                    <td>${data.data.id}</td>
                                    <td>${data.data.name}</td>
                                    <td>${data.data.rate}%</td>
                                    <td>${data.data.vat_exempt == 1 ? 'Yes' : 'No'}</td>
                                    <td>${data.data.active == 1 ? 'Active' : 'Inactive'}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-discount" 
                                                data-id="${data.data.id}"
                                                data-name="${data.data.name}"
                                                data-rate="${data.data.rate}"
                                                data-vat="${data.data.vat_exempt}"
                                                data-active="${data.data.is_active}">
                                            Edit
                                        </button>

                                        <button class="btn btn-sm btn-danger delete-discount" 
                                                data-id="${data.data.id}">
                                            Delete
                                    </td>
                                </tr>
                            `;
                            $('#basic-datatable tbody').append($(newRow).hide().fadeIn(500));
                            $('#discount-modal').modal('hide');
                        }



                        // // Reset modal for next use
                        // $('#discount_id').val('');
                        // $('#discountname').val('');
                        // $('#discountrate').val('');
                        // $('#vat_exempt').val('0');
                        // $('#is_active').val('1');
                        // $('#discountModalLabel').text('Add Discount');
                        // $('.submit-discount').text('Save');
                    } else {
                        Swal.fire('Error', data.message || 'Something went wrong.', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Failed to process discount: ' + xhr.statusText, 'error');
                }
            });
        }
    });
});

</script>



<script>


////////////////// IF EDIT DISCOUNT BUTTON CLICKED /////////////////
$(document).on('click', '.edit-discount', function() {


    // Grab data from button
    let id = $(this).data('id');
    let name = $(this).data('name');
    let rate = $(this).data('rate');
    let vat = $(this).data('vat');
    let active = $(this).data('active');



    // Fill modal inputs (cast to string for dropdowns)
    $('#discount_id').val(id);
    $('#discountname').val(name);
    $('#discountrate').val(rate);
    $('#vat_exempt').val(String(vat)).change();
    $('#is_active').val(String(active)).change();

    // Update modal title/button
    $('#discountModalLabel').text('Edit Discount');
    $('.submit-discount').text('Update').addClass('updating');

    // Show modal
    $('#discount-modal').modal('show');
});



////////////////// IF ADD DISCOUNT BUTTON CLICKED /////////////////
        $(document).on('click', '.add-discount', function() {
            // Reset modal
            $('#discount_id').val('');
            $('#discountname').val('');
            $('#discountrate').val('');
            $('#vat_exempt').val('').change();
            $('#is_active').val('').change();
            $('#discountModalLabel').text('Add Discount');
            $('.submit-discount').text('Save').removeClass('updating');
            $('#discount-modal').modal('show');
        });

        // Reset when modal closes
        $('#discount-modal').on('hidden.bs.modal', function () {
            $('#discount_id').val('');
            $('#discountname').val('');
            $('#discountrate').val('');
            $('#vat_exempt').val('0').change();
            $('#is_active').val('1').change();
            $('#discountModalLabel').text('Add Discount');
            $('.submit-discount').text('Save').removeClass('updating');
        });


        
</script>







<script>


        $(document).on('click', '.delete-discount', function(e) {
            e.preventDefault();

            let id = $(this).data('id'); // the discount ID

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the discount.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.ajax.discount') }}",
                        type: 'DELETE',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                // Fade out and remove the deleted row
                                $('#discount-row-' + id).fadeOut(400, function() {
                                    $(this).remove();
                                });

                                Swal.fire('Deleted!', data.message, 'success');
                            } else {
                                Swal.fire('Error', data.message || 'Failed to delete discount.', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Request failed: ' + xhr.statusText, 'error');
                        }
                    });
                }
            });
        });


</script>


@endsection