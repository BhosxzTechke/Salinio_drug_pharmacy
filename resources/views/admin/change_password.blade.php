@extends('admin_dashboard')
@section('admin')

<div class="card" style="margin-top: 16px">
            <div class="card-body">

                                        <h4 class="mb-3 header-title">Change Password</h4>


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




    <form method="POST" action="{{ route('password.change.store') }} ">
        @csrf


        <div class="mb-3">

            @if(count($errors))
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                        @endforeach

        @endif
            <label for="exampleInputEmail1" class="form-label">Old Password </label>
            <input type="password" name="oldpassword" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
        </div>


        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="newpassword" class="form-control" id="exampleInputPassword1" placeholder="">
        </div>


        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">New Password</label>
            <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword1" placeholder="">
        </div>

        
        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
    </form>
           </div>

     
</div>

@endsection