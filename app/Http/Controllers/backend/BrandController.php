<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;


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
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
        ], [
            'name.required' => 'Please input brand name',
            'name.unique' => 'Brand name already used',
        ]);


        $brand_image = $request->file('image'); 
        $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
        $brand_image->move(public_path('uploads/brand_image/'), $name_gen);
        $save_url = 'uploads/brand_image/' . $name_gen;

        Brand::insert([
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Please input brand name',
            'name.unique' => 'Brand name already used',
        ]);

        $brand = Brand::findOrFail($brand_id);

        if ($request->hasFile('image')) {
            $brand_image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
            $brand_image->move(public_path('uploads/brand_image/'), $name_gen);
            $save_url = 'uploads/brand_image/' . $name_gen;

            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }

            $brand->update([
                'name' => $request->name,
                'description' => $request->description,
                'logo' => $save_url,
            ]);

            $notification = [
                'message' => 'Brand updated successfully with image',
                'alert-type' => 'success'
            ];
        } else {

            $brand->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $notification = [
                'message' => 'Brand updated successfully without image',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('brand.list')->with($notification);

    } catch (\Exception $e) {
        $notification = [
            'message' => 'Something went wrong: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];
        return redirect()->back()->withInput()->with($notification);
    }
}


    public function DeleteBrand($id){

        $brand = Brand::findOrFail($id);
        $old_image = $brand->logo;

        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method

    

}
