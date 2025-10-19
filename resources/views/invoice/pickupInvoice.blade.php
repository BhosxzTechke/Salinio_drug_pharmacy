@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>



<div class="row">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Logo & title -->
                                        <div class="clearfix">
                                            <div class="float-start">
                                                {{-- <div class="auth-logo">
                                                    <div class="logo logo-dark">
                                                        <span class="logo-lg">
                                                            <img src={{ asset('backend/assets/images/logo-dark.png')}} alt="" height="22">
                                                        </span>
                                                    </div>
                                
                                                    <div class="logo logo-light">
                                                        <span class="logo-lg">
                                                            <img src={{ asset('backend/assets/images/logo-light.png')}} alt="" height="22">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> --}}



                                            <div class="float-end">
                                                <h4 class="m-0 d-print-none">Invoice</h4>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mt-3">
                                                    <p><b>Hello,{{ $order->customer->name }}</b></p>
                                                    <p class="text-muted">Thanks a lot because you keep purchasing our products. Our company
                                                        promises to provide high quality products for you as well as outstanding
                                                        customer service for every transaction. </p>
                                                </div>
            
                                            </div><!-- end col -->



                                            <div class="col-md-4 offset-md-2">
                                                <div class="mt-3 float-end">
                                                    <p><strong>Order Date : </strong> <span class="float-end"> &nbsp;&nbsp;&nbsp;&nbsp; {{ $order->order_date }}</span></p>
                                                    <p><strong>Order Status : </strong> <span class="float-end"><span class="badge bg-danger">Paid</span></span></p>
                                                    <p><strong>Order No. : </strong> <span class="float-end"> {{ $order->id }} </span></p>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->
            
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <h6>Billing Address</h6>
                                                <address>
                                            	{{ $order->customer->address }} - {{ $order->customer->city }}
                                                    <br>
                                            <abbr title="Phone">Shop Name:</abbr> {{ $order->customer->shopname }}<br>
                                            <abbr title="Phone">Phone:</abbr> {{ $order->customer->phone }}<br>
                                            <abbr title="Phone">Email:</abbr> {{ $order->customer->email }}<br>

                                                </address>
                                            </div> <!-- end col -->
                                            


                                            {{-- // PLAN TO  Shipping Address
                                            <div class="col-sm-6">
                                                <h6>Shipping Address</h6>
                                                <address>
                                                    Stanley Jones<br>
                                                    795 Folsom Ave, Suite 600<br>
                                                    San Francisco, CA 94107<br>
                                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                                </address>
                                            </div> <!-- end col -->
                                        </div> 
                                        <!-- end row --> --}}



            
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table mt-4 table-centered">
                                                        <thead>
                                                        <tr>
                                                            
                                                            <th>#</th>
                                                            <th>Item</th>
                                                            <th style="width: 10%">Quantity</th>
                                                            <th style="width: 10%">Sub-Total</th>
                                                            <th style="width: 10%" class="text-end">Total</th>
                                                        </tr></thead>
                                                        <tbody>
                                                        <tr>
                                                            @php $i = 1 @endphp
                                                                @foreach ($order->orderDetails as $detail)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td><b>{{ $detail->product->product_name }}</b></td>
                                                                    <td>{{ $detail->quantity }}</td>
                                                                    <td>{{ number_format($detail->product->selling_price, 2) }}</td>
                                                                    <td class="text-end">{{ number_format($detail->product->selling_price * $detail->quantity, 2) }}</td>

                                                                </tr>
                                                                @endforeach
                                                        </tr>
            
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive -->
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
            
                                        {{-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="clearfix pt-5">
                                                    <h6 class="text-muted">Notes:</h6>
            
                                                    <small class="text-muted">
                                                        All accounts are to be paid within 7 days from receipt of
                                                        invoice. To be paid by cheque or credit card or direct payment
                                                        online. If account is not paid within 7 days the credits details
                                                        supplied as confirmation of work undertaken will be charged the
                                                        agreed quoted fee noted above.
                                                    </small>
                                                </div>
                                            </div> <!-- end col --> --}}

                                            {{-- CALCULATION CARD --}}
                                            <div class="col-sm-6">
                                                <div class="float-end">
                                                    <p><b>Sub-total:</b> <span class="float-end">{{ $order->customer->sub_total }}</span></p>
                                                    <p><b>Discount (12%):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $order->customer->vat }} </span></p>
                                                    <h3>{{ $order->customer->total }}</h3>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div> <!-- end col -->

                                            
                                        </div>
                                        <!-- end row -->
    
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div>





                        <script>
    window.onload = function () {
        window.print();

        // Optional: go back to POS after print
        setTimeout(function () {
            window.location.href = "/pos";
        }, 1000);
    };
</script>


                        @endsection
