<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Arr;


class CustomerController extends Controller
{
    //

    public function CustomerTable() {

        $CustomerData = Customer::latest()->get();
          return view('Customer.AllCustomer', compact('CustomerData'));

    }


    
    public function AddFormCustomer() {

          return view('Customer.AddCustomer');

    }



public function StoreFormCustomer(Request $request) 
{
    $request->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|email|unique:customers,email|max:200',
        'phone' => 'required|regex:/^09[0-9]{9}$/|max:20',
        'address' => 'required|string|max:400',
        'city' => 'required|string|max:100',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // image optional
        'password' => 'nullable|string|min:6|confirmed', // optional password
    ], [
        'email.unique' => 'This email is already registered.',
        'image.max' => 'The image must not be more than 2MB.',
        'image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
    ]);

    // Handle image upload
    $save_url = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('uploads/customer_image/'.$name_gen);
        $save_url = 'uploads/customer_image/'.$name_gen;
    }

    // Insert into customers table
    $customer = Customer::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'city' => $request->input('city'),
        'image' => $save_url,
        'password' => $request->filled('password') ? Hash::make($request->input('password')) : null,
        'added_by_staff' => 1, // since staff is adding this customer
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);


    $newData = $customer->fresh()->toArray();


        activity('customer')
        ->causedBy(auth()->user())
        ->performedOn($customer)
        ->withProperties([
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'new' => Arr::only($newData, ['name','email','phone']),
        ])

        ->log('Added new Customer');


    $notification = array(
        'message' => 'Customer Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.customer')->with($notification); 
}




 




        public function DeleteCustomer($id) {
            
            $customerID = Customer::findOrFail($id); // 2

        if ($customerID->image && file_exists($customerID->image)) {
            unlink($customerID->image);
        }
                // Store old data before deleting
           $oldData = $customerID->toArray();


            $customerID->delete();

            activity()
                ->performedOn($customerID)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old' => $oldData,
                ])
                ->log('Deleted a customer record.');



            $notification = array(
                'message' => 'Succesfully Deleted',
                'alert-type' => 'success'
            );

        return redirect()->back()->with($notification);

    }


    public function EditFormCustomer($id) {

        $CustomerID = Customer::findOrFail($id);

        return view('Customer.EditCustomer', compact('CustomerID'));


    }


public function UpdateFormCustomer(Request $request) 
{
    $CustomerID = $request->input('id');


    $request->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|email|unique:customers,email,'.$CustomerID,
        'phone' => 'required|regex:/^09[0-9]{9}$/|max:20',
        'address' => 'required|string|max:400',
        'city' => 'required|string|max:100',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'email.unique' => 'This email is already registered.',
        'image.max' => 'The image must not be more than 2MB.',
        'image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
    ]);

    
        $customer = Customer::findOrFail($CustomerID);
        $oldData = $customer->toArray();

    $data = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'city' => $request->input('city'),
        'updated_at' => Carbon::now(),
    ];

    // Handle image upload if exists
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('uploads/customer_image/'.$name_gen);
        $data['image'] = 'uploads/customer_image/'.$name_gen;
    }


        $customer->update($data);
            // Fetch new data AFTER update
        $newData = $customer->fresh()->toArray();


    activity()
        ->performedOn($customer)
        ->causedBy($request->user())
        ->withProperties([
                'old' => Arr::only($oldData, ['name','email','phone']),
                'new' => Arr::only($newData, ['name','email','phone'])
        ])
        ->log('Updated customer information.');

    $notification = [
        'message' => 'Customer Updated Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('all.customer')->with($notification); 
}



    




    
}


