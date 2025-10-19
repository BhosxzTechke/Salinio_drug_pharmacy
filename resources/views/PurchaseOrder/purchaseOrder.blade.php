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
                                            <li class="breadcrumb-item active">Received</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Delivery Purchase Order</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


<div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



                <form method="POST" id="Myform" action="{{ route('save.purchaseOrder') }}" enctype="multipart/form-data" >
                    @csrf


                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Purchase Order</h5>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="brand" class="">Purchase Order #</label>
                                <input type="text" name="po_number" class="form-control @error('purchase') is-invalid @enderror" id="purchase" placeholder="" readonly="">
                        
                                @error('purchase')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>
                        </div>


                {{-- Expire Date --}}
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="expire_date">Expected Delivery Date</label>
                        <input type="date" name="expected_delivery_date" class="form-control @error('expect_date') is-invalid @enderror" id="expect_date" min="{{ date('Y-m-d') }}">
                
                        @error('expect_date')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
            
                    </div>
                </div>



                                                    {{-- Supplier --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="supplier_id">Supplier</label>
                                    <select name="supplier_id"
                                            class="form-control @error('supplier_id') is-invalid @enderror"
                                            id="supplier_id">
                                        <option selected disabled>Select Supplier</option>
                                        @foreach ($sup as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            {{--  MODAL --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                            <ol class="breadcrumb m-0">
                                
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#product-modal">Product Entry</button>

                            </ol>
                                </div>
                            </div>


                    <table id="main-product-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Selling Price</th>
                                <th>Quantity Order </th>
                                <th>Cost Price </th>
                                <th>Total Cost Price </th>
                                <th>Action</th>
                            </tr>
                    </thead>
                    
                    

    <tbody id="selected-products">
        {{-- Will be filled dynamically --}}
    </tbody>

                    </table>


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










    <!--            PRODUCT MODAL           -->
    
<div id="product-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Product Entry</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">


        <table id="modal-datatable" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
            <th>SL</th><th>Image</th><th>Product Name</th>
            <th>Product Code</th><th>Price</th><th>Actions</th>
            </tr>
            </thead>
            <tbody id="modal-products">
                    @php $sl = 1 @endphp
                    @foreach ($prod as $data)
                    <tr>
            <td>{{ $sl++ }}</td>
            <td><img src="{{ asset($data->product_image) }}" style="height: 3rem" ></td>
            <td>{{ $data->product_name }}</td>
            <td>{{ $data->product_code }}</td>
            <td>{{ $data->selling_price }}</td>
            <td>
                    <button type="button"
                            class="btn btn-sm btn-primary add-product"
                            data-id="{{ $data->id }}"
                            data-name="{{ $data->product_name }}"
                            data-code="{{ $data->product_code }}"
                            data-price="{{ $data->selling_price }}">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
            </tr>
            @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>




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
                            



{{-- <script>
let modalTable;

$('#product-modal').on('shown.bs.modal', function () {
    $.ajax({
        url: "{{ route('purchase.order') }}", // your route returning table rows
        type: "GET",
        success: function (html) {
            // Destroy DataTable before replacing rows
            if ($.fn.DataTable.isDataTable('#modal-datatable')) {
                $('#modal-datatable').DataTable().clear().destroy();
            }

            // Replace tbody with fresh rows
            $('#modal-products').html(html);

            // Re-initialize DataTable
            modalTable = $('#modal-datatable').DataTable({
                responsive: true,
                autoWidth: false,
                searching: true,
                paging: true,
                lengthChange: false
            });
        },
        error: function () {
            console.error('Failed to fetch products');
        }
    });
});


</script> --}}

<script>
function refreshMainTable() {
    $.ajax({
        url: "{{ route('cart.content') }}", // returns <tr> rows from session
        type: "GET",
        success: function (html) {
            $('#selected-products').html(html);
        }
    });
}

$(document).ready(function () {
    // Load existing cart rows on page load
    refreshMainTable();
});



// When clicking the + button inside the modal
$(document).on('click', '.add-product', function () {
    let productId = $(this).data('id');
    let name = $(this).data('name');
    let code = $(this).data('code');
    let qty = $(this).data('qty');
    let price = $(this).data('price');

    $.ajax({
        url: "{{ route('cart.add') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: productId,
            name: name,
            code: code,
            qty: qty,
            price: price
        },
        success: function (response) {
            if (response.success) {
                refreshMainTable(); // updates table immediately
            }
        }
    });
});



// Remove button from main table
$(document).on('click', '.remove-cart-item', function () {
    let rowId = $(this).data('rowid');
    $.ajax({
        url: "{{ route('cart.remove') }}",
        type: "POST", // 
        data: {
            _token: "{{ csrf_token() }}",
            _method: "DELETE", //
            rowId: rowId
        },
        success: function (response) {
            if (response.success) refreshMainTable();
        }
    });
});



// Handle qty update button
$(document).on('click', '.update-cart-item', function () {
    let rowId = $(this).data('rowid');
    let row = $(this).closest('tr');

    let newQty = row.find('.cart-qty-input').val();
    let newCostPrice = row.find('.cart-cost-input').val();

    $.ajax({
        url: "{{ route('cart.updateItem') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            _method: "PATCH",
            rowId: rowId,
            qty: newQty,
            cost_price: newCostPrice
        },
        success: function (response) {
            if (response.success) {
                refreshMainTable();
            }
        }
    });
});


</script>



<script>
$(document).ready(function () {
    // Auto-generate PO number if empty
    const poField = $('input[name="po_number"]');
    if (poField.val().trim() === '') {
        const randomCode = 'PO-' + Math.random().toString(36).substring(2, 8).toUpperCase();
        poField.val(randomCode);
    }

        $(document).on('change blur', '.validate-cost, .validate-qty', function () {
            const $row = $(this).closest('tr');
            const sellingPrice = parseFloat($row.find('.selling-price').text()) || 0;
            const costPrice = parseFloat($row.find('.validate-cost').val()) || 0;
            const qty = parseFloat($row.find('.validate-qty').val()) || 0;

            // Basic checks
            if (qty <= 0) {
                $(this).addClass('is-invalid');
                Swal.fire({ icon: 'error', title: 'Quantity must be greater than 0' });
            } else {
                $(this).removeClass('is-invalid');
            }

            if (sellingPrice <= costPrice) {
                $row.find('.validate-cost').addClass('is-invalid');
                Swal.fire({ icon: 'warning', title: 'Selling price must be greater than cost price!' });
            } else {
                $row.find('.validate-cost').removeClass('is-invalid');
            }
        });

});
</script>


{{-- <script>
$(document).ready(function () {
    $('#Myform').on('submit', function (e) {
        // Only count rows that contain at least one <td> with content
        const cartRows = $('#selected-products tr').filter(function () {
            return $(this).find('td').length > 0 && $.trim($(this).text()) !== '';
        });

        console.log("Cart row count:", cartRows.length); // Debugging

        if (cartRows.length === 0) {
            e.preventDefault(); // Block form submit

            Swal.fire({
                icon: 'warning',
                title: 'Cart is Empty',
                text: 'Please add at least one product to the purchase order.',
                timer: 2500,
                showConfirmButton: false
            });

            return false;
        }
    });
});
</script> --}}





@endsection 