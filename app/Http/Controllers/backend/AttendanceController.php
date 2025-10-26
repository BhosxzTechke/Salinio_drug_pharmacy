<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
    //



    public function AttendanceTable(){

        $AttendanceData =  Attendance::select('date')->groupBy('date')->orderBy('id','desc')->get();
        return view('Attendance.AllAttendance', compact('AttendanceData'));


    }


    

public function AddEmployeeAttendance()
{
    // Get employees with role Cashier or Staff
    $user = User::role(['Cashier', 'Staff'])->get();

    if ($user->isEmpty()) {
        $notification = [
            'message' => 'No Cashier or Staff found. Please add employees first.',
            'alert-type' => 'warning',
        ];

        return redirect()->back()->with($notification);
    }

    return view('Attendance.AddAttendance', compact('user'));
}



    

            //               SAVING EMPLOYEE ATTENDANCE
public function EmployeeAttendanceStore(Request $request)
{
    try {
        // Delete existing attendance for the selected date
        Attendance::where('date', date('Y-m-d', strtotime($request->input('date'))))->delete();

        $countEmployee = count($request->input('employee_id'));

        for ($i = 0; $i < $countEmployee; $i++) {
            $attend_status = 'attend_status' . $i;

            $attendance = new Attendance();
            $attendance->date = date('Y-m-d', strtotime($request->input('date')));
            $attendance->employee_id = $request->employee_id[$i]; 
            $attendance->attend_status = $request->$attend_status;
            $attendance->save();
        }

        $notification = [
            'message' => 'New Attendance Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('employee.attendance.list')->with($notification);

    } catch (\Exception $e) {
        \Log::error('Attendance store error: ' . $e->getMessage());

        $notification = [
            'message' => 'Something went wrong while saving attendance: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification);
    }
}

            //   EDIT ATTENNDANCE BASED ON DATE

           public function EmployeeAttendanceEdit($date){

            $Editattendance = attendance::where('date',$date,)->get();
            return view('Attendance.EditAttendance', compact( 'Editattendance'));


           }




        public function EmployeeAttendanceView($date) {

              $ViewAttendance = attendance::where('date',$date,)->get();

              return view('Attendance.ViewAttendance', compact('ViewAttendance'));

        }


        




    }







