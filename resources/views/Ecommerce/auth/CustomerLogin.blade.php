@extends('Ecommerce.Layout.ecommerce')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="min-h-screen relative bg-gradient-to-r from-green-200 via-blue-100 to-white flex items-center justify-center overflow-hidden">
  
  <!-- Full-screen decorative shapes -->
  <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
  <div class="absolute top-1/3 right-0 w-[500px] h-[500px] bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
  <div class="absolute bottom-0 left-1/4 w-[700px] h-[700px] bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>

  <!-- Optional faint pill pattern -->
  <div class="absolute inset-0 bg-[url('/images/pill-pattern.svg')] bg-repeat opacity-10"></div>

  <!-- Login Card -->
  <div class="z-10 max-w-md w-full space-y-8">
    <div class="text-center">
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Sign in to your pharmacy</h2>
      <p class="mt-2 text-sm text-gray-600">
        Manage medicines, stock, and sales easily
      </p>
    </div>


    <form id="MyForm" class="mt-8 space-y-6 bg-white p-8 rounded-xl shadow-2xl" action="{{ route('customer.login.store') }}" method="POST">
        @csrf


        <div class="rounded-md shadow-sm -space-y-px">
          <div class="form-group mb-4">
            <label for="email" class="sr-only">Email / Name / Phone</label>
            <input id="login" name="login" type="login" autocomplete="login" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Enter your email, name or phone" value="{{ old('login') }}">
            <span id="login-error" class="text-red-500 text-xs mt-1 block"></span>

          </div>


          <div class="form-group mb-4">
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Password">
            <span id="password-error" class="text-red-500 text-xs mt-1 block"></span>

          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox"
            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
          </div>
          <div class="text-sm">
      <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">Forgot your password?</a>
          </div>
        </div>
        <div>

        <button type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          Sign In
        </button>
      </div>
      <p class="text-sm text-gray-600 text-center">
        Don't have an account? <a href="{{ route('customer.register.form') }}" class="font-medium text-green-600 hover:text-green-500">Register</a>
      </p>
    </form>


  </div>
</div>

@if ($errors->has('login'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('login-error').textContent = @json($errors->first('login'));
        });
    </script>
@endif

<script type="text/javascript">
    $(document).ready(function () {
        $('#MyForm').validate({
            rules: {
                login: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                login: "Please enter your email, name or phone.",
                password: "Please enter your password."
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-red-500 text-xs mt-1 block');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>



@endsection