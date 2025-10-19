<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;


/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory;

use HasFactory;

    protected $fillable = [
        'product_name',
        'product_code',
        'product_image',
        'category_id',
        'subcategory_id',
        'brand_id',
        'supplier_id',
        'description',
        'dosage_form',
        'target_gender',
        'age_group',
        'health_concern',
        'selling_price',
        'prescription_required',
        'is_best_seller',
        'is_new_arrival',
        'is_active',
        'has_expiration'
    ];

    
    public function Supplier() {

    return $this->belongsTo(Supplier::class, 'supplier_id', 'id');


    }


    public function Category() {

    return $this->belongsTo(Category::class, 'category_id', 'id');

    }


    /////////////////// SUB CATEGORY RELATION /////////////////
    public function subcategory() {

    return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');

    }

        
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'product_id'); // adjust column names if different
    }


    

}
