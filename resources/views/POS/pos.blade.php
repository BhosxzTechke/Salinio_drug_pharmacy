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
                                            <li class="breadcrumb-item active">Pos</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Point of Sales</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->



<div class="row">
        <div class="col-lg-6 col-xl-6">
            <div class="card text-center">


                    <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>


        @php
        $allItem = Cart::content();
        $ProductsItem = $allItem->where('options', '!=', null);

        
        @endphp
        <tbody id="cart-body">
            @foreach ($ProductsItem as $item)
                
            <tr>
                <td>{{$item->name}}</td>
                
                <form method="POST" action="{{ url('/pos/ChangeQty/' . $item->rowId )}}">
                @csrf

                <td><input type="number" name="qty" value="{{ $item->qty }}" min="1" style="width: 40px;">
                <button type="submit" class="btn btn-sm btn-success" style="margin-top:-2px ;"> <i class="fas fa-check"></i> </button></td>
                

                <td>{{$item->price * $item->qty}}</td>
                <td>{{$item->subtotal}}</td>
                </form>


                            

                            <td>
                                <form action="{{ url('/pos-RemovePrd/' . $item->rowId) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button></a>
                            </form>
                            </td>
                        

                        </tr>
                         @endforeach
                    </tbody>
                                            </table>
                                        </div> <!-- end .table-responsive-->
                                    </div>

                                    <div class="bg-light">

                                    </div>

                <div class="card text-bg-info">
                <div class="card-body bg-dark">


                    <hr>

                    

                <p class="text-start">
                    <strong>Vatable Sales:</strong> ₱{{ number_format($totalVatable, 2) }}
                </p>

                <p class="text-start">
                    <strong>VAT ({{ $vatRate }}%):</strong> ₱{{ number_format($totalVat, 2) }}
                </p>

                <hr class="my-2">

                <p class="text-start">
                    <strong>Total Amount Due (Inclusive):</strong> ₱{{ number_format($totalInclusive, 2) }}
                </p>

  <div class="form-group mb-3" style="text-align: left; margin-left: 15px; margin-top: 10px;">

           <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoice-modal" 
                @if(Cart::count() == 0) disabled @endif>
                Proceed Payment
           </button>

   <br>
          </div>


                </div>
                </div>





            <form id="MyForm" action="{{ url('/create-invoice') }}" method="POST">
            @csrf


                <div class="form-group mb-9" style="text-align: left; margin-left: 15px; margin-top: 10px;">
                    <select name="customer_id" class="form-control @error('customer') is-invalid @enderror" id="customer" style="width:95%; margin-left: 15px; ">
                            <option selected disabled >Select Customer </option>
                                    @foreach ($Customer as $data)

                                    <option value="{{ $data->id }}">{{ $data->name }}</option>

                                @endforeach
                    </select>

                    <br>

                </div>

                    <button type="submit" class="btn btn-blue waves-effect"@if(Cart::count() == 0) disabled @endif>
Create Invoice for Customer</button>
                    
                </form>



                            <br>                                        
                                              
                        </div> <!-- end card -->
                     </div> <!-- end col-->

                              <div class="col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body"> 
                                           

    <!-- end timeline content-->

    <div class="tab-pane" id="settings">



<div class="container-fluid">
    <!-- Search + Filter Row -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="productSearch" class="form-control" placeholder="🔎 Search products...">
        </div>
        <div class="col-md-6">
            <select id="categoryFilter" class="form-select">
                <option value="">All Categories</option>
                @foreach($AllCategory as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
    </div>




    <!-- Product Grid -->
    <div class="row g-2" id="productGrid">
        @foreach($PosData as $key => $item)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 product-card" 
                 data-name="{{ strtolower($item->product->product_name) }}" 
                 data-category="{{ $item->product->category_id }}">
                <div class="card shadow-sm h-100 text-center p-2" style="border-radius: 12px;">
                    <img src="{{ asset($item->product->product_image) }}" 
                         class="mx-auto d-block" 
                         style="height: 70px; object-fit: contain;">

                    <div class="mt-2">
                        <strong class="d-block text-truncate" style="font-size: 0.85rem;">
                            {{ $item->product->product_name }}
                        </strong>
                        <small class="text-muted d-block mb-1">
                            ₱{{ number_format($item->product->selling_price, 2) }}
                        </small>
                        <span class="badge bg-warning text-dark mb-1" style="font-size: 0.75rem;">
                            Stock: {{ $item->total_quantity }}
                        </span>


                        <form method="POST" action="{{ url('/pos/add') }}">
                            @csrf

                            <input type="hidden" name="id" value="{{ $item->product_id }}">
                            <input type="hidden" name="name" value="{{ $item->product->product_name }}">
                            <input type="hidden" name="qty" value="1">
                            <input type="hidden" name="selling_price" value="{{ $item->product->selling_price }}">

                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>




<div id="invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg"> {{-- make it bigger --}}
    <div class="modal-content shadow-lg rounded-3">
      <div class="modal-body bg-light">

        <form id="paymentForm" method="post" action="{{ route('payment.walkin')}}" class="px-3">
          @csrf

          <h2 class="text-center mb-4 fw-bold text-primary">Cashier Invoice</h2>

          {{-- Payment Method --}}

           <div class="col">
                <label class="form-label fw-bold">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method"  
                    class="form-control form-control-lg text-center" 
                    value="Handcash" readonly>
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
            <button class="btn btn-lg btn-primary px-5 rounded-pill shadow" type="submit">
              Complete Payment
            </button>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


    
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
            $(document).ready(function (){
                $('#MyForm').validate({
                    rules: {
                        customer_id: {
                            required : true,
                        }, 
                           }, 
                                    messages :{
                customer_id: {
                    required : 'Please Select Customer',
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




{{-- product js search filtering --}}
        <script>
            const searchInput = document.getElementById('productSearch');
            const categoryFilter = document.getElementById('categoryFilter');
            const productCards = document.querySelectorAll('.product-card');

                function filterProducts() {
                    const searchText = searchInput.value.toLowerCase();
                    const selectedCategory = categoryFilter.value;

                    productCards.forEach(card => {
                        const name = card.dataset.name;
                        const category = card.dataset.category;

                        const matchesSearch = name.includes(searchText);
                        const matchesCategory = !selectedCategory || category === selectedCategory;

                        card.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                    });
                }

            searchInput.addEventListener('keyup', filterProducts);
            categoryFilter.addEventListener('change', filterProducts);
</script>

 



        {{-- For Discound and Calculation Inside the modal  --}}
{{-- Script --}}


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






<script>
$(function () {
  $("#paymentForm").on("submit", function (e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr("action");  // dynamically get the Laravel route
    let formData = form.serialize();

   
    $.post(url, formData, function (response) {
      if (response.success) {
        Swal.fire({
          title: "Print Receipt?",
          text: "Order completed successfully. Do you want to print the receipt?",
          icon: "question",
          showCancelButton: true,
          confirmButtonText: "Yes, Print",
          cancelButtonText: "No, Skip",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/pos/receipt/" + response.order_id;
          } else {
            window.location.href = "/pos";
          }
        });
      } else {
        Swal.fire("Error", response.message || "Something went wrong", "error");
      }
    }).fail(function (xhr) {
      Swal.fire("Error", xhr.responseJSON?.message || "Server error", "error");
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



@endsection



