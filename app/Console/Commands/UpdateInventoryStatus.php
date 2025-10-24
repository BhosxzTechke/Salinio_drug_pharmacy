<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;
use Carbon\Carbon;


class UpdateInventoryStatus extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:update-status';
    protected $description = 'Automatically update expired and out-of-stock inventory statuses';
    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $expiredCount = Inventory::where('expiry_date', '<', $today)
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);

        $outOfStockCount = Inventory::where('quantity', '<=', 0)
            ->where('status', '!=', 'out_of_stock')
            ->update(['status' => 'out_of_stock']);

        $this->info("Updated $expiredCount expired and $outOfStockCount out-of-stock batches.");

        return 0;
    }

    
}
