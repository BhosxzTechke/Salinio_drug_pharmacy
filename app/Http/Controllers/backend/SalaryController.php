<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\AdvanceSalary;
use App\Models\PaySalary;

class SalaryController extends Controller
{
    //
    protected function getEmployeeSalary($employeeId)
{
    $employee = Employee::find($employeeId);

    return $employee ? $employee->salary : 0;
}



        public function SalaryTable() {

                $EmployeeData = Employee::latest()->get();

                $previousMonth = strtolower(Carbon::now()->subMonth()->format('F'));

                $SalaryData = AdvanceSalary::all();

             foreach ($EmployeeData as $employee) {
             $employeeMonthPaid = strtolower($employee->salary_month_paid ?? '');

            $employee->is_paid = ($employee->salary_status === 'Paid') && ($employeeMonthPaid === $previousMonth);
                 }

                return view('Salary.AllSalary', compact('SalaryData', 'employee'));


        }




        public function AddFormSalary(){

            $Employee = Employee::latest()->get();
            return view('Salary.AddAdvancedSalary',compact('Employee'));


        }


        public function StoreFormSalary(request $request) {


                $monthMap = [
                'january' => 1,
                'february' => 2,
                'march' => 3,
                'april' => 4,
                'may' => 5,
                'june' => 6,
                'july' => 7,
                'august' => 8,
                'september' => 9,
                'october' => 10,
                'november' => 11,
                'december' => 12,
            ];

            // Convert string month to number
            $numericMonth = $monthMap[$request->month];


                    $validatedData = $request->validate([
                        'month' => 'required',
                        'year' => 'required',
                        'employeeID' => 'required|exists:employees,id',
                        'advance_salary' => 'required|numeric|min:0',
                    ]);


                   $numericMonth = $monthMap[$request->month];
                    $inputDate = Carbon::createFromDate($request->year, $numericMonth, 1);


                    if ($inputDate->isFuture()) {
                        return redirect()->back()->with([
                            'message' => 'You cannot add advance salary for a future month.',
                            'alert-type' => 'error',
                        ]);
                    }

                    


                    $existing = AdvanceSalary::where('month', $request->month)
                        ->where('year', $request->year)
                        ->where('employee_id', $request->employeeID)
                        ->first();

                    if ($existing) {
                        return redirect()->back()->with([
                            'message' => 'Advance salary already added for this employee and month.',
                            'alert-type' => 'warning',
                        ]);
                    }



                    // ✅ STEP 4: Optional - check if advance > employee salary
                    $employee = Employee::find($request->employeeID);
                    if ($request->advance_salary > $employee->salary) {
                        return redirect()->back()->with([
                            'message' => 'Advance salary cannot exceed the employee\'s base salary.',
                            'alert-type' => 'error',
                        ]);
                    }


                    
                    // ✅ STEP 5: Save the record
                    AdvanceSalary::create([
                        'month' => $request->month,
                        'year' => $request->year,
                        'advance_salary' => $request->advance_salary,
                        'employee_id' => $request->employeeID,
                    ]);

                    return redirect()->route('all.salary')->with([
                        'message' => 'Advance salary added successfully!',
                        'alert-type' => 'success',
                    ]);


                }



                        public function EditFormSalary($id) {


                                $Employee = Employee::latest()->get();
                                $SalaryData = AdvanceSalary::findOrFail($id);

                                return view('Salary.EditAdvancedSalary', compact('SalaryData','Employee'));


                        }


                        public function UpdateFormSalary(Request $request)
                        {
                            $salaryID = $request->id;

                            // Validation rules
                            $request->validate([
                                'employee_id' => 'required|exists:employees,id',
                                'month' => 'required|min:1|max:12',
                                'year' => 'required|integer|min:2000|max:' . date('Y'),
                                'advance_salary' => 'required|numeric|min:0',
                            ]);

                            // Optional: Check if advance_salary is greater than employee salary (if you have employee salary info)
                            // Assuming you have a method getEmployeeSalary(employee_id)
                        

                            $employeeSalary = $this->getEmployeeSalary($request->employee_id);

                            if ($request->advance_salary > $employeeSalary) {
                                return back()->withErrors(['advance_salary' => 'Advance salary cannot be greater than the actual salary.']);
                            }
                         



                            $advanceSalary = AdvanceSalary::findOrFail($salaryID);

                            $advanceSalary->update([
                                'employee_id' => $request->employee_id,
                                'month' => $request->month,
                                'year' => $request->year,
                                'advance_salary' => $request->advance_salary,
                                'created_at' => Carbon::now(),
                            ]);

                            $notification = [
                                'message' => 'Salary Updated Successfully',
                                'alert-type' => 'success',
                            ];

                            return redirect()->route('all.salary')->with($notification);
                        }


                    public function PaySalaryTable() {
                        $EmployeeData = Employee::latest()->get();

                        // Get the previous month, lowercase to match stored values
                        $previousMonth = strtolower(Carbon::now()->subMonth()->format('F')); // e.g. "june"

                        foreach ($EmployeeData as $employee) {

                            $employeeMonthPaid = strtolower($employee->salary_month_paid ?? '');

                            $employee->is_paid = ($employee->salary_status === 'Paid') && ($employeeMonthPaid === $previousMonth);
                        }

                        return view('Salary.PaySalary', compact('EmployeeData'));
                    }





                    public function ShowPayForm($id) {


                        $PayData = Employee::findOrFail($id);
                        return view('Salary.PayForm', compact('PayData'));
                            
                    }




                                
            public function PayNow(Request $request)
            {
                $request->validate([
                    'id' => 'required|exists:employees,id',
                    'month' => 'required|string',
                    'salary' => 'required|numeric|min:0',
                ]);

                $employeeId = $request->id;
                $month = $request->month;

                // Prevent duplicate salary payment
                $alreadyPaid = PaySalary::where('employee_id', $employeeId)
                    ->where('salary_month', $month)
                    ->exists();

                if ($alreadyPaid) {
                    return back()->withErrors(['salary' => 'Salary already paid for this month.']);
                }

                // Get employee and base salary
                $employee = Employee::findOrFail($employeeId);
                $salary = $request->salary;


                // kunin lahat ng unpaid in previous month then subtract it
                $unpaidAdvances = AdvanceSalary::where('employee_id', $employeeId)
                    ->where('is_paid', false)
                    ->get();

                $totalAdvance = $unpaidAdvances->sum('advance_salary');
                $netPay = $salary - $totalAdvance;




                PaySalary::create([
                    'employee_id'    => $employeeId,
                    'salary_month'   => $month,
                    'paid_amount'    => $salary,
                    'advanced_salary'=> $totalAdvance,
                    'due_salary'     => $netPay,
                    'created_at'     => Carbon::now(),
                ]);

                foreach ($unpaidAdvances as $advance) {
                    $advance->update(['is_paid' => true]);
                }

                $employee->update([
                    'salary_status' => 'Paid',
                    'salary_month_paid' => $month,
                ]);

                return redirect()->route('pay.salary')->with([
                    'message' => 'Salary paid successfully.',
                    'alert-type' => 'success',
                ]);
            }





                  public function DeleteSalary($id) {

                    $SalaryID  = AdvanceSalary::findOrFail($id);
                    
                    $SalaryID->delete();
                    
                        
                        
                    $notification = array(
                        'message' => 'Advance Salary Deleted Successfully',
                        'alert-type' => 'success'
                    );

                    return redirect()->route('all.salary')->with($notification); 

                    

                  }




                     


                public function TableMonthSalary(request $request) {

                 $PaidData = PaySalary::latest()->get();
                      
                 return view('Salary.LastPaidMonth', compact('PaidData'));
                    
          }


          public function ShowPaidHistory($id){

            $HistoryData = PaySalary::findOrFail($id);
            return view('Salary.PaidHistory', compact('HistoryData'));

          }
}

          

        