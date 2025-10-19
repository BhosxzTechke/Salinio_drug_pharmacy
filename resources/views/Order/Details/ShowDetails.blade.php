



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
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">

                                                <form method="POST" action="{{ route('status.update') }}" enctype="multipart/form-data" >
                                                  @csrf 
                                                  @method('PUT')


                                                    <input type="hidden" name="id" value="{{ $Order->id }}">

                                                    
                                                    <input type="hidden" name="order_status" value="complete">

                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Order Details</h5>

                                                         <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label">Customer Image</label>
                                                                <img id="showImage" src="{{ (!empty($Order->customer->image)) ? url($Order->customer->image) : url('uploads/noimage.png') }}" class="rounded-circle avatar-lg img-thumbnail">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    <div class="row">



                                                        <div class="col-md-6">

                                                            <div class="mb-3">
                                                                <label for="name" class="">Customer Name</label>
                                                                <p class="text-danger">{{ $Order->customer->name }} </p>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Customer Email</label>
                                                                <p class="text-danger">{{ $Order->customer->email }}</p>

                                                              </div>
                                                        </div> <!-- end col -->




                                                <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="phone" class="">Customer Phone</label>
                                                                <p class="text-danger">{{ $Order->customer->phone }}</p>

                                                            </div>
                                                        </div> <!-- end col -->


                                                        

                                                 <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Order Date </label>
                                                                <p class="text-danger">{{ $Order->order_date }}</p>

                                                            </div>
                                                        </div> <!-- end col -->





                                                        
                                                 <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Order Invoice </label>
                                                                <p class="text-danger">{{ $Order->invoice_no }}</p>

                                                            </div>
                                                        </div> <!-- end col -->



                                                <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Payment Status </label>
                                                                <p class="text-danger">{{ $Order->payment_status }}</p>

                                                            </div>
                                                        </div> <!-- end col -->





                                                <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Paid Amount</label>
                                                                <p class="text-danger">{{ $Order->pay }}</p>

                                                            </div>
                                                        </div> <!-- end col -->



                                                 <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Due Amount</label>
                                                                <p class="text-danger">{{ $Order->due }}</p>

                                                            </div>
                                                        </div> <!-- end col -->

                    @php

                        $orderId = $Order->id;
                        $order = App\Models\Order::find($orderId);
                    @endphp

                    @if($order && $order->reference_number)

                         <div class="col-md-6">
                            <button type="button" class="btn btn-dark">
                                        <img src="{{ asset('logo/gcash-seeklogo.png') }}" width="40px" alt="Logo">

                        <span class="badge badge-light">Payment Method: Gcash</span> <span class="badge badge-info">{{ $order->reference_number }}</span></button>
                            </div>

                    @else
                         <div class="col-md-6">
                            <button type="button" class="btn btn-primary">
                        <span class="badge badge-light">Payment Method: Cash</span></button>
                            </div>
                    @endif


                        </div> <!-- end row -->

                        <br>



                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Quantity </th>
                                                    <th>Price</th>
                                                    <th>Total(+VAT)</th>
                                                </tr>

                                        </thead>
                                        
                                        
                    <tbody>

                    @php $sl = 1 @endphp
                        @foreach ($OrderDetails as $data)
                        <tr>
                            <td>{{ $sl++ }}</td>
                                        <td>
                                            <img 
                                                src="{{ asset($data->product->product_image ?? 'uploads/noimage.png') }}" 
                                                style="height: 3rem"
                                            >
                                        </td>
                                {{-- Product name fallback --}}
                                <td>{{ $data->product->product_name ?? 'Unknown Product' }}</td>

                                {{-- Product code fallback --}}
                                <td>{{ $data->product->product_code ?? 'N/A' }}</td>

                                {{-- Quantity fallback --}}
                                <td>{{ $data->quantity ?? 0 }}</td>

                                {{-- Selling price fallback --}}
                                <td>{{ $data->product->selling_price ?? 0 }}</td>

                                {{-- Total price fallback --}}
                                <td>{{ ($data->quantity ?? 0) * ($data->product->selling_price ?? 0) }}</td>

                        </tr>
                            @endforeach




                             </tbody>
                                        </table>


{{--     

                                                    <div class="text-end">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Complete Orders </button>
                                                    </div>
                                                     --}}
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
                            




@endsection