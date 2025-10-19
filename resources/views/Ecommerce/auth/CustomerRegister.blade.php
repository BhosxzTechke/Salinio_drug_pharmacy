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

  <!-- Registration Card -->
  <div class="z-10 max-w-md w-full space-y-8">
    <div class="text-center">
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Register for your pharmacy</h2>
      <p class="mt-2 text-sm text-gray-600">
        Create your account to manage medicines, stock, and sales easily
      </p>
    </div>

    <form id="RegisterForm" class="mt-8 space-y-6 bg-white p-8 rounded-xl shadow-2xl" action="{{ route('customer.register') }}" method="POST">
        @csrf


        <div class="rounded-md shadow-sm -space-y-px">
          <div class="form-group mb-4">
            <label for="name" class="sr-only">Name</label>
            <input id="name" name="name" type="text" autocomplete="name" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Full Name" value="{{ old('name') }}">
            <span id="name-error" class="text-red-500 text-xs mt-1 block"></span>
          </div>



          <div class="form-group mb-4">
            <label for="email" class="sr-only">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Email Address" value="{{ old('email') }}">
            <span id="email-error" class="text-red-500 text-xs mt-1 block"></span>
          </div>

          <div class="form-group mb-4">
            <label for="phone" class="sr-only">Phone</label>
            <input id="phone" name="phone" type="text" autocomplete="tel" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Phone Number" value="{{ old('phone') }}">
            <span id="phone-error" class="text-red-500 text-xs mt-1 block"></span>
          </div>

          <div class="form-group mb-4">
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Password">
            <span id="password-error" class="text-red-500 text-xs mt-1 block"></span>
          </div>

          <div class="form-group mb-4">
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
            placeholder="Confirm Password">
            <span id="password_confirmation-error" class="text-red-500 text-xs mt-1 block"></span>
          </div>
        </div>

        <div>
          <button type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Register
          </button>
        </div>
        <p class="text-sm text-gray-600 text-center">
          Already have an account? <a href="{{ route('customer.login') }}" class="font-medium text-green-600 hover:text-green-500">Sign In</a>
        </p>
    </form>
  </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->has('name'))
                document.getElementById('name-error').textContent = @json($errors->first('name'));
            @endif
            @if ($errors->has('email'))
                document.getElementById('email-error').textContent = @json($errors->first('email'));
            @endif
            @if ($errors->has('phone'))
                document.getElementById('phone-error').textContent = @json($errors->first('phone'));
            @endif
            @if ($errors->has('password'))
                document.getElementById('password-error').textContent = @json($errors->first('password'));
            @endif
            @if ($errors->has('password_confirmation'))
                document.getElementById('password_confirmation-error').textContent = @json($errors->first('password_confirmation'));
            @endif
        });
    </script>
@endif

<script type="text/javascript">
    $(document).ready(function () {
        $('#RegisterForm').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                name: "Please enter your name.",
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address."
                },
                phone: "Please enter your phone number.",
                password: {
                    required: "Please enter your password.",
                    minlength: "Password must be at least 6 characters."
                },
                password_confirmation: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                }
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