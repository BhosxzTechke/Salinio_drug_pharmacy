<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;



/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
    

 */



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'must_change_password',
    //     'temp_password',
    //     'phone',
    //     'email',
    //     'password',
    //     'photo',
    // ];


        protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the roles associated with the user.
     */
    public static function getpermissionGroups() {

            $PermissionGroups = DB::table('permissions')
                ->select('group_name')
                ->groupBy('group_name')
                ->get();
                
            return $PermissionGroups;



    }




    // IF MATCH NG PERMISSION ID WHERE GROUP NAME THEN GET ALL 
    public static function getPermissionByGroup($groupName) {

        $PermissionGroups = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $groupName)
            ->get();


        return $PermissionGroups;



    }


        // parameters accesing this function and return if it is exist
        public static function roleHasPermissions($roles, $permissions){

        $hasPermission = true;
        foreach($permissions as $permission){
            if (!$roles->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
            return $hasPermission;
        }

        // if ung nakuha ko na manager id 2 is not match on the permission name that they relate pf table
        // has_permission_table then false

        // 1 = show.stock 
        // 2 = delete.product

    }// End Method 


}