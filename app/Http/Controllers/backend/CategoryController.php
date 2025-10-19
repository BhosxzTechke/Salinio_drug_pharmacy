<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;




class CategoryController extends Controller
{
    //


    public function CategoryTable() {

        $CategoryData = Category::all();
        return view('Category.AllCategory', compact('CategoryData'));
        
    }



            public function CategoryStore(request $request) {

            try {
                
                $request->validate([
                    'category' => 'required|string|max:100|unique:categories,category_name',
                ], [
                    'category.required' => 'Please input a category name',
                    'category.unique' => 'This category already exists',
                ]);

                Category::create([
                    'category_name' =>  $request->input('category'),
                    'slug' => strtolower(str_replace(' ', '-', $request->input('category'))),
                ]);

                   //str_replace(' ', '-', ...)
                        // → Replaces spaces with dashes.
                        // "Pain Relief" → "Pain-Relief" and make lowercase.



                $notification = array(
                    'message' => 'Succesfully inserted new category',
                    'alert-type' => 'success',
                );


                return redirect()->route('category.list')->with($notification);
                
            } catch (\Exception $e) {
                $notification = [
                    'message' => 'Something went wrong: ' . $e->getMessage(),
                    'alert-type' => 'error',
                ];

                return redirect()->back()->withInput()->with($notification);
            }

            }


                public function CategoryDelete($id)
                {
                    try {
                        $category = Category::findOrFail($id);

                    ///   Optional: Check for relationships (e.g., products under this category)

                        if ($category->products()->count() > 0) {
                            return redirect()->back()->with([
                                'message' => 'Cannot delete: Category has associated products',
                                'alert-type' => 'error',
                            ]);
                        }

                        $category->delete();

                        $notification = [
                            'message' => 'Successfully deleted category',
                            'alert-type' => 'success',
                        ];

                        return redirect()->back()->with($notification);

                    } catch (\Exception $e) {

                        return redirect()->back()->with([
                            'message' => 'Error deleting category: ' . $e->getMessage(),
                            'alert-type' => 'error',
                        ]);
                    }
                }



            public function CategoryEdit($id) {

                $CatData = Category::findOrFail($id);


                return view('Category.EditCategory', compact('CatData'));

            }



        public function CategoryUpdate(request $request) {

            try {
                $catID = $request->input('id');

                $request->validate([
                    'category' => 'required|string|max:100|unique:categories,category_name,' . $catID,
                ], [
                    'category.required' => 'Please input a category name',
                    'category.unique' => 'This category name is already used',
                ]);

                Category::findOrFail($catID)->update([
                    'category_name' => $request->input('category'),
                    'slug' => Str::slug($request->input('category')),
                ]);

                $notification = [
                    'message' => 'Successfully updated category',
                    'alert-type' => 'success',
                ];

                return redirect()->route('category.list')->with($notification);

            } catch (\Exception $e) {
                $notification = [
                    
                    'message' => 'Something went wrong: ' . $e->getMessage(),
                    'alert-type' => 'error',
                ];
                return redirect()->back()->withInput()->with($notification);
            }
            }
}