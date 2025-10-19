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


                                    </div>
                                    <h4 class="page-title">Cancel Order Table</h4>
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
                                        <th>Invoice No</th>
                                        <th>Order Type</th>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Cancelled By</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>


                    </thead>
                    
                    
    <tbody>
        {{-- Order table Fillable --}}
    @php $sl = 1 @endphp
        @foreach ($Orders as $data)
        <tr>
            <td>{{ $sl++ }}</td>
            <td>{{ $data->invoice_no ?? '' }}</td>
            <td>{{ $data->order_type ?? '' }}</td>
            <td>{{ $data->customer->name ?? '' }}</td>
            <td>{{ $data->order_date ?? '' }}</td>
            <td>{{ $data->cancelledBy->name ?? '' }}</td>
            <td><span class="badge bg-success">{{ $data->order_status ?? '' }}</span></td>
            <td>


                @if(Auth::user()->can('view-cancel-details'))
                <a href="{{ route('details', $data->id) }}" class="btn btn-sm btn-info">View Details</a>
                @endif<td> 
      
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

            </div>



        </div>
        <!-- END wrapper -->







<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Mark as Shipped
    $('.mark-shipped').click(function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Mark as Shipped?',
            text: 'Are you sure you want to mark this order as shipped?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Ship it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{ route('orders.ajax.shipped') }}", { id: id }, function(data) {
                    if (data.success) {
                        $('#order-row-' + id).fadeOut();
                        Swal.fire('Success', data.message, 'success');
                    }
                });
            }
        });
    });



    // Cancel Order
    $('.mark-cancelled').click(function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Cancel this order?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel it!',
            cancelButtonText: 'No, go back'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{ route('orders.ajax.cancelled') }}", { id: id }, function(data) {
                    if (data.success) {
                        $('#order-row-' + id).fadeOut();
                        Swal.fire('Cancelled', data.message, 'success');
                    }
                });
            }
        });
    });
});
</script>



@endsection
