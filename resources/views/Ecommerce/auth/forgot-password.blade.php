@extends('Ecommerce.Layout.ecommerce')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="min-h-screen relative bg-gradient-to-r from-green-200 via-blue-100 to-white flex items-center justify-center overflow-hidden">
    <!-- Decorative shapes -->
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute top-1/3 right-0 w-[500px] h-[500px] bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 left-1/4 w-[700px] h-[700px] bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute inset-0 bg-[url('/images/pill-pattern.svg')] bg-repeat opacity-10"></div>

    <!-- Forgot Password Card -->
    <div class="z-10 max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Forgot your password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                No problem. Enter your email address and we'll send you a password reset link.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-8 space-y-6 bg-white p-8 rounded-xl shadow-2xl" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" autocomplete="email" required autofocus
                    class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    placeholder="Enter your email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Email Password Reset Link
                </button>

                
            </div>
            <p class="text-sm text-gray-600 text-center mt-4">
                <a href="{{ route('customer.login') }}" class="font-medium text-green-600 hover:text-green-500">Back to Sign In</a>
            </p>
        </form>
    </div>
</div>

@endsection
