<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Authenticatable
{
    use HasFactory , Notifiable;
    

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'image',
        'city',
        'password',
        'added_by_staff',
        'remember_token',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function sendPasswordResetNotification($token)
{
    $url = url(route('password.reset', [
        'token' => $token,
        'email' => $this->email,
    ], false));

    $this->notify(new CustomResetPassword($url));
}


        public function addresses()
        {
            return $this->hasMany(Address::class);
        }

        
        public function defaultAddress()
        {
            return $this->hasOne(Address::class)->where('is_default', true);
        }

}
