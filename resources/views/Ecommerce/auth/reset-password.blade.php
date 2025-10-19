@extends('Ecommerce.Layout.ecommerce')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-green-100 to-white relative overflow-hidden">
    <!-- Decorative shapes -->
    <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-blue-200 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse"></div>
    <div class="absolute inset-0 bg-[url('/images/pill-pattern.svg')] bg-repeat opacity-10"></div>

    <!-- Password Reset Card -->
    <div class="z-10 max-w-md w-full bg-white p-8 rounded-2xl shadow-2xl space-y-6">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Your Password</h2>
            <p class="text-gray-600 text-sm mb-4">Enter your new password below to reset your account password.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" autocomplete="username" required autofocus
                    class="appearance-none rounded-md block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    value="{{ old('email', $request->email) }}">
                @if ($errors->has('email'))
                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="appearance-none rounded-md block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                @if ($errors->has('password'))
                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                    class="appearance-none rounded-md block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                @if ($errors->has('password_confirmation'))
                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md shadow focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Reset Password
            </button>
            <p class="text-sm text-gray-600 text-center mt-4">
                <a href="{{ route('customer.login') }}" class="font-medium text-green-600 hover:text-green-500">Back to Sign In</a>
            </p>
        </form>
    </div>
</div>

@endsection
