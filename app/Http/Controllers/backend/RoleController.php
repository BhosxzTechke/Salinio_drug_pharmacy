<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use Spatie\Permission\Models\Permission; // have a Permission model
use Spatie\Permission\Models\Role; // Import the Role model if needed
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //

    public function AllPermission()
    {
        // Fetch all permissions from the database
        $permissions = Permission::orderBy('group_name', 'asc')->get();



        // Return a view with the permissions data
        return view('pages.permissions.allPermissions', compact('permissions'));
    }


    public function AddPermission(){

        return view('pages.permissions.addPermission');

    } // End Method 


    public function StorePermission(Request $request){

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'group_name' => 'required|string|max:255',
        ]);

        // Create a new permission
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission created successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->route('all.permission')->with($notification);
    }



    public function EditPermission($id){

        // Find the permission by ID
        $permission = Permission::findOrFail($id);

        // Return a view with the permission data
        return view('pages.permissions.editPermission', compact('permission'));

    } // End Methods


    public function DeletePermission($id){

        // Find the permission by ID
        $permission = Permission::findOrFail($id);

        // Delete the permission
        $permission->delete();

        $notification = array(
            'message' => 'Permission deleted successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
           return redirect()->back()->with($notification);

    } // End Method





    public function UpdatePermission(Request $request, $id){

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'group_name' => 'required|string|max:255',
        ]);

        // Find the permission by ID
        $permission = Permission::findOrFail($id);

        // Update the permission
        $permission->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission updated successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->route('all.permission')->with($notification);
    }


    public function AllRoles()
    {
        // Fetch all roles from the database
        $roles = Role::all();

        // Return a view with the roles data
        return view('pages.roles.allRoles', compact('roles'));
    }


    // SHOW ADD ROLES FORM
    public function AddRoles()
    {
        // Return a view to add a new role
        return view('pages.roles.addRoles');
    } // End Method


    public function StoreRoles(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        // Create a new role
        $role = Role::create(['name' => $request->name]);

        // Assign permissions to the role if provided
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        $notification = array(
            'message' => 'Role created successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->route('all.roles')->with($notification);
    }


    public function EditRoles($id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Fetch all permissions for the role
        $permissions = Permission::all();

        // Return a view with the role and permissions data
        return view('pages.roles.editRoles', compact('role', 'permissions'));
    } // End Method


    

    
    public function UpdateRoles(Request $request)
    {

        $rolesId = $request->input('id');
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        // Find the role by ID
        $role = Role::findOrFail($rolesId);

        // Update the role name
        $role->name = $request->name;
        $role->save();

        // Sync permissions with the role if provided
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        $notification = array(
            'message' => 'Role updated successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->route('all.roles')->with($notification);
    } // End Method





    public function DeleteRoles($id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Delete the role
        $role->delete();

        $notification = array(
            'message' => 'Role deleted successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->back()->with($notification);
    } // End Method




    public function AddRolesPermission()
    {
        // Fetch all roles and permissions
        $roles = Role::all();
        $permissions = Permission::all();


        // Fetch permission groups like category, product, etc.
        $permissionGroups = User::getpermissionGroups();



        // Return a view to add roles and permissions
        return view('pages.roles.addRolesPermission', compact('roles', 'permissions', 'permissionGroups'));
    } // End Method



    

    public function StoreRolesPermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'array',
        ]);

        // Check if role already has permissions assigned
        $existing = DB::table('role_has_permissions')->where('role_id', $request->role_id)->exists();

        
        if ($existing) {
            $notification = [
                'message' => 'Role already has permissions assigned!',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $permission = $request->permission;
        $data = [];

        // Loop through each permission and create an array of data 
        foreach ($permission as $perm => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;
            DB::table('role_has_permissions')->insert($data);
        }

        $notification = [
            'message' => 'Role Permission created successfully!',
            'alert-type' => 'success'
        ];

        // Redirect back with a success message
        return redirect()->route('all.roles')->with($notification);
    }



        public function AllRolesPermission() {


            $roles = role::all();

            return view('pages.roles.allRolesPermission', compact('roles'));

        }



    public function EditRolesPermission($id)
    {


        $roles = Role::findorfail($id);

        $permissions = Permission::all();

        // Fetch permission groups like category, product, etc. with bygroup 
        $permissionGroups = User::getpermissionGroups();



        // Return a view to add roles and permissions
        return view('pages.roles.editRolesPermission', compact('roles', 'permissions', 'permissionGroups'));
    } // End Method




    public function UpdateRolesPermission(Request $Request, $id) {

            // permissions

        $role = Role::findorfail($id);
        $permissions = $Request->permission;     


        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        
          $notification = array(
            'message' => 'Role Permission Updated successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->route('all.roles.permission')->with($notification);



    }


    public function DeleteRolesPermission($id) {


        $role = Role::findorfail($id);
        if(!is_null($role)) {

            $role->delete();

        }

        $notification = array(
            'message' => 'Role Permission Deleted successfully!',
            'alert-type' => 'success'
        );

        // Redirect back with a success message
        return redirect()->back()->with($notification);
    }


}