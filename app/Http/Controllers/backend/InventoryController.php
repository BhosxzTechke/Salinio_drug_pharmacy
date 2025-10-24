<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
public function Inventory(Request $request)
{

    $today = now()->toDateString();
    $status = $request->get('status', 'active'); // default to active

    $query = Inventory::with('product');

    // 🔍 Filter by status
    if ($status == 'expired') {
        $query->where('expiry_date', '<=', $today);
    } elseif ($status == 'out_of_stock') {
        $query->where('quantity', '<=', 0);
    } elseif ($status == 'active') {
        $query->where('quantity', '>', 0)
                ->where(function ($q) use ($today) {
                    $q->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>', $today);
                });
    }

    // Filter by product name
    if ($request->filled('product')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('product_name', 'like', '%'.$request->product.'%');
        });
    }


    $inventory = $query->orderBy('created_at', 'desc')->get();

    return view('Inventory.stocks', compact('inventory'));
}   


    public function updateStatus()
        {
            $today = now();

            $expiredCount = Inventory::where('expiry_date', '<', $today)
                ->where('status', '!=', 'expired')
                ->update(['status' => 'expired']);

            $outOfStockCount = Inventory::where('quantity', '<=', 0)
                ->where('status', '!=', 'out_of_stock')
                ->update(['status' => 'out_of_stock']);

            // his sends data to your toaster or alert system
            return back()->with('success', "Updated $expiredCount expired and $outOfStockCount out-of-stock batches.");
        }

}
