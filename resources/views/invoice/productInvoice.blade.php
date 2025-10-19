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
                                                    <p><b>Hello,{{ $Customer->name}}</b></p>
                                                    <p class="text-muted">Thanks a lot because you keep purchasing our products. Our company
                                                        promises to provide high quality products for you as well as outstanding
                                                        customer service for every transaction. </p>
                                                </div>
            
                                            </div><!-- end col -->



                                            <div class="col-md-4 offset-md-2">
                                                <div class="mt-3 float-end">
                                                    <p><strong>Order Date : </strong> <span class="float-end"> &nbsp;&nbsp;&nbsp;&nbsp; Jan 17, 2016</span></p>
                                                    <p><strong>Order Status : </strong> <span class="float-end"><span class="badge bg-danger">Unpaid</span></span></p>
                                                    <p><strong>Order No. : </strong> <span class="float-end">000028 </span></p>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->
            
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <h6>Billing Address</h6>
                                                <address>
                                            	{{ $Customer->address }} - {{ $Customer->city }}
                                                    <br>
                                            <abbr title="Phone">Shop Name:</abbr> {{ $Customer->shopname }}<br>
                                            <abbr title="Phone">Phone:</abbr> {{ $Customer->phone }}<br>
                                            <abbr title="Phone">Email:</abbr> {{ $Customer->email }}<br>

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
                                                             @foreach ($CartContent as $cart)
                                                            <td>{{ $i = $i++ }}</td>
                                                            <td>
                                                                <b>{{ $cart->name }}</b> <br>
                                                                {{-- 2 Pages static website - my website --}}
                                                            </td>
                                                            <td>{{ $cart->qty }}</td>
                                              
                                                            <td>{{ $cart->price }}</td>
                                                            <td class="text-end">{{ $cart->price * $cart->qty  }}</td>
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
                                                    <p><b>Sub-total:</b> <span class="float-end">{{ Cart::subtotal() }}</span></p>
                                                    <p><b>Discount (12%):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ Cart::tax() }} </span></p>
                                                    <h3>{{ Cart::total() }}</h3>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div> <!-- end col -->

                                            
                                        </div>
                                        <!-- end row -->
            
                                        <div class="mt-4 mb-1">
                                            <div class="text-end d-print-none">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print</a>
                                               <button type="submit" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#invoice-modal">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div>







{{-- 



{{--  MODAL --}}
<!-- Save Category  content -->
{{-- <div id="invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="height: 100vh">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-body">


        {{-- 
    <form id="MyForm" method="post" action="{{ route('paypal.submit', $Customer->id) }}" class="px-3">
        @csrf --}}

        {{-- <form id="paymentForm" method="post" action="{{ url('/final-invoice')}}" class="px-3">
            @csrf


        <div class="form-group mb-3">
            <h2 class="text-center">Invoice</h2>
                            <label for="name" class="form-label">Payment Method</label>
                        <select name="payment_status" class="form-control @error('payment') is-invalid @enderror" id="example-select">
                                    <option selected disabled >Select Payment </option>

                                    <option value="Handcash">Cod</option>

                                </select>

                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        </div> --}}

                        {{-- // HIDDEN INPUT--}}
            {{-- <input type="text" name="customer_id" value="{{ $Customer->id }}" hidden>
            <input type="text" name="order_date" value="{{ date('d-F-Y') }}"  hidden>  
            <input type="text" name="order_status" value="pending"  hidden>  
            <input type="text" name="total_products" value="{{ Cart::count() }}"  hidden>  
            <input type="text" name="sub_total" value="{{ Cart::subtotal() }}"  hidden>  
            <input type="text" name="vat" value="{{ Cart::tax() }}"  hidden>  
            <input type="text" name="total" value="{{ Cart::total() }}"  hidden>  


            

                <label for="paynow" class="form-label">Pay Amount</label>
                <input name="pay" class="form-control" type="number" id="paynow" required="" >

                <label for="paynow" class="form-label">Due Amount</label>
                <input name="due" class="form-control" type="number" id="due" required="" >

            </div>



            <div class="mb-2 text-center">
                <button class="btn rounded-pill btn-primary" type="submit">Complete Order </button>
            </div>

        </form>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal --> --}}




    <div id="invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg"> {{-- make it bigger --}}
    <div class="modal-content shadow-lg rounded-3">
      <div class="modal-body bg-light">

        <form id="paymentPickupForm" method="post" action="{{ url('/final-invoice')}}" class="px-3">
        @csrf

        <h2 class="text-center mb-4 fw-bold text-dark">Cashier Invoice</h2>

        <input type="hidden" name="customer_id" id="customer_id" value="{{ $Customer->id ?? ''}}">
        {{-- Payment Method --}}


        <div class="col">
                <label class="form-label fw-bold">Payment Method</label>
                <select name="payment_method" class="form-control" id="payment_method_select">
                    <option selected disabled >Select Payment Method </option>
                    <option value="cash">Cash</option>
                    <option value="gcash">Gcash</option>
                </select>
        </div>

        <br>

        <div class="col">
            <label class="form-label fw-bold">Reference #</label>
            <input type="number" name="reference" id="reference_number"  
                class="form-control form-control-lg text-left" 
                >
        </div>

        


{{-- Discount --}}
<div class="form-group mb-3">
    <label class="form-label fw-bold">Discount</label>
    <select name="discount" id="discount" class="form-control form-control-lg">
        @foreach($discounts as $discount)
            <option 
                value="{{ $discount->rate }}"  data-vat-exempt="{{ $discount->vat_exempt }}">
                {{ $discount->name }} ({{ $discount->rate }}%)

                @if($discount->vat_exempt)
                    - VAT Exempt
                @endif
                
            </option>
        @endforeach

        <option value="0" data-vat-exempt="0" selected>No Discount</option>
    </select>
</div>



          {{-- Total (VAT inclusive) --}}
          <input type="hidden" id="total_inclusive" value="{{ $totalInclusive ?? 0 }}">

          <div class="row mb-3">
            <div class="col">
              <label class="form-label fw-bold">Net Sales</label>
              <input type="text" id="net-sales" 
                     value="{{ number_format(($totalVatable ?? 0), 2) }}" 
                     class="form-control form-control-lg text-end" readonly>
            </div>
            <div class="col">
              <label class="form-label fw-bold">VAT ({{ $vatRate }}%)</label>
              <input type="text" name="vat" id="vat"
                       value="{{ number_format(($totalVat ?? 0), 2) }}" 
                     class="form-control form-control-lg text-end" readonly>
 
            </div>

                <div class="col">
                <label class="form-label fw-bold">VAT Status</label>
                <input type="text" name="vat_status" id="vat-status"  
                    class="form-control form-control-lg text-center" 
                    value="Taxable" readonly>
                 </div>



          <div class="form-group mb-3">
            <label class="form-label fw-bold">Total (Before Discount)</label>
            <input type="text" id="before-discount" 
                   class="form-control form-control-lg text-end bg-secondary text-white fw-bold" readonly>
          </div>

          <div class="form-group mb-3">
            <label class="form-label fw-bold">Total (After Discount)</label>
            <input type="text" id="after-discount" name="total" 
                   class="form-control form-control-lg text-end bg-success text-white fw-bold" readonly>
          </div>

          <div class="form-group mb-3">
            <label class="form-label fw-bold">Pay Amount</label>
            <input name="pay" id="paynow" type="number" step="0.01"
                   class="form-control form-control-lg text-end border-primary" required>
          </div>

          <div class="form-group mb-3">
            <label class="form-label fw-bold">Change / Due</label>
            <input type="text" id="due" 
                   class="form-control form-control-lg text-end bg-warning fw-bold" readonly>
          </div>



          <div class="mt-4 text-center">
            <button class="btn btn-lg btn-dark-gray px-5 rounded-pill shadow" id="submitPaymentBtn" type="submit">
              Complete Payment
            </button>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<style>
    .required-highlight {
        border: 2px solid red;
        background-color: #fff0f0;
    }

    .required-label::after {
        content: " *";
        color: red;
    }
</style>

<script>
$(document).ready(function () {
    const paymentSelect = $('#payment_method_select');
    const referenceInput = $('#reference_number');
    const referenceLabel = $("label[for='reference_number']");
    const form = $('form');

    // When payment method changes
    paymentSelect.on('change', function () {
        if ($(this).val() === 'gcash') {
            referenceInput.prop('required', true).addClass('required-highlight');
            referenceLabel.addClass('required-label');
        } else {
            referenceInput.prop('required', false)
                          .removeClass('required-highlight is-invalid')
                          .val('');
            referenceLabel.removeClass('required-label');
            $('.gcash-error').remove();
        }
    });

    // Realtime validation for reference number
    referenceInput.on('input', function () {
        const refValue = $(this).val().trim();
        const gcashPattern = /^[0-9]{13}$/; // 13-digit pattern

        // Remove any previous error
        $('.gcash-error').remove();

        if (refValue === '') {
            // Empty input = red highlight (required)
            $(this).addClass('is-invalid');
            
        } else if (gcashPattern.test(refValue)) {
            $(this).removeClass('is-invalid required-highlight');


        } else {
            $(this).addClass('is-invalid');
            $(this).after('<small class="text-danger gcash-error">GCash reference must be 13 digits.</small>');
        }
    });

    // Final validation before submitting
    form.on('submit', function (e) {
        if (paymentSelect.val() === 'gcash') {
            const refValue = referenceInput.val().trim();
            const gcashPattern = /^[0-9]{13}$/;

            if (!gcashPattern.test(refValue)) {
                e.preventDefault();
                referenceInput.addClass('is-invalid');
                $('.gcash-error').remove();
                referenceInput.after('<small class="text-danger gcash-error">Please enter a valid 13-digit GCash reference number.</small>');
            }
        }
    });
});
</script>



<style>
.required-highlight {
    border: 2px solid red !important;
}
.is-invalid {
    border-color: red !important;
    box-shadow: 0 0 4px rgba(255, 0, 0, 0.6);
}
.required-label::after {
    content: " *";
    color: red;
    font-weight: bold;
}
</style>


             <script type="text/javascript">
            $(document).ready(function (){
                $('#MyForm').validate({
                    rules: {
                        payment_id: {
                            required : true,
                        }, 
                           }, 
                                    messages :{
                customer_id: {
                    required : 'Please Select Payment Method',
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





<script>
$(function () {
  $("#paymentPickupForm").on("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Submit Payment?",
      text: "Are you sure you want to submit the payment?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, submit",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        let form = $("#paymentPickupForm");
        let url = form.attr("action");
        let formData = form.serialize();

        $.post(url, formData, function (response) {
          if (response.success) {

            
            Swal.fire({
              title: "Success!",
              text: "Payment completed successfully.",
              icon: "success",
              confirmButtonText: "OK"
            }).then(() => {
              // Redirect to invoice print route
              window.location.href = "/invoice/print/" + response.order_id;
            });
          } else {
            Swal.fire("Error", response.message || "Something went wrong", "error");
          }
        }).fail(function (xhr) {
          Swal.fire("Error", xhr.responseJSON?.message || "Server error", "error");
        });
      }
    });
  });
});
</script>




<script>
$(document).ready(function() {
    // --- INITIAL SETUP ---
    const totalInclusive = parseFloat($('#total_inclusive').val()) || 0;
    const vatRate = parseFloat({{ $vatRate }}) || 0;

    function calculate() {
        const discountRate = parseFloat($('#discount').val()) || 0; // e.g. 20
        const vatExempt = $('#discount').find(':selected').data('vat-exempt'); // 1 or 0



        const discountValue = totalInclusive * (discountRate / 100);
        const afterDiscount = totalInclusive - discountValue;

        let netSales, vatAmount;

        // 3️⃣ If VAT exempt → remove VAT entirely
        if (vatExempt == 1) {
            $('#vat-status').val('VAT Exempt');
            vatAmount = 0;
            netSales = afterDiscount; // no VAT separation
        } else {
            $('#vat-status').val('Taxable');
            netSales = afterDiscount / (1 + (vatRate / 100));
            vatAmount = afterDiscount - netSales;
        }

        // 4️⃣ Update display fields
        $('#net-sales').val(netSales.toFixed(2));
        $('#vat').val(vatAmount.toFixed(2));
    }

    // --- INITIALIZE ON PAGE LOAD ---
    const initialVatExempt = $('#discount').find(':selected').data('vat-exempt');
    $('#vat-status').val(initialVatExempt == 1 ? 'VAT Exempt' : 'Taxable');

    // --- RE-CALCULATE WHEN DISCOUNT CHANGES ---
    $('#discount').on('change', calculate);

    // --- RUN ONCE TO POPULATE DEFAULT VALUES ---
    calculate();
});
</script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    //pag-load ng page, hintayin muna lahat ng HTML elements bago mag-run ang script

    const totalInclusive = parseFloat(document.getElementById("total_inclusive").value) || 0;
    //parseFloat = convert text → number.   
    
    const beforeDiscountEl = document.getElementById("before-discount");
    const afterDiscountEl = document.getElementById("after-discount");
    const discountEl = document.getElementById("discount");
    const payEl = document.getElementById("paynow");
    const dueEl = document.getElementById("due");

    /// Get references sa mga input fields na ia-update natin later.



    function calculate() {
        // discount %
        const discountRate = parseFloat(discountEl.value) || 0;
        // fall back to 0 if NaN or wala value

        const beforeDiscount = totalInclusive;
        beforeDiscountEl.value = beforeDiscount.toFixed(2);
        // total pasok na ung vat then make it dec_imal 2 places 1100.00

        // after discount
        const discountValue = beforeDiscount * (discountRate / 100);
        const afterDiscount = beforeDiscount - discountValue;
        afterDiscountEl.value = afterDiscount.toFixed(2);

        
        // payment difference
        const payAmount = parseFloat(payEl.value) || 0;
        const balance = payAmount - afterDiscount;
        /// Input Payment amount - minus total after discount


        /// kung negative → due pa, kung positive → change
        // if negative → still due, if positive → change
        if (balance < 0) {
            dueEl.value = `Due: ${Math.abs(balance).toFixed(2)}`;
        } else {
            dueEl.value = `Change: ${balance.toFixed(2)}`;
        }
    }

    discountEl.addEventListener("change", calculate);
    payEl.addEventListener("input", calculate);

    // Kapag may binago sa discount dropdown o pay amount, 
    // automatic mag-run ulit calculate() para realtime update.
    // run once para lumabas agad yung initial totals kahit wala pang binabago.
    calculate();
});
</script>







@endsection