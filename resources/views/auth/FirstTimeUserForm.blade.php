{{-- <!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Change Password Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

		<!-- Bootstrap css -->
		<link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- App css -->
		<link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
		<!-- icons -->
		<link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- Head js -->
		<script src="{{ asset('backend/assets/js/head.js') }}"></script>

    </head>

    

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="{{ url('/') }}" class="logo logo-dark text-center" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                            <span class="logo-lg" style="font-size: 2rem; font-weight: bold; background: linear-gradient(90deg, #6b7280 0%, #b1233f 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent; letter-spacing: 2px;">
                                                SD-Prime-Opss
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                                </div>



<form method="POST" action="{{ route('password.updating') }}">
    @csrf
    
    
    {{-- Optional: show current email/username --}}
    <div class="mb-3">
    <p class="text-muted small">
        Your new password must contain at least:
        <ul class="mb-1">
            <li>8 characters</li>
            <li>One uppercase letter (A–Z)</li>
            <li>One lowercase letter (a–z)</li>
            <li>One number (0–9)</li>
            <li>One special character (@, $, !, %, *, #, ? or &)</li>
        </ul>
    </p>

    
    <div class="mb-3">
        <label class="form-label">Email/Name/Phone</label>
        <input class="form-control" type="text" value="{{ auth('web')->user()->email }}" disabled>
    </div>

    {{-- Current Password --}}
    <div class="mb-3">
        <label for="oldpassword" class="form-label">Current Password</label>
        <div class="input-group input-group-merge">
            <input type="password" id="oldpassword" name="oldpassword" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password" required>
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
        </div>
        @error('current_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- New Password --}}
    <div class="mb-3">
        <label for="newpassword" class="form-label">New Password</label>
        <div class="input-group input-group-merge">
            <input type="password" id="newpassword" name="newpassword" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password" required>
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
        </div>
        @error('new_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- Confirm New Password --}}
    <div class="mb-3">
        <label for="newpassword_confirmation" class="form-label">Confirm New Password</label>
        <div class="input-group input-group-merge">
            <input type="password" id="newpassword_confirmation" name="newpassword_confirmation" class="form-control" placeholder="Confirm new password" required>
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
        </div>
    </div>

    <div class="text-center d-grid">
        <button class="btn btn-primary" type="submit">Update Password</button>
    </div>
</form>


                             {{-- <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                                {{ __('Sign up') }}
                            </a>

                          </div> --}}

            

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->


                        <!-- end row -->

                        

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->



    
</html>
 --}}
