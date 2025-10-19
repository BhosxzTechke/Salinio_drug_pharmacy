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

    $inventoryQuery = Inventory::whereIn('product_id', $productIds)
        ->where('quantity', '>', 10)
        ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), 'selling_price')
        ->groupBy('product_id', 'selling_price');






    // Price range
    if ($request->filled('price_min')) {
        $inventoryQuery->where('selling_price', '>=', $request->price_min);
    }
    if ($request->filled('price_max')) {
        $inventoryQuery->where('selling_price', '<=', $request->price_max);
    }

    // Prescription filters (Rx / OTC)
    if ($request->has('prescription_required')) {
        $productIds = Product::whereIn('id', $productIds)
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


        // Health concern filter
    if ($request->filled('age_group')) {
        $age_group = Product::whereIn('age_group', $request->age_group)->pluck('id');
        $inventoryQuery->whereIn('product_id', $age_group);
    }



    // 4️⃣ Get paginated inventory
    $inventory = $inventoryQuery->latest()->paginate(12);

    // 5️⃣ Shared data for sidebar
    $allCategories = Category::all();
    $brands = Brand::all();
    $healthConcerns = collect(['' => 'All'])->merge(
        Product::whereNotNull('health_concern')
            ->distinct()
            ->pluck('health_concern', 'health_concern')
    );

    // 6️⃣ If AJAX request → return only the product grid partial
    if ($request->ajax()) {
        return response()->view('Ecommerce.Partials.product_grid', compact('inventory'))->render();
    }

    // 7️⃣ Otherwise → return full page
    return view('Ecommerce.category_product', compact('category', 'inventory', 'allCategories', 'brands', 'healthConcerns'));
}









}
