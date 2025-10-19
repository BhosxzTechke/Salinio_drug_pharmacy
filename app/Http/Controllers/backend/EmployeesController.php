<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class EmployeesController extends Controller
{
    //
    public function EmployeeTable() {

           $EmployeeData = Employee::all();
            return view('Employee.AllEmployee', compact('EmployeeData'));     // showing Employee  

    }


        public function AddFormEmployee() {

            return view('Employee.AddEmployee', );            // showing employee form 

    }

    public function StoreFormEmployee(Request $request){

         $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|unique:employees|max:200',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'salary' => 'required|max:200',
            'vacation' => 'required|max:200',  
            'city' => 'required|max:200',
            'experience' => 'required', 
            'image' => 'required',     

        ]);
 
        
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('uploads/employee_image/'.$name_gen);
        $save_url = 'uploads/employee_image/'.$name_gen;

        Employee::insert([

            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'experience' => $request->input('experience'),
            'salary' => $request->input('salary'),
            'vacation' => $request->input('vacation'),
            'city' => $request->input('city'),
            'image' => $save_url,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Employee Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification); 
    } // End Method 











      public function EditEmployee($id) {

     $EmployeeData = Employee::findOrFail($id);
     return view('Employee.EditEmployee', compact('EmployeeData'));            // showing employee form 

    }



                    // DELETE
            public function DeleteEmployee($id){
                $multi = Employee::findOrFail($id);

                $img_path = $multi->input('image'); // make sure tama ang field name
                if (file_exists($img_path)) {
                    unlink($img_path); // delete image file from storage
                }

                $multi->delete(); // delete database record

                $notification = array(
                    'message' => 'Employee Deleted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            }



    public function UpdateEmployee(Request $request){

        $employee_id = $request->input('id');

        if ($request->file('image')) {

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('uploads/employee_image/'.$name_gen);
        $save_url = 'uploads/employee_image/'.$name_gen;

        Employee::findOrFail($employee_id)->update([

            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'experience' => $request->input('experience'),
            'salary' => $request->input('salary'),
            'vacation' => $request->input('vacation'),
            'city' => $request->input('city'),
            'image' => $save_url,
            'created_at' => Carbon::now(), 

        ]);




         $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification); 
             
        } else{

            Employee::findOrFail($employee_id)->update([

                
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'experience' => $request->input('experience'),
            'salary' => $request->input('salary'),
            'vacation' => $request->input('vacation'),
            'city' => $request->input('city'),
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification); 



        
        } // End else Condition  


    } // End Method 

}
