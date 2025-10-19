<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;


class SubCategoryController extends Controller
{
    //


    public function SubCategoryTable(){

        $SubCatData = Subcategory::latest()->get();
        return view('SubCategory.SubCategoryTable', compact('SubCatData'));
    }



    public function SubCategoryCreate(){
        
        $categories = Category::orderBy('category_name','ASC')->get();

        return view('SubCategory.CreateSubCategory', compact('categories'));

    }


public function SubCategoryStore(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'name' => 'required|unique:subcategories,name',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Please input Sub Category Name',
            'name.unique' => 'Sub Category Name already used',
            'category_id.required' => 'Please select a Category Name',
            'category_id.exists' => 'Selected Category does not exist',
        ]);

        // Insert into database
        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // Success notification
        $notification = [
            'message' => 'Sub Category inserted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('sub-category.list')->with($notification);
    } catch (\Exception $e) {
        // Log the actual error if needed
        \Log::error('SubCategoryStore Error: '.$e->getMessage());

        // Error notification
        $notification = [
            'message' => 'Something went wrong while inserting the Sub Category.',
            'alert-type' => 'error'
        ];

        return redirect()->back()->withInput()->with($notification);
    }
}


    public function EditSubCategory($id){
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::orderBy('category_name','ASC')->get();
        return view('SubCategory.EditSubCategory',compact('subcategory','categories'));
    }





public function SubCategoryUpdate(Request $request)
{
    $subcatId = $request->id;

    try {
        // Validate request
        $request->validate([
            'name' => 'required|unique:subcategories,name,' . $subcatId,
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Please input Sub Category Name',
            'name.unique' => 'Sub Category Name already used',
            'category_id.required' => 'Please select a Category Name',
            'category_id.exists' => 'Selected Category does not exist',
        ]);

        // Update subcategory
        $subcategory = Subcategory::findOrFail($subcatId);

        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // Success notification
        $notification = [
            'message' => 'Sub Category updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('sub-category.list')->with($notification);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // If subcategory not found
        return redirect()->back()->with([
            'message' => 'Sub Category not found.',
            'alert-type' => 'error'
        ]);
    } catch (\Exception $e) {
        // Log unexpected error
        \Log::error('SubCategoryUpdate Error: ' . $e->getMessage());

        return redirect()->back()->withInput()->with([
            'message' => 'Something went wrong while updating the Sub Category.',
            'alert-type' => 'error'
        ]);
    }
}



public function DeleteSubCategory($id)
{
    try {
        $subcategory = Subcategory::findOrFail($id);

        // Check if related products exist
        if ($subcategory->products()->count() > 0) {
            return redirect()->back()->with([
                'message' => 'Cannot delete Sub Category. It is used by existing products.',
                'alert-type' => 'error'
            ]);
        }

        $subcategory->delete();

        return redirect()->back()->with([
            'message' => 'Sub Category deleted successfully',
            'alert-type' => 'success'
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->back()->with([
            'message' => 'Sub Category not found.',
            'alert-type' => 'error'
        ]);
    } catch (\Exception $e) {
        \Log::error('DeleteSubCategory Error: ' . $e->getMessage());
        return redirect()->back()->with([
            'message' => 'An error occurred while deleting the Sub Category.',
            'alert-type' => 'error'
        ]);
    }
}


}
