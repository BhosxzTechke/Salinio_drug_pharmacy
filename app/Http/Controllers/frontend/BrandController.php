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
    $today = now()->toDateString();


    // get product IDs from the brand's products relationship
    $productIds = $brand->products()->pluck('id');

    // fetch inventory for those product IDs
        $inventory = Inventory::whereIn('product_id', $productIds)
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
            ->groupBy('product_id', 'selling_price')
        ->latest()
        ->paginate(12);



            $inventoryQuery = Inventory::where('quantity', '>', 0);




    return view('Ecommerce.BrandPage', compact('brand', 'inventory'));
}





}
