<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    //

public function dailyReport(Request $request)
{
    $fromDate = $request->input('from_date') 
        ? \Carbon\Carbon::parse($request->input('from_date')) 
        : \Carbon\Carbon::today();
    $toDate = $request->input('to_date') 
        ? \Carbon\Carbon::parse($request->input('to_date')) 
        : \Carbon\Carbon::today();

    $sourceFilter = $request->input('source'); // POS / ECOM

    // Query all completed orders within date range
    $query = Order::whereBetween('order_date', [$fromDate, $toDate])
        ->where('order_status', 'complete')
        ->with(['orderDetails.product']); // include related product data


    if ($sourceFilter) {
        $query->where('order_source', $sourceFilter);
    }

    $orders = $query->get();

    // Totals
    $totalSales = $orders->sum('total');
    $totalOrders = $orders->count();
    $totalProductsSold = $orders->flatMap->orderDetails->sum('quantity');
    $totalDiscounts = $orders->sum('discount');
    $totalVAT = $orders->sum('vat');




    return view('Reports.DailyReports', compact(
        'orders',
        'totalSales',
        'totalOrders',
        'totalProductsSold',
        'totalDiscounts',
        'totalVAT',
        'fromDate',
        'toDate',
        'sourceFilter'
    ));
}









            public function weeklyReport(Request $request)
            {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();


            $sourceFilter = $request->input('source'); // expects 'POS' or 'ECOM'

            $query = Order::whereBetween('order_date', [$start, $end])
                ->where('order_status', 'complete');


            if ($sourceFilter) {
                $query->where('order_source', $sourceFilter);
            }

            $orders = $query->get();


            $totalSales = $query->sum('total');

            return view('Reports.WeeklyReports', compact('orders', 'totalSales','start', 'end'));


            }


        public function monthlyReport(Request $request)
        {
            $month = now()->month;
            $year = now()->year;


            $sourceFilter = $request->input('source'); // expects 'POS' or 'ECOM'

            $query = Order::whereMonth('order_date', $month)
                ->whereYear('order_date', $year)
                ->where('order_status', 'complete');


            if ($sourceFilter) {
                $query->where('order_source', $sourceFilter);
            }

            $orders = $query->get();

        $totalSales = $orders->sum('total');


        return view('Reports.MonthlyReports', compact('orders', 'totalSales', 'month', 'year'));
    }


            public function TopSelling(Request $request) {


                $sourceFilter = $request->input('source'); // expects 'POS' or 'ECOM'

                $query = DB::table('Orderdetails')
                ->join('inventories', 'Orderdetails.product_id', '=', 'inventories.id') // real product_id link
                ->join('products', 'inventories.product_id', '=', 'products.id')
                ->join('orders', 'Orderdetails.order_id', '=', 'orders.id')
                ->select('products.product_name', 

                DB::raw('SUM(Orderdetails.quantity) as total_qty'), 
                DB::raw('SUM(Orderdetails.total) as total_sales'))
        
                ->groupBy('products.product_name')
                ->orderByDesc('total_qty')
                ->limit(10);


            if ($sourceFilter) {
                $query->where('orders.order_source', $sourceFilter);
            }

            $topProducts = $query->get();

            return view('Reports.TopProducts', compact('topProducts'));

            }


}
