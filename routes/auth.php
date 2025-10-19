<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\frontend\AuthCustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/admin/login/SDprime', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login/SDprime', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->group(function () {

    // First-time password change
    Route::get('/password/change', [AdminController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/update', [AdminController::class, 'updateFirstTimeUser'])->name('password.updating');

    // Dashboard (protected by mustChangePassword)
    Route::middleware('mustChangePassword', 'guard.session')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});




// /*
// |--------------------------------------------------------------------------
// | Guest Routes
// |--------------------------------------------------------------------------
// */
// Route::middleware('guest')->group(function () {
//     // Registration
//     Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('register', [RegisteredUserController::class, 'store']);

//     // Login
//     Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
//     Route::post('login', [AuthenticatedSessionController::class, 'store']);
// });

// /*
// |--------------------------------------------------------------------------
// | Authenticated Routes
// |--------------------------------------------------------------------------
// */
// Route::middleware(['web', 'auth:web'])->group(function () {

//     // First-time password change
//     Route::get('/password/change', [AdminController::class, 'showChangeForm'])->name('password.change');
//     Route::post('/password/update', [AdminController::class, 'updateFirstTimeUser'])->name('password.updating');

//     /*
//     |--------------------------------------------------------------------------
//     | Dashboard Routes
//     |--------------------------------------------------------------------------
//     | Only accessible after password has been changed
//     */
//     Route::middleware('mustChangePassword')->group(function () {
//         Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     });
// });





//             // ---------------- ADMIN AUTH + DASHBOARD ----------------

//             // Admin dashboard (default Breeze users table)

// // Routes requiring auth
// Route::middleware(['web', 'auth:web'])->group(function () {

//     // Password change for first-time login
//     Route::get('/password/change', [AdminController::class, 'showChangeForm'])->name('password.change');
//     Route::post('/password/update', [AdminController::class, 'updateFirstTimeUser'])->name('password.updating');

//     // Dashboard
//     Route::middleware('mustChangePassword')->group(function() {
//         Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     });

// });





// Route::middleware('guest')->group(function () {
//     Route::get('register', [RegisteredUserController::class, 'create'])
//                 ->name('register');

//     Route::post('register', [RegisteredUserController::class, 'store']);

//     Route::get('login', [AuthenticatedSessionController::class, 'create'])
//                 ->name('login');

//     Route::post('login', [AuthenticatedSessionController::class, 'store']);

// });







Route::middleware('guest:customer')->group(function () {

    ///////////////////// FORGOT PASSWORD ///////////////////////

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

});






Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');


    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
