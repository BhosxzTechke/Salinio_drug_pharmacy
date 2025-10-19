<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Subcategory;
use App\Models\Supplier;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;



class ProductController extends Controller
{
    //

    public function ProductTable() {


            $productData = Product::latest()->get();
            return view('Product.AllProduct', compact('productData'));



    }



    
        public function FormDropdownProduct() {

            $cat = Category::latest()->get();
            $sup = Supplier::latest()->get();
            $brand = Brand::latest()->get();    
            $sub = Subcategory::latest()->get();

            
            return view('Product.AddProduct', compact('cat', 'sup', 'brand', 'sub'));



    }



public function StoreProduct(Request $request)
{
    try {
        $validated = $request->validate([
            'product_name'          => 'required|string|max:100',
            'category_id'           => 'required|integer|exists:categories,id',
            'subcategory_id'        => 'required|integer|exists:subcategories,id',
            'brand_id'              => 'required|integer|exists:brands,id',
            'description'           => 'required|string|min:10',
            'dosage_form'           => 'required|string|max:50',
            'target_gender'         => 'required|string', // adjust values as per your options
            'age_group'             => 'required|string|max:50',
            'health_concern'        => 'required|string|max:100',
            'selling_price'         => 'required|numeric|min:0',
            'prescription_required' => 'nullable|boolean',
            'product_image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
        ]);

        // Auto-generate product code
        $pcode = IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 8,
            'prefix' => 'PC'
        ]);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/product_image/' . $name_gen;

            Image::make($image)->resize(300, 300)->save(public_path($path));
        } else {
            return back()->withErrors(['product_image' => 'Product image is required']);
        }

        // Insert into database
        Product::insert([
            'product_name'          => $validated['product_name'],
            'product_code'          => $pcode,
            'product_image'         => $path,
            'category_id'           => $validated['category_id'],
            'subcategory_id'        => $validated['subcategory_id'],
            'brand_id'              => $validated['brand_id'],
            'description'           => $validated['description'],
            'has_expiration'        => $request->has('has_expiration'),
            'dosage_form'           => $validated['dosage_form'],
            'target_gender'         => $validated['target_gender'],
            'age_group'             => $validated['age_group'],
            'health_concern'        => $validated['health_concern'],
            'selling_price'         => $validated['selling_price'],
            'prescription_required' => $validated['prescription_required'] ?? 0,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        return redirect()->route('product.list')->with([
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        // Log error for debugging
        Log::error('Product Insert Error: ' . $e->getMessage());

        return back()->with([
            'message' => 'Something went wrong while inserting the product.',
            'alert-type' => 'error'
        ])->withInput();
    }
}





            public function getSubcategories($category_id)
                {
                    $subcategories = Subcategory::where('category_id', $category_id)->get();

                    return response()->json($subcategories);
                }


            public function EditProduct ($id)
            {
                $product = Product::findOrFail($id);
                $categories = Category::all();
                $brands = Brand::all();
                $suppliers = Supplier::all();
                $subcategories = Subcategory::where('category_id', $product->category_id)->get(); // only relevant subcategories

                return view('Product.EditProduct', compact('product', 'categories', 'brands', 'suppliers', 'subcategories'));
            }



public function DeleteProduct($id)
{
    try {
        $product = Product::findOrFail($id);
        $oldData = $product->toArray();

        $inventoryExists = \App\Models\Inventory::where('product_id', $id)->exists();

        if ($inventoryExists) {
            return redirect()->back()->with([
                'message' => 'Cannot delete: Product exists in inventory records.',
                'alert-type' => 'warning',
            ]);
        }

        $imagePath = public_path($product->product_image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete product
        $product->delete();

        activity()
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties(['old' => $oldData])
            ->log('Deleted a Product record.');

        return redirect()->back()->with([
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success',
        ]);

    } catch (\Exception $e) {
        Log::error('Product deletion failed: ' . $e->getMessage());

        return redirect()->back()->with([
            'message' => 'Something went wrong while deleting the product.',
            'alert-type' => 'error',
        ]);
    }
}


public function UpdateProduct(Request $request)
{
    try {
        $request->validate([
            'id'                    => 'required|exists:products,id',
            'product_name'          => 'required|string|max:100',
            'product_code'          => 'required|string|max:50',
            'category_id'           => 'required|integer|exists:categories,id',
            'subcategory_id'        => 'required|integer|exists:subcategories,id',
            'brand_id'              => 'required|integer|exists:brands,id',
            'description'           => 'required|string|min:10',
            'dosage_form'           => 'required|string|max:50',
            'target_gender'         => 'required|string',
            'age_group'             => 'required|string|max:50',
            'health_concern'        => 'required|string|max:100',
            'selling_price'         => 'required|numeric|min:0',
            'prescription_required' => 'nullable|boolean',
            'product_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $product = Product::findOrFail($request->input('id'));
        $oldData = $product->toArray();

        // Update data array
        $data = [
            'product_name'          => $request->input('product_name'),
            'product_code'          => $request->input('product_code'),
            'category_id'           => $request->input('category_id'),
            'subcategory_id'        => $request->input('subcategory_id'),
            'brand_id'              => $request->input('brand_id'),
            'description'           => $request->input('description'),
            'has_expiration'        => $request->has('has_expiration'),
            'dosage_form'           => $request->input('dosage_form'),
            'target_gender'         => $request->input('target_gender'),
            'age_group'             => $request->input('age_group'),
            'health_concern'        => $request->input('health_concern'),
            'selling_price'         => $request->input('selling_price'),
            'prescription_required' => $request->input('prescription_required') ?? 0,
            'updated_at'            => Carbon::now(),
        ];

        // Handle image update (if new image uploaded)
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'uploads/product_image/' . $name_gen;
            Image::make($image)->resize(300, 300)->save(public_path($save_url));

            $data['product_image'] = $save_url;
        }

        // Update product
        $product->update($data);

        // Log activity
        $newData = $product->fresh()->toArray();
        activity()
            ->performedOn($product)
            ->causedBy($request->user())
            ->withProperties([
                'old' => $oldData,
                'new' => $newData,
            ])
            ->log('Updated Product information.');

        return redirect()->route('product.list')->with([
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        // Log error
        Log::error('Product update failed: ' . $e->getMessage());

        return back()->with([
            'message' => 'Something went wrong while updating the product.',
            'alert-type' => 'error'
        ])->withInput();
    }
}


        
        public function BarcodeProduct($id){

            $product = Product::findOrFail($id);
            return view('Product.BarcodeProduct',compact('product'));

        }// End Method 










        //////////////////////////// IMPORT EXPORT EXCELLLLL /////////////////////////////////////


        public function ImportProduct() {

                return view('Product.ImportProduct');

        }


        // Export
        public function Export() 
    {
        return Excel::download(new ProductExport, 'Product.xlsx');
    }





    
            public function Import(Request $request)
            {
                try {
                    Excel::import(new ProductImport, $request->file('import'));

                    return back()->with([
                        'message' => 'Import Successful!',
                        'alert-type' => 'success'
                    ]);
                } catch (ExcelValidationException $e) {
                    $failures = $e->failures();

                    // You can pass failures or just show a generic message
                    return back()->with([
                        'message' => 'Some rows failed to import. Please check your Excel data.',
                        'alert-type' => 'error',
                        'failures' => $failures, // Optional: use this to show row-wise errors
                    ]);
                }
            }


}



