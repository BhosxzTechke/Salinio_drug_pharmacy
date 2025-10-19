<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlider;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    //


public function BrandShow($id)
{
    $brand = Brand::findOrFail($id);

    // get product IDs from the brand's products relationship
    $productIds = $brand->products()->pluck('id');

    // fetch inventory for those product IDs
        $inventory = Inventory::whereIn('product_id', $productIds)
        ->where('quantity', '>', 10)
        ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), 'selling_price')
        ->groupBy('product_id', 'selling_price')
        ->latest()
        ->paginate(12);



    return view('Ecommerce.BrandPage', compact('brand', 'inventory'));
}





}
