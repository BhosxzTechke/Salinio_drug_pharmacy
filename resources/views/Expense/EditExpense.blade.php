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
                                            <li class="breadcrumb-item active">Expense</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

    <div class="col-lg-8 col-xl-12">
            <div class="card">
                <div class="card-body">

                        <div class="tab-pane" id="settings">



                <form method="POST" action="{{ route('update.expense')}}" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $ExpenseData->id }}">

                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Expense</h5>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="mb-12">
                                <label for="name" class="">Details </label>
                                    <textarea class="form-control" name="details" id="example-textarea" rows="5">{{ $ExpenseData->details ?? ''}}</textarea>                                                        
                                @error('details')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror 
                            </div>
                            <br>


                        </div>

                        <div class="col-md-12">
                            <div class="mb-6">
                                <label for="text" class="">Amount </label>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Enter Amount" min="1"    value="{{ $ExpenseData->amount ?? ''}}">
                                        @error('amount')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                </div>
                        </div> <!-- end col -->



                        <div class="col-md-12">
                            <div class="mb-6">
                                <input type="hidden" name="date" value="{{ date('d-m-Y') }}" class="form-control" id="amount" placeholder="Enter Amount"    value="{{ $ExpenseData->date ?? ''}}">
                        
                                </div>
                        </div> <!-- end col -->



                                                                                <div class="col-md-12">
                            <div class="mb-6">
                                <input type="hidden" name="month" value="{{ date('F') }}" class="form-control" id="amount" placeholder="Enter Amount"   value="{{ $ExpenseData->month ?? ''}}">
                        
                                </div>
                        </div> <!-- end col -->




                                                                                                                <div class="col-md-12">
                                                            <div class="mb-6">
                                                                <input type="hidden" name="year" value="{{ date('Y') }}" class="form-control" id="amount" placeholder="Enter Amount" value="{{ $ExpenseData->year ?? ''}}">

                                                            </div>
                                                        </div> <!-- end col -->





                                                    </div> <!-- end row -->
    
                                                    <div class="text-end">
                                                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Changes</button>
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



                            




@endsection