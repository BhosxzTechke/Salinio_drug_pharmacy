<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Models\Activity;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


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
    try {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:200',
                Rule::unique('suppliers')->where(function ($query) use ($request) {
                    return $query->where('address', $request->address);
                }),
            ],
            'email' => 'required|email|unique:suppliers,email|max:200',
            'phone' => [
                'required',
                'string',
                'max:200',
                'unique:suppliers,phone',
                'regex:/^(09|\+639|639)\d{9}$/',
            ],
            'address' => 'required|string|max:400',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB
        ], [
            'name.unique' => 'A supplier with the same name and address already exists.',
            'phone.regex' => 'Phone number must start with 09, +639, or 639 and contain 9 digits after.',
            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Image must be a JPG, JPEG, PNG, or WEBP file.',
            'image.max' => 'Image must not be larger than 10MB.',
        ]);



        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getRealPath();

            $uploaded = Cloudinary::upload($imagePath, [
                'folder' => 'suppliers',
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'limit',
                ],
            ]);

            $imageUrl = $uploaded->getSecurePath();
        }

        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageUrl,
            'created_at' => Carbon::now(),
        ]);



        activity('supplier')
            ->causedBy(auth()->user())
            ->performedOn($supplier)
            ->withProperties(Arr::only($supplier->toArray(), ['name', 'email', 'phone']))
            ->log('Added new Supplier');



        return redirect()->route('all.supplier')->with([
            'message' => 'Supplier saved successfully',
            'alert-type' => 'success',
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Validation errors
        return back()->withErrors($e->validator)->withInput();

    } catch (\Exception $e) {
        Log::error('Error saving supplier: ' . $e->getMessage());

        return redirect()->back()->with([
            'message' => 'Something went wrong while saving the supplier.',
            'alert-type' => 'error',
        ])->withInput();
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
            'name' => [
                'required',
                'string',
                'max:200',
                Rule::unique('suppliers')->where(function ($query) use ($request, $supplier_id) {
                    return $query->where('address', $request->address)
                                ->where('id', '!=', $supplier_id);
                }),
            ],
            'email' => 'required|email|max:200|unique:suppliers,email,' . $supplier_id,
            'phone' => [
                'required',
                'string',
                'max:200',
                'regex:/^(09|\+639|639)\d{9}$/',
                Rule::unique('suppliers', 'phone')->ignore($supplier_id),
            ],
            'address' => 'required|string|max:400',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB max
        ], [
            'name.unique' => 'A supplier with the same name and address already exists.',
            'phone.regex' => 'Phone number must start with 09, +639, or 639 and contain 9 digits after.',
            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Image must be JPG, JPEG, PNG, or WEBP.',
            'image.max' => 'Image must not be larger than 10MB.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];

        // 🖼 Handle image replacement
        if ($request->hasFile('image')) {
            // Delete old Cloudinary or local image if exists
            if ($supplier->image) {
                try {
                    if (str_contains($supplier->image, 'cloudinary.com')) {
                        // Delete old Cloudinary file
                        $publicId = basename($supplier->image, '.' . pathinfo($supplier->image, PATHINFO_EXTENSION));
                        Cloudinary::destroy('suppliers/' . $publicId);
                    } elseif (file_exists(public_path($supplier->image))) {
                        unlink(public_path($supplier->image));
                    }
                } catch (\Exception $ex) {
                    Log::warning("Old supplier image could not be deleted: " . $ex->getMessage());
                }
            }

            // Upload new image to Cloudinary
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'suppliers',
                    'transformation' => [
                        'width' => 300,
                        'height' => 300,
                        'crop' => 'limit',
                    ],
                ]
            );

            $data['image'] = $uploaded->getSecurePath();
        }

        $supplier->update($data);



        activity('supplier')
            ->performedOn($supplier)
            ->causedBy($request->user())
            ->withProperties([
                'old' => Arr::only($oldData, ['name', 'email', 'phone', 'address', 'image']),
                'new' => Arr::only($supplier->fresh()->toArray(), ['name', 'email', 'phone', 'address', 'image']),
            ])
            ->log('Updated Supplier information.');

        return redirect()->route('all.supplier')->with([
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success',
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();

    } catch (\Exception $e) {
        Log::error('Supplier Update Failed', [
            'error' => $e->getMessage(),
            'supplier_id' => $supplier_id,
        ]);

        return redirect()->back()->with([
            'message' => 'Something went wrong while updating the supplier. Please try again.',
            'alert-type' => 'error',
        ])->withInput();
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

        if ($supplier->image) {
            try {
                if (str_contains($supplier->image, 'cloudinary.com')) {


                    // Extract public ID from Cloudinary URL
                    $publicId = pathinfo($supplier->image, PATHINFO_FILENAME);
                    Cloudinary::destroy('suppliers/' . $publicId);
                } elseif (file_exists(public_path($supplier->image))) {
                    unlink(public_path($supplier->image));
                }
            } catch (\Exception $ex) {
                Log::warning('Failed to delete supplier image', [
                    'supplier_id' => $id,
                    'error' => $ex->getMessage(),
                ]);
            }
        }

        $supplier->delete();

        activity('supplier')
            ->performedOn($supplier)
            ->causedBy(auth()->user())
            ->withProperties(['old' => $oldData])
            ->log('Deleted a Supplier record.');

        return redirect()->back()->with([
            'message' => 'Supplier deleted successfully.',
            'alert-type' => 'success',
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->back()->with([
            'message' => 'Supplier not found.',
            'alert-type' => 'error',
        ]);

    } catch (\Exception $e) {
        Log::error('Failed to delete supplier', [
            'supplier_id' => $id,
            'error' => $e->getMessage(),
        ]);

        return redirect()->back()->with([
            'message' => 'An error occurred while trying to delete the supplier.',
            'alert-type' => 'error',
        ]);
    }
}



    public function DetailsSupplier($id) {

        $supplier = Supplier::findOrFail($id);
        return view('Supplier.DetailsSupplier', compact('supplier'));

    }




    
}
