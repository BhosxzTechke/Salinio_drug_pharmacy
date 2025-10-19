<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class SupplierController extends Controller
{
    //

    public function SupplierTable(){

        $SupplierData = Supplier::all();
        return view('Supplier.AllSuplier', compact('SupplierData'));


    }

        public function AddFormSupplier(){

        return view('Supplier.AddSuplier');


    }


public function StoreFormSupplier(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|email|unique:suppliers,email|max:200',
        'phone' => 'required|string|max:200|unique:suppliers,phone','regex:/^(09|\+639|639)\d{9}$/',
        'address' => 'required|string|max:400',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    try {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        // Resize and save image
        Image::make($image)
            ->resize(300, 300)
            ->save(public_path('uploads/supplier_image/') . $name_gen);

        $saveurl = 'uploads/supplier_image/' . $name_gen;

        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'image' => $saveurl,
            'created_at' => Carbon::now(),
        ]);

        activity('supplier')
            ->causedBy(auth()->user())
            ->performedOn($supplier)
            ->withProperties([
                'name' => $supplier->name,
                'email' => $supplier->email,
                'phone' => $supplier->phone,
            ])
            ->log('Added new Supplier');

        $notification = [
            'message' => 'Supplier saved successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.supplier')->with($notification);

    } catch (\Exception $e) {

        return redirect()->back()->withInput()->with([
            'message' => 'Something went wrong: ' . $e->getMessage(),
            'alert-type' => 'error',
        ]);
    }
}







    public function EditFormSupplier($id){

        $supplier = Supplier::findOrFail($id);
        return view('Supplier.EditSupplier',compact('supplier'));

    } // End Method 


public function UpdateSupplier(Request $request)
{
    $supplier_id = $request->id;

    try {
        $supplier = Supplier::findOrFail($supplier_id);
        $oldData = $supplier->toArray();

        
            $request->validate([
                'name' => 'required|max:200',
                'email' => 'required|email|max:200|unique:suppliers,email,' . $supplier_id,
                'phone' => [
                    'required',
                    'max:200',
                    'unique:suppliers,phone,' . $supplier_id,
                    'regex:/^(09|\+639|639)\d{9}$/'
                ],
                'address' => 'required|max:400',
                'city' => 'required|max:100',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'name.required' => 'Please enter the supplier\'s name.',
                'name.max' => 'Supplier name cannot exceed 200 characters.',

                'email.required' => 'Please enter an email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'Email cannot exceed 200 characters.',
                'email.unique' => 'This email is already taken.',

                'phone.required' => 'Please enter a phone number.',
                'phone.max' => 'Phone number cannot exceed 200 characters.',
                'phone.unique' => 'This phone number is already used.',
                'phone.regex' => 'Phone number must start with 09, +639, or 639 and contain 9 digits after.',

                'address.required' => 'Please enter an address.',
                'address.max' => 'Address cannot exceed 400 characters.',

                'city.required' => 'Please enter a city.',
                'city.max' => 'City name cannot exceed 100 characters.',

                'image.image' => 'Uploaded file must be an image.',
                'image.mimes' => 'Image must be a JPG, JPEG, PNG, or WEBP file.',
                'image.max' => 'Image must not be larger than 2MB.',
            ]);



        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
        ];

        if ($request->hasFile('image')) {
            if ($supplier->image && file_exists(public_path($supplier->image))) {
                unlink(public_path($supplier->image));
            }

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->resize(300, 300)->save('uploads/supplier_image/' . $name_gen);
            $data['image'] = 'uploads/supplier_image/' . $name_gen;
        }

        $supplier->update($data);

        activity()
            ->performedOn($supplier)
            ->causedBy($request->user())
            ->withProperties([
                'old' => $oldData,
                'new' => $supplier->fresh()->toArray(),
            ])
            ->log('Updated Supplier information.');

        return redirect()->route('all.supplier')->with([
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        \Log::error('Supplier Update Failed', [
            'error' => $e->getMessage(),
            'supplier_id' => $supplier_id
        ]);

        return redirect()->back()->with([
            'message' => 'Something went wrong while updating the supplier. Please try again.',
            'alert-type' => 'error'
        ]);
    }
}


    
public function DeleteFormSupplier($id)
{
    try {
        $supplier = Supplier::findOrFail($id);
        $oldData = $supplier->toArray();


            if ($supplier->inventories()->exists()) {
                return redirect()->back()->with([
                    'message' => 'Cannot delete supplier — inventory exists.',
                    'alert-type' => 'warning'
                ]);
            }

        if ($supplier->image && file_exists(public_path($supplier->image))) {
            unlink(public_path($supplier->image));
        }

        $supplier->delete();

        activity()
            ->performedOn($supplier)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $oldData,
            ])
            ->log('Deleted a Supplier record.');

        return redirect()->back()->with([
            'message' => 'Supplier deleted successfully.',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        \Log::error('Failed to delete supplier', [
            'error' => $e->getMessage(),
            'supplier_id' => $id
        ]);

        return redirect()->back()->with([
            'message' => 'An error occurred while trying to delete the supplier.',
            'alert-type' => 'error'
        ]);
    }
}


    public function DetailsSupplier($id) {

        $supplier = Supplier::findOrFail($id);
        return view('Supplier.DetailsSupplier', compact('supplier'));

    }




    
}
