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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log; 
use Illuminate\Validation\Rule;


class CustomerController extends Controller
{
    //

public function CustomerTable(Request $request)
{
    $query = Customer::query();

    // Filtering logic
    if ($request->has('source') && $request->source !== '') {
        if ($request->source == 'pos') {
            $query->where('added_by_staff', 1);
        } elseif ($request->source == 'ecommerce') {
            $query->where('added_by_staff', 0);
        }
    }

    $CustomerData = $query->latest()->get();

    return view('Customer.AllCustomer', compact('CustomerData'));
}



    
    public function AddFormCustomer() {

          return view('Customer.AddCustomer');

    }

public function StoreFormCustomer(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:customers,email|max:200',
            'phone' => [
                'required',
                'unique:customers,phone',
                'regex:/^(\+?63|0)9\d{9}$/', // 09123456789 or 639123456789 or +639123456789
            ],

            
            'address' => 'required|string|max:400',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // up to 10MB
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'image.max' => 'The image must not be more than 10MB.',
            'image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        ]);

        $save_url = null;
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'customers']
            )->getSecurePath();
            $save_url = $uploadedFileUrl;
        }

        $customer = Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'image' => $save_url,
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : null,
            'added_by_staff' => 1,
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

        $notification = [
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.customer')->with($notification);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();

    } catch (\Exception $e) {
        \Log::error('Error saving customer: ' . $e->getMessage());

        $notification = [
            'message' => 'Something went wrong while saving the customer.',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification)->withInput();
    }
}









public function DeleteCustomer($id)
{
    $customer = Customer::findOrFail($id);

    // Store old data for activity log
    $oldData = $customer->toArray();

    // Delete image from Cloudinary if it exists
    if ($customer->image) {
        try {
            $publicId = pathinfo($customer->image, PATHINFO_FILENAME);
            Cloudinary::destroy('customers/' . $publicId);
        } catch (\Exception $e) {
            \Log::warning('Could not delete customer image from Cloudinary: ' . $e->getMessage());
        }
    }

    // Delete the customer record
    $customer->delete();

    // Log activity
    activity()
        ->performedOn($customer)
        ->causedBy(auth()->user())
        ->withProperties([
            'old' => $oldData,
        ])
        ->log('Deleted a customer record.');

    $notification = [
        'message' => 'Successfully Deleted',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}








    public function EditFormCustomer($id) {

        $CustomerID = Customer::findOrFail($id);

        return view('Customer.EditCustomer', compact('CustomerID'));


    }

   

public function UpdateFormCustomer(Request $request)
{
    try {
        $CustomerID = $request->input('id');

        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:customers,email,' . $CustomerID,
            'phone' => [
                'required',
                'regex:/^(\+?63|0)9\d{9}$/',
                'max:14',
                Rule::unique('customers', 'phone')->ignore($CustomerID),
            ],
            'address' => 'required|string|max:400',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // 10MB
        ], [
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already registered.',
            'image.max' => 'The image must not be more than 10MB.',
            'image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        ]);

        $customer = Customer::findOrFail($CustomerID);
        $oldData = $customer->toArray();
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'updated_at' => Carbon::now(),
        ];

        if ($request->hasFile('image')) {

            // Delete old image from Cloudinary if exists
            if ($customer->image) {
                try {
                    $publicId = pathinfo($customer->image, PATHINFO_FILENAME);
                    Cloudinary::destroy('customers/' . $publicId);
                } catch (\Exception $e) {
                    Log::warning('Old customer image could not be deleted from Cloudinary: ' . $e->getMessage());
                }
            }

            // Upload new image
            $uploadedFileUrl = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'customers']
            )->getSecurePath();

            $data['image'] = $uploadedFileUrl;
        }

        $customer->update($data);
        $newData = $customer->fresh()->toArray();

        activity('customer')
            ->performedOn($customer)
            ->causedBy($request->user())
            ->withProperties([
                'old' => Arr::only($oldData, ['name', 'email', 'phone']),
                'new' => Arr::only($newData, ['name', 'email', 'phone']),
            ])
            ->log('Updated customer information.');

        $notification = [
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.customer')->with($notification);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();

    } catch (\Exception $e) {
        Log::error('Error updating customer: ' . $e->getMessage());

        $notification = [
            'message' => 'Something went wrong while updating the customer.',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification)->withInput();
    }
}

    




    
}


