



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
                                    
                                    <h4 class="page-title">Received Delivery</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


<div class="row">

<div class="col-lg-8 col-xl-12">
        <div class="card">
            <div class="card-body">

                    <div class="tab-pane" id="settings">

                        <form method="POST" id="cart-table" action="{{ route('save.deliveries') }}" enctype="multipart/form-data" >
                            @csrf 


                            <input type="hidden" name="purchase_order_id" value="{{ $PurchaseOrder->id }}">

                            

                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Batch #</h5>



            <div class="row">


                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="name" class="">PO #</label>
                        <p class="text-danger">{{ $PurchaseOrder->po_number }} </p>

                    </div>
                </div>


                

            <div class="col-md-6">
                    <div class="mb-3">
                        <label for="text" class="">Expected Delivery Date </label>
                        <p class="text-danger">{{ $PurchaseOrder->expected_delivery_date }}</p>

                    </div>
                </div> <!-- end col -->


        <div class="col-md-6">
                    <div class="mb-3">
                        <label for="text" class="">Supplier </label>
                        <p class="text-danger">{{ $PurchaseOrder->supplier->name ?? ''}}</p>

                    </div>
                </div> <!-- end col -->

                        <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="text" class="">Order Status </label>
                                        <p class="text-danger">{{ $PurchaseOrder->status }}</p>

                                    </div>
                                </div> <!-- end col -->

        <div class="col-md-6">
                <div class="mb-3">
                    <label for="text" name="delivery_date" class="">Delivery Date </label>
                    <p class="text-success">{{  $Delivery->delivery_date ?? now() }}</p>

                </div>
            </div> <!-- end col -->


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Remarks </label>
                <div class="col-sm-10">
                <textarea name="remarks" id="elm1" name="remarks">{{ $Delivery->remarks ?? '' }}</textarea>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="reference_number">Reference number</label>
                <input type="number" value="{{ $Delivery->reference_number ?? '' }}" name="reference_number" class="form-control" id="reference_number">
            </div>
        </div>



        </div> <!-- end row -->



                <table id="basic-datatable cart-table" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Batch #</th>
                            <th>Quantity </th>                            
                            <th>Expiration Date</th>
                            <th>Quantity Received</th>
                        </tr>

                </thead>
                                        
                                        
                    <tbody>



@foreach ($PurchaseOrderItem as $key => $data)

<tr>
    {{-- Hidden fields so we know which product this row belongs to --}}
    <input type="hidden" name="items[{{ $key }}][product_id]" value="{{ $data->product_id }}">

    <td>{{ $loop->iteration }}</td>


    {{-- Product Image --}}
    <td>
        <img src="{{ asset($data->product->product_image) }}" style="height: 3rem">
    </td>


    {{-- Product Name --}}
    <td>{{ $data->product->product_name }}</td>



    {{-- Auto-generated batch number --}}
    <td>
<input type="text" 
    name="items[{{ $key }}][batch_number]" 
    class="form-control" 
    value="{{ optional($Delivery?->delivery_items->get($key))->batch_number ?? $data->auto_batch_number }}" 
    readonly>
    </td>

            {{-- Ordered Quantity (just display, not editable) --}}
        <td> <input type="hidden" class="quantity_received" value="{{ $data->remaining_qty ?: $data->quantity_ordered }}">
            {{ $data->remaining_qty ?: $data->quantity_ordered }}</td>


    
    {{-- Expiry Date --}}
    <td>
        <input type="date"
        value="{{ optional($Delivery?->delivery_items->get($key))->expiry_date ?? '' }}"
        name="items[{{ $key }}][expiry_date]"
        class="form-control expiry-date"
        min="{{ date('Y-m-d') }}">
    </td>





    {{-- Quantity Received (default = ordered qty) --}}
    <td>
        <input type="number"
               value="{{ $data->quantity_ordered }}"
               name="items[{{ $key }}][quantity_received]"
               class="form-control quantity_ordered"
               max="{{ $data->remaining_qty ?? $data->quantity_ordered }}">
    </td>



            {{-- Cost Price --}}
            <td>
            <input type="hidden"
                name="items[{{ $key }}][cost_price]"
                step="0.01"
                class="form-control"
                value="{{ $data->cost_price ?? 0 }}" readonly>
        </td>



        
            {{-- Cost Price --}}
            <td>
            <input type="hidden"
                name="items[{{ $key }}][selling_price]"
                step="0.01"
                class="form-control"
                value="{{ $data->product->selling_price ?? 0 }}" readonly>
        </td>



        {{-- Supplier_id --}}
        <td>
        <input type="hidden"
                name="items[{{ $key }}][supplier_id]"
                step="0.01"
                class="form-control"
                value="{{ $data->PurchaseOrder->supplier_id ?? 0 }}" readonly>
    </td>


</tr>
@endforeach


                </tbody>
                        </table>


    

                <div class="text-end">
                    <button type="submit" id="submit-button" name="submit" class="btn btn-info waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Received </button>
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
                            
<script>
$(document).ready(function () {

    $(document).on('change blur', '.quantity_ordered', function () {
        const $row = $(this).closest('tr');

        const maxQty = parseFloat($row.find('.quantity_received').val()) || 0; // hidden input
        const enteredQty = parseFloat($(this).val()) || 0;

        // Reset validation
        $(this).removeClass('is-invalid');

        if (enteredQty <= 0) {
            $(this).addClass('is-invalid');
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                text: 'Quantity received must be greater than 0',
                timer: 2500
            });
        }
        else if (enteredQty > maxQty) {
            $(this).addClass('is-invalid');
            Swal.fire({
                icon: 'warning',
                title: 'Quantity Too High',
                text: 'Quantity received cannot be greater than quantity ordered',
                timer: 2500
            });
        }
    });

});
</script>


<script>
$(document).ready(function () {
    $('#submit-button').on('click', function (e) {
        let cartRows = $('#cart-table tbody tr');
        let cartHasItems = cartRows.length > 0;
        let formIsValid = true;
        let minBufferDays = 30;

        // If cart is empty
        if (!cartHasItems) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Cart is empty',
                text: 'Please add at least one item before submitting.'
            });
            return;
        }

        // Validate each expiry date
        $('.expiry-date').each(function () {
            let expiryVal = $(this).val();
            let expiryDate = new Date(expiryVal);
            let today = new Date();
            let minValidDate = new Date();
            minValidDate.setDate(today.getDate() + minBufferDays);

            // Clear old errors
            $(this).removeClass('is-invalid');
            $(this).next('.text-danger').remove();

            // If empty or too soon
            if (!expiryVal || expiryDate < minValidDate) {
                formIsValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!formIsValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Expiry Dates',
                text: 'All items must have a valid expiry date at least 30 days from today.'
            });
        }
    });
});
</script>



@endsection