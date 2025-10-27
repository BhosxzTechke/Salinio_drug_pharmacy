<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandController extends Controller
{
    //
    public function BrandTable(){

    $brandData = Brand::latest()->get();
    return view('Brand.BrandTable',compact('brandData'));
    
}


    public function CreateBrand(){
        return view('Brand.CreateBrand');
    }


    
public function StoreBrand(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:100|unique:brands,name',
            'description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10248', // max 10MB
        ], [
            'name.required' => 'Please input brand name',
            'name.unique' => 'Brand name already used',
        ]);

        $save_url = null;

        if ($request->hasFile('image')) {
            $save_url = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'brands'] // optional folder
            )->getSecurePath();
        }

        Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $save_url,
        ]);

        $notification = [
            'message' => 'Brand inserted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('brand.list')->with($notification);

    } catch (\Exception $e) {
        $notification = [
            'message' => 'Something went wrong: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];

        return redirect()->back()->withInput()->with($notification);
    }
}




    public function EditBrand($id){ 
        
        
        $brand = Brand::findOrFail($id); 
            
    return view('Brand.EditBrand',compact('brand')); }






public function UpdateBrand(Request $request)
{
    try {
        $brand_id = $request->id;

        $request->validate([
            'name' => 'required|string|max:100|unique:brands,name,' . $brand_id,
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'image.max' => 'The image must not be more than 10MB.',
            'image.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',  
            'name.required' => 'Please input brand name',
            'name.unique' => 'Brand name already used',
        ]);

        $brand = Brand::findOrFail($brand_id);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image from Cloudinary if exists
            if ($brand->logo && str_contains($brand->logo, 'res.cloudinary.com')) {
                try {
                    $publicId = basename(parse_url($brand->logo, PHP_URL_PATH));
                    $publicId = pathinfo($publicId, PATHINFO_FILENAME);
                    Cloudinary::destroy('brands/' . $publicId);
                } catch (\Exception $e) {
                    \Log::error('Cloudinary delete failed: ' . $e->getMessage());
                }
            }

            // Upload new image
            $uploadedFileUrl = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'brands']
            )->getSecurePath();

            $data['logo'] = $uploadedFileUrl;
        }

        $brand->update($data);

        $notification = [
            'message' => 'Brand updated successfully' . ($request->hasFile('image') ? ' with image' : ' without image'),
            'alert-type' => 'success'
        ];

        return redirect()->route('brand.list')->with($notification);

    } catch (\Exception $e) {
        $notification = [
            'message' => 'Something went wrong: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];
        return redirect()->back()->withInput()->with($notification);
    }
}






 public function DeleteBrand($id)
{
    $brand = Brand::findOrFail($id);
    $old_image = $brand->logo;

    if ($brand->products()->count() > 0) {
        return redirect()->back()->with([
            'message' => 'Cannot delete: Brand has associated products',
            'alert-type' => 'error',
        ]);
    }

    if ($old_image && str_contains($old_image, 'res.cloudinary.com')) {
        try {
            $publicId = basename(parse_url($old_image, PHP_URL_PATH));
            $publicId = pathinfo($publicId, PATHINFO_FILENAME);
            Cloudinary::destroy('brands/' . $publicId);
        } catch (\Exception $e) {
            \Log::error('Cloudinary delete failed: ' . $e->getMessage());
        }
    }

    $brand->delete();

    $notification = [
        'message' => 'Brand Deleted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}
    

}
