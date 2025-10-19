<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\delivery_item;

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class delivery extends Model
{
    use HasFactory;


     protected $guarded = [];


    public function purchaseOrder() {
    return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
  }


    public function delivery_items()
    {
        return $this->hasMany(delivery_item::class, 'delivery_id', 'id');
    }


}
