<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;


/**
 * @mixin IdeHelperAdvanceSalary
 */
class AdvanceSalary extends Model
{
    use HasFactory;


    protected $guarded = [];


     public function Employee() {


     return $this->belongsTo(Employee::class, 'employee_id', 'id');
}



}
