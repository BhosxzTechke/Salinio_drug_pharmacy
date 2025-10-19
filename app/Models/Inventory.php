<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\Supplier;


class Inventory extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id', 'batch_number', 'expiry_date', 'quantity', 'cost_price', 'selling_price','supplier_id','received_date'
    ];



    public function product() {

    return $this->belongsTo(Product::class, 'product_id', 'id');

    }


    public function supplier(){

    return $this->belongsTo(Supplier::class, 'supplier_id', 'id');


    }

    //// For counting in best seller
            
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'product_id'); // adjust column names if different
    }

    /////////////////// SUB CATEGORY RELATION /////////////////
    public function subcategory() {

    return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');

    }


}
