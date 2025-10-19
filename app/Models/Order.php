<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\Address;
/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'shipping_address_id',
        'order_source',
        'order_date',
        'order_status',
        'total_products',
        'change_amount',
        'sub_total',
        'vat',
        'invoice_no',
        'total',
        'payment_status',
        'pay',
        'due',
        'created_by',
        'payment_method',
        'transaction_id',
        'discount',
        'created_at',
        'updated_at',
        'cancelled_at',
        'cancelled_by',
        'cancel_reason', 
        'cancelled_by_role',
        'vat_status',
        'shipped_at',
        'shipped_by',
        'completed_at', 
        'order_type',
        'reference_number',
            

    ];





    public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
}


    public function product()
        {
            return $this->belongsTo(Product::class);
        }



    public function orderDetails()
        {
            return $this->hasMany(OrderDetails::class, 'order_id');
        }



        //// HAD RELATIONSHIP WITH ADDRESS TABLE
     public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }


}