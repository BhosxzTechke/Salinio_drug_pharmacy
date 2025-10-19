<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Spatie\Permission\Models\Role; // Import the Role model if needed
use Spatie\Permission\Models\Permission; // have a Permission model
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;  
use App\Models\BusinessTitle;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Jobs\RunBackup;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    //

    public function dashboard()
    {
        return view('index');     


    }    // End Method
    



        public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
        Cart::store(Auth::id()); // save cart to DB
    }

    
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


            $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'info'
        );    


    return redirect()->route('logout.page'); // Goes to your custom logout page
  }



                // INTERACTIVE LOGOUT PAGE
    public function Logout()
            {
                
         $notification = array(
                        'message' => 'Admin Logout Successfully',
                        'alert-type' => 'success'
           );

             return view('admin.logout_page')->with($notification);

    }

    

    

    //     public function Login(Request $request): RedirectResponse
    //         {

    //             return redirect('/login');

    // }


    
            public function ViewProfile()
            {

                $id = Auth::User()->id;
                $profileData = user::find($id);
                return view('admin.profile_view',compact('profileData'));

    }



    

    

public function StoreProfile(Request $request)
{
    $user = Auth::user(); // Get the currently authenticated user

        $rules = [];
        $messages = [];

        if ($request->filled('name') && $request->name !== $user->name) {
            $rules['name'] = 'required';
            $messages['name.required'] = 'Name is required.';
        }

        if ($request->filled('email') && $request->email !== $user->email) {
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
            $messages['email.required'] = 'Email is required.';
            $messages['email.email'] = 'Please enter a valid email.';
            $messages['email.unique'] = 'Email is already taken.';
        }

        if ($request->filled('phone') && $request->phone !== $user->phone) {
            $rules['phone'] = 'required|numeric';
            $messages['phone.required'] = 'Phone number is required.';
            $messages['phone.numeric'] = 'Phone number must be a number.';
        }


    if ($request->hasFile('photo')) {
        $rules['photo'] = 'image|mimes:jpeg,png,jpg|max:2048';
        $messages['photo.image'] = 'Photo must be an image.';
        $messages['photo.mimes'] = 'Only jpeg, png, and jpg formats are allowed.';
        $messages['photo.max'] = 'Image size should not exceed 2MB.';
    }

    $request->validate($rules, $messages);

    // Update only changed fields
            if ($request->filled('name') && $request->name !== $user->name) {
                $user->name = $request->name;
            }

            if ($request->filled('email') && $request->email !== $user->email) {
                $user->email = $request->email;
            }

            if ($request->filled('phone') && $request->phone !== $user->phone) {
                $user->phone = $request->phone;
            }


    // Handle image update
    if ($request->hasFile('photo')) {
        // Delete old image if it exists
        if ($user->photo && file_exists(public_path('uploads/profile_image/' . $user->photo))) {
            unlink(public_path('uploads/profile_image/' . $user->photo));
        }
        

        $file = $request->file('photo');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('uploads/profile_image'), $filename);
        $user->photo = $filename;
    }

    $user->save(); // Save only changed fields

    $notification = [
        'message' => 'Profile updated successfully.',
        'alert-type' => 'success',
    ];

    return redirect()->back()->with($notification);
}












            public function ChangePassword()
            {

                return view('admin.change_password');


    }

            // change password


            public function UpdatePassword(Request $request){

            $request->validate([
                'oldpassword' => 'required',
                'newpassword' => 'required',
                'confirm_password' => 'required|same:newpassword',

            ]);

            $hashedPassword = Auth::user()->password;
            if (Hash::check($request->oldpassword,$hashedPassword )) {
                $users = User::find(Auth::id());
                $users->password = bcrypt($request->newpassword);
                $users->temp_password = $request->newpassword;
                $users->save();

                session()->flash('message','Password Updated Successfully');
                return redirect()->back();
            } else{
                session()->flash('message','Old password is not match');
                return redirect()->back();
            }

        }







            //////////////////////////////// ADMIN USER ACCOUNT //////////////////////////////



            public function AllAdmin(){

                $user = User::latest()->get();

                return view('AdminUser.allAdmin', compact('user'));

            }


            public function CreateAdmin(){

                $role = Role::all();

                return view('AdminUser.addAdmin', compact('role'));
            }
                

public function StoreAdmin(Request $request)
{
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'role' => 'required|string',
        ]);


    $superadminLimit = 2; // you can move this to config
    if ($request->role === 'superadmin') {
        $superadminCount = User::role('superadmin')->count();

        if ($superadminCount >= $superadminLimit) {
            return redirect()->back()
                ->withErrors(['role' => "Superadmin limit of {$superadminLimit} reached."])
                ->withInput();
        }
    }

    $randomPassword = Str::random(10);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->password = Hash::make($randomPassword);
    $user->temp_password = $randomPassword; // ⚠️ plain password (short-term)
    $user->must_change_password = true;
    $user->save();

    $user->assignRole($request->role);


    return redirect()->route('all.admin')
                        ->with('temp_password', $randomPassword)
                        ->with('success', 'Admin created successfully!');
}






    public function EditAdmin($id) {


        $user = User::findorfail($id);
        $role = Role::all();


        return view('AdminUser.editAdmin', compact('role','user'));


    }



public function UpdateAdmin(Request $request)
{
    try {
        $usersID = $request->input('id');

        // Validation
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usersID,
            'phone' => 'required|numeric|unique:users,phone,' . $usersID,
            'role' => 'required|string',
        ]);


               // Admin password verification if reset password
        if ($request->has('reset_password'))  {
            $request->validate([
                'admin_password' => 'required|string',
            ]);
        }


        // Admin password verification if reset password
        if ($request->has('reset_password') && $request->filled('admin_password')) {
            $request->validate([
                'admin_password' => 'required|string',
            ]);
        }

        $user = User::findOrFail($request->id);

        // Reset password logic
        if ($request->has('reset_password') && $request->filled('admin_password')) {
            $admin = Auth::guard('web')->user();

            if (!Hash::check($request->admin_password, $admin->password)) {
                return back()->with([
                    'message' => 'Incorrect admin password.',
                    'alert-type' => 'warning',
                ]);
            }

            $tempPassword = Str::random(10);
            $user->password = Hash::make($tempPassword);
            $user->must_change_password = 1;
            $user->temp_password = $tempPassword;
        }

        // Update user info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->syncRoles([$request->role]);
        $user->save();

        return redirect()->route('all.admin')->with([
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // If validation fails (e.g. duplicate email or phone)
        return back()->with([
            'message' => $e->validator->errors()->first(), // show first error message
            'alert-type' => 'error'
        ]);
    } catch (\Exception $e) {
        // Unexpected error
        \Log::error('User update failed: ' . $e->getMessage());
        return back()->with([
            'message' => 'Something went wrong. Please try again later.',
            'alert-type' => 'error'
        ]);
    }
}




        

                public function DeleteAdmin($id){

                $user = User::findOrFail($id);
                if (!is_null($user)) {
                    $user->delete();
                }

                $notification = array(
                    'message' => 'Admin User Deleted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification); 

            }// End Method





//    Customizing Business Name

    public function BusinessName(){

        $businessTitle = BusinessTitle::find(1);

        return view('BusinessTitle.business_title', compact('businessTitle'));

    }


    public function StoreBusinessName(Request $request){


        $businessTitle = $request->id;

        $request->validate([
            'business_name' => 'required|string|max:255',
        ]);


        BusinessTitle::findorfail($businessTitle)->update([
            'business_name' => $request->business_name,

        ]);
        
        $notification = array(
            'message' => 'Business Title Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }



    // all backup database

    public function BackupDatabase() {


        return view('backup.backup_database')->with('files',File::files(storage_path('app/POS-Ecommerce')));
    }


public function BackupNow()
{
    // Ensure directory exists
    if (!file_exists(storage_path('app\\POS-Ecommerce'))) {
        mkdir(storage_path('app\\POS-Ecommerce'), 0755, true);
    }

    // Dispatch job instead of running backup inline
    dispatch(new RunBackup());

    $notification = [
        'message' => 'Backup started in background. Check logs for progress.',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}


    //  Downlaod Specific Database
    public function DownloadDatabase($getFilename){

    $path = storage_path('app\\POS-Ecommerce/'.$getFilename);
    return response()->download($path);

}// End Method



    public function DeleteDatabase($getFilename){

    $path = storage_path('app\\POS-Ecommerce/'.$getFilename);

    if (file_exists($path)) {
            storage::delete('POS-Ecommerce/'.$getFilename);

            $notification = array(
                'message' => 'Database Deleted Successfully',
                'alert-type' => 'success'
            );  

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'No Database Found',
                'alert-type' => 'error'
            );  

            return redirect()->back()->with($notification);
        }




 }



        ///////////////////////         CHANGE PASSWORD IF FIRST TIME  /////////////////
    //    public function showChangeForm(){



    //                return view('auth.FirstTimeUserForm');

    // }


        /**
     * Update the user's password.
     */
                // public function updateFirstTimeUser(Request $request)
                // {
                //     $request->validate([
                //         'new_password' => 'required|string|min:8|confirmed',
                //     ]);

                //     $user = $request->user();

                //     $user->password = Hash::make($request->new_password);
                //     $user->temp_password = $request->new_password;
                //     $user->must_change_password = 0;
                //     $user->save();

                //     return redirect()->route('admin.dashboard')->with([
                //         'message' => 'Password updated successfully!',
                //         'alert-type' => 'success'
                //     ]);
                        // }


    public function showChangeForm()
    {
        return view('auth.password-change');
    }




public function updateFirstTimeUser(Request $request)
{
    $request->validate([
        'password' => [
            'required',
            'string',
            'confirmed',
            'min:8',
            // Must contain uppercase, lowercase, number, and special character
            'regex:/[A-Z]/',      // at least one uppercase
            'regex:/[a-z]/',      // at least one lowercase
            'regex:/[0-9]/',      // at least one number
            'regex:/[@$!%*#?&]/', // at least one special character
        ],
    ], [
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);

    /** @var User $user */
    $user = auth()->user();


        ///// if yung pass now is same as before in temp_column
    if ($request->password === $user->temp_password) {
        return back()->withErrors([
            'password' => 'New password cannot be the same as your temporary password.',
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->must_change_password = false;

    $user->temp_password = null;

    $user->save();

    // //  Optional: log the password change event
    // activity()
    //     ->causedBy($user)
    //     ->withProperties(['ip' => $request->ip()])
    //     ->log('User updated first-time password');

    return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully!');
}




 }