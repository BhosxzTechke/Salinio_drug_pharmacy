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
    $validated = $request->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|email|unique:customers,email|max:200',
        'phone' => [
            'required',
            'unique:customers,phone',
            'regex:/^(\+?63|0)9\d{9}$/', // Valid PH numbers
        ],
        'address' => 'required|string|max:400',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // 10MB
        'password' => 'nullable|string|min:6|confirmed',
    ], [
        'email.unique' => 'This email is already registered.',
        'phone.regex' => 'The phone number must be valid (e.g., 09123456789 or +639123456789).',
        'image.max' => 'The image must not exceed 10MB.',
        'image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
    ]);

    try {


        $save_url = null;
        if ($request->hasFile('image')) {
            $save_url = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'customers']
            )->getSecurePath();
        }

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'image' => $save_url,
            'password' => isset($validated['password'])
                ? Hash::make($validated['password'])
                : null,
            'added_by_staff' => '1', // Since added from backend
            'created_at' => now(),
            'updated_at' => now(),
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

        return redirect()->route('all.customer')->with([
            'message' => 'Customer inserted successfully.',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        Log::error('Error saving customer: ' . $e->getMessage());

        return back()->with([
            'message' => 'Something went wrong while saving the customer.',
            'alert-type' => 'error'
        ])->withInput();
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
    $customerId = $request->input('id');


    
    $validated = $request->validate([
        'name'   => 'required|string|max:200',
        'email'  => [
            'required',
            'email',
            'max:200',
            Rule::unique('customers', 'email')->ignore($customerId),
        ],
        'phone'  => [
            'required',
            'regex:/^(\+?63|0)9\d{9}$/',
            Rule::unique('customers', 'phone')->ignore($customerId),
        ],
        'address' => 'required|string|max:400',
        'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
    ], [
        'email.unique' => 'This email is already registered.',
        'phone.unique' => 'This phone number is already registered.',
        'phone.regex'  => 'The phone number must be valid (e.g., 09123456789 or +639123456789).',
        'image.max'    => 'The image must not exceed 10MB.',
        'image.mimes'  => 'Only JPG, JPEG, and PNG formats are allowed.',
    ]);

    try {
        $customer = Customer::findOrFail($customerId);
        $oldData = $customer->toArray();

        $data = [
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            // Try to delete old Cloudinary image
            if ($customer->image) {
                try {
                    // Extract the Cloudinary public ID correctly
                    $publicId = collect(explode('/', parse_url($customer->image, PHP_URL_PATH)))
                        ->last(); // filename.ext
                    $publicId = pathinfo($publicId, PATHINFO_FILENAME);

                    Cloudinary::destroy('customers/' . $publicId);
                } catch (\Exception $e) {
                    Log::warning('Could not delete old customer image: ' . $e->getMessage());
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
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => Arr::only($oldData, ['name', 'email', 'phone']),
                'new' => Arr::only($newData, ['name', 'email', 'phone']),
            ])
            ->log('Updated customer information.');

        return redirect()->route('all.customer')->with([
            'message' => 'Customer updated successfully.',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating customer: ' . $e->getMessage());

        return back()->with([
            'message' => 'Something went wrong while updating the customer.',
            'alert-type' => 'error'
        ])->withInput();
    }
}




    
}


