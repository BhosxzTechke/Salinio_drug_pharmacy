<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory;


    protected $guarded = [];
    
    public function advance() {
    return $this->belongsTo(AdvanceSalary::class, 'id', 'employee_id');
}    
            


}

