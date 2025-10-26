@extends('admin_dashboard')
@section('admin')
<link rel="stylesheet" href="{{asset('backend/assets/css/attend.css')}}">



<style>
   .switch-toggle{
   width: auto;
   }
   .switch-toggle label:not(.disabled){
   cursor: pointer;
   }
   .switch-candy a{
   border: 1px solid #333;
   border-radius: 3px;
   background-color: white;
   background-image: -webkit-linear-gradient(top,rgba(255, 255, 255, 0.2), transparent);
   background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), transparent);
   }
   .switch-toggle.switch-candy, .switch-light.switch-candy > span{
   background-color: #5a6268;
   border-radius: 3px;
   box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3), 0 1px 0 rgba(255, 255, 255, 0.2);
   }
</style>
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
                     <h4>
                         
                                          
                  <div class="text-sm-start text-center mb-3">
                  <a 
                     href="{{ route('employee.attendance.list') }}" 
                     class="btn btn-primary btn-sm w-100 w-sm-auto"
                  >
                     <i class="fas fa-list"></i> Employee Attendance List
                  </a>
                  </div>
                
                
                     </h4>
                  </ol>
               </div>
            </div>
         </div>
      </div>



      <!-- end page title --> 
      <div class="row">
         <div class="col-12">
            <div class="card">




<div class="card-body">
  <form action="{{ route('employee.store.attendance') }}" method="post" id="myForm">
    @csrf

    <!-- Attendance Date -->
    <div class="row mb-3">
      <div class="col-md-4 col-sm-12">
        <label for="date" class="form-label fw-bold">Attendance Date</label>
        <input 
          type="date" 
          name="date" 
          id="date" 
          class="form-control form-control-sm singledatepicker" 
          placeholder="Attendance Date" 
          autocomplete="off" 
          required
        >
      </div>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-3">
        <thead class="table-dark text-center">
          <tr>
            <th rowspan="2" style="vertical-align: middle;">Sl.</th>
            <th rowspan="2" style="vertical-align: middle;">Name</th>
            <th rowspan="2" style="vertical-align: middle;">Role</th>
            <th colspan="3" style="vertical-align: middle;">Attendance Status</th>
          </tr>
          <tr>
            <th class="text-center present_all" style="background-color:#114190; color: #fff;">Present</th>
            <th class="text-center leave_all" style="background-color:#114190; color: #fff;">Leave</th>
            <th class="text-center absent_all" style="background-color:#114190; color: #fff;">Absent</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($user as $key => $employee)
            <tr class="text-center">
              <input type="hidden" name="employee_id[]" value="{{ $employee->id }}" class="employee_id">

              <td>{{ $key + 1 }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->getRoleNames()->first() }}</td>

              <td colspan="3">
                <div class="d-flex justify-content-center flex-wrap gap-2">
                  <div class="form-check form-check-inline">
                    <input 
                      class="form-check-input present" 
                      type="radio" 
                      name="attend_status{{ $key }}" 
                      id="present{{ $key }}" 
                      value="present" 
                      checked
                    >
                    <label class="form-check-label" for="present{{ $key }}">Present</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input 
                      class="form-check-input leave" 
                      type="radio" 
                      name="attend_status{{ $key }}" 
                      id="leave{{ $key }}" 
                      value="Leave"
                    >
                    <label class="form-check-label" for="leave{{ $key }}">Leave</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input 
                      class="form-check-input absent" 
                      type="radio" 
                      name="attend_status{{ $key }}" 
                      id="absent{{ $key }}" 
                      value="Absent"
                    >
                    <label class="form-check-label" for="absent{{ $key }}">Absent</label>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Submit Button -->
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-success btn-sm px-4">
        Submit
      </button>
    </div>
  </form>
</div>
               
            </div>
            <!-- end card -->
         </div>
         <!-- end col-->
      </div>
      <!-- end row-->
   </div>
   <!-- container -->
</div>
<!-- content -->

<script type="text/javascript">
      $(document).on('click','.present',function(){
      $(this).parents('tr').find('.datetime').css('pointer-events','none').css('background-color','#dee2e6').css('color','#495057');
      });
      $(document).on('click','.leave',function(){
      $(this).parents('tr').find('.datetime').css('pointer-events','').css('background-color','white').css('color','#495057');
      });
      $(document).on('click','.absent',function(){
      $(this).parents('tr').find('.datetime').css('pointer-events','none').css('background-color','#dee2e6').css('color','#dee2e6');
      });
</script>
<script type="text/javascript">
      $(document).on('click','.present_all',function(){
      $("input[value=Present]").prop('checked',true);
      $('.datetime').css('ponter-events','none').css('background-color','#dee2e6').css('color','#495057');
      });
      $(document).on('click','.leave_all',function(){
      $("input[value=Leave]").prop('checked',true);
      $('.datetime').css('ponter-events','').css('background-color','white').css('color','#495057');
      });
      $(document).on('click','.absent_all',function(){
      $("input[value=Absent]").prop('checked',true);
      $('.datetime').css('ponter-events','none').css('background-color','#dee2e6').css('color','#dee2e6');
      });
</script>


@endsection