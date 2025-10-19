
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Paid Salary </a></li>
                                            
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Paid Salary </h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

<div class="row">
    

  <div class="col-lg-8 col-xl-12">
<div class="card">
    <div class="card-body">
                                    
                                      
                                         
                                           

    <!-- end timeline content-->

    <div class="tab-pane" id="settings">
        <form method="post" action="" >
          @csrf
          <input type="hidden" name="id" value="{{ $HistoryData->id }}">

        	

            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Paid History </h5>

            <div class="row">

 
 <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname" class="form-label">Employee Name    </label>
             <strong style="color: #ea5600;">{{ $HistoryData->Employee->name ?? 'No name'  }}</strong>
             

        </div>
    </div>


 <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname" class="form-label" >Salary Month:    </label>
          <strong style="color: #ea5600;"> {{ $HistoryData->salary_month }}</strong>
        </div>
    </div>


      <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname" class="form-label">Employe Salary:    </label>
          <strong style="color: #ea5600;"> {{ $HistoryData->paid_amount }}</strong>
        </div>
    </div>


  <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname" class="form-label"> Advance Salary:  </label>
          <strong style="color: #ea5600;"> {{ $HistoryData->advanced_salary }}</strong>
           <input type="hidden" name="advance_salary" value="{{ $HistoryData->advance_salary }}">     

        </div>
    </div>


  <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname" class="form-label">Due Salary:    </label>
          <strong style="color: #ea5600;"> 
            <span>{{ $HistoryData->due_salary }}</span>
          </strong>

        </div>
    </div>
 


            </div> <!-- end row -->
 
        
            
            <div class="text-end">
               <a href="{{ route('table.month.salary') }}" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Go Back</button></a> 
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