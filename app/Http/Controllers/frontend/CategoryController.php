<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{




    //
public function CategoryProduct(Request $request, $slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();

    $productIds = Product::where('category_id', $category->id)
        ->orWhere('subcategory_id', $category->id)
        ->pluck('id');



    // $inventoryQuery = Inventory::whereIn('product_id', $productIds)
    //     ->where('quantity', '>', 10)
    //     ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), 'selling_price')
    //     ->groupBy('product_id', 'selling_price');



        $today = now()->toDateString();


        $inventoryQuery = Inventory::whereIn('product_id', $productIds)
        ->where('quantity', '>', 0)
            ->where(function ($query) use ($today) {
                $query->whereNull('expiry_date') // allow items without expiry
                    ->orWhere('expiry_date', '>', $today); // only include not-expired
            })
            ->select(
                'product_id',
                'selling_price',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('MAX(created_at) as latest_created')
            )
            ->groupBy('product_id', 'selling_price');




    // Price range
    if ($request->filled('price_min')) {
        $inventoryQuery->where('selling_price', '>=', $request->price_min);
    }
    if ($request->filled('price_max')) {
        $inventoryQuery->where('selling_price', '<=', $request->price_max);
    }

// Prescription filter (Rx / OTC)
if ($request->filled('prescription_required')) {
    $productIds = Product::whereIn('id', $productIds)
        ->where('prescription_required', true)
        ->pluck('id');

    $inventoryQuery->whereIn('product_id', $productIds);
}



    // if ($request->has('otc')) {
    //     $productIds = Product::whereIn('id', $productIds)
    //         ->where('type', 'OTC')
    //         ->pluck('id');
    //     $inventoryQuery->whereIn('product_id', $productIds);
    // }



    // Category filter
    if ($request->filled('categories')) {
        $catProductIds = Product::whereIn('category_id', $request->categories)->pluck('id');
        $inventoryQuery->whereIn('product_id', $catProductIds);
    }

    // Brand filter
    if ($request->filled('brands')) {
        $brandProductIds = Product::whereIn('brand_id', $request->brands)->pluck('id');
        $inventoryQuery->whereIn('product_id', $brandProductIds);
    }

    // Health concern filter
    if ($request->filled('health_concerns')) {
        $healthProductIds = Product::whereIn('health_concern', $request->health_concerns)->pluck('id');
        $inventoryQuery->whereIn('product_id', $healthProductIds);
    }


    //     // Health concern filter
    // if ($request->filled('age_group')) {
    //     $age_group = Product::whereIn('age_group', $request->age_group)->pluck('id');
    //     $inventoryQuery->whereIn('product_id', $age_group);
    // }


        /*
    |--------------------------------------------------------------------------
    | AGE GROUP FILTER
    |--------------------------------------------------------------------------
    */
    if ($request->filled('age_group')) {
        $selectedAgeGroups = array_filter($request->input('age_group', [])); // remove empty "All"

        if (!empty($selectedAgeGroups)) {
            $inventoryQuery->whereHas('product', function ($q) use ($selectedAgeGroups) {
                $q->whereIn('age_group', $selectedAgeGroups);
            });
        }
    }

    /*
    |--------------------------------------------------------------------------
    | TARGET GENDER FILTER
    |--------------------------------------------------------------------------
    */
    if ($request->filled('target_gender')) {
        $selectedGenders = array_filter($request->input('target_gender', []));

        if (!empty($selectedGenders)) {
            $inventoryQuery->whereHas('product', function ($q) use ($selectedGenders) {
                $q->whereIn('target_gender', $selectedGenders);
            });
        }
    }





    $inventory = $inventoryQuery->latest()->paginate(12);

    $allCategories = Category::all();
    $brands = Brand::all();


    $healthConcerns = collect(['' => 'All'])->merge(
        Product::whereNotNull('health_concern')
            ->distinct()
            ->pluck('health_concern', 'health_concern')
    );

    $age_group = Product::whereNotNull('age_group')
        ->distinct()
        ->pluck('age_group', 'age_group');

    $target_gender = Product::whereNotNull('target_gender')
        ->distinct()
        ->pluck('target_gender', 'target_gender');







    if ($request->ajax()) {
        return response()->view('Ecommerce.Partials.product_grid', compact('inventory'))->render();
    }

    return view('Ecommerce.category_product', compact('category', 'inventory', 'allCategories', 'brands', 'healthConcerns', 'age_group', 'target_gender'));
}









}
