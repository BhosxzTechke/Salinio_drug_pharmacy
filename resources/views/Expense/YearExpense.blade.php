
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
                                           <a href="{{ route('add.expense')}}"><button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Add Expense</button></a>
                                        </ol>

@php 

$year = date('Y');
$YearExpense = App\Models\Expense::where('year', $year)->sum('amount');

@endphp

                                    </div>
                                    <h4 class="page-title">Year Expense: ₱{{ $YearExpense }}</h4>
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
                                                    <th>Details</th>
                                                    <th>Amount</th>
                                                    <th>Month</th>
                                                    <th>Year </th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>

                                        </thead>
                                        
                                        
                                            <tbody>
                                                                        {{-- Expense lng ngaung araw --}}
                                            @php $sl = 1 @endphp
                                             @foreach ($YearData as $data)         
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>{{ $data->details }}</td>
                                                    <td>{{ $data->amount }}</td>
                                                    <td>{{ $data->month }}</td>
                                                    <td>{{ $data->year }}</td>
                                                    <td>{{ $data->date }}</td>
                                                    <td><a href="" class="btn btn-success rounded-pill waves-effect waves-light"><i class="fa-solid fa-square-pen"></i> Edit</a>
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


       
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javasc
                                    ript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>



        </div>
        <!-- END wrapper -->

@endsection
