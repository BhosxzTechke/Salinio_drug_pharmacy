<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Pharmacy Shop')</title>

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

<link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

{{-- <!-- Bootstrap css -->
<link href="{{ asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" /> --}}


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <!-- Page-specific CSS -->

   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >



       @livewireStyles
       

</head>



<body class="bg-gray-100">

<!-- GLOBAL FULLSCREEN LOADER -->
<div id="global-loader" aria-hidden="true"
     class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black bg-opacity-60"
     style="display:none; pointer-events:auto;">
    <div class="flex flex-col items-center">
        <svg class="animate-spin h-14 w-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-white mt-4 text-lg font-semibold">Processing — please wait…</p>
    </div>
</div>

    <!-- Header -->
        {{--  FOR NAVIGATION --}}
    @include('Ecommerce.Layout.navigation')



    <!-- Page Content -->
<main class="w-screen px-0 py-0 m-0">
    @yield('content')
</main>


    @include('Ecommerce.Layout.footer')

    

            <!-- Custom JS -->
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/validation.js') }}"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>



@if(Session::has('message'))
<div id="toast"
    class="fixed top-5 right-2 max-w-md w-[90%] sm:w-auto bg-white text-gray-900 rounded-2xl shadow-2xl 
           border border-gray-200 p-4 flex items-center gap-3 animate-toast-in"  style="z-index: 9999;">


    <!-- Icon -->
    @if(Session::get('alert-type') === 'success')
        <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
    @elseif(Session::get('alert-type') === 'error')
        <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    @elseif(Session::get('alert-type') === 'warning')
        <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86L12 5 5.07 19z" />
            </svg>
        </div>
    @else
        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01" />
            </svg>
        </div>
    @endif

    <!-- Message -->
    <p class="text-sm sm:text-base font-medium flex-1">
        {{ Session::get('message') }}
    </p>

    <!-- Close button -->
    <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
        ✕
    </button>

    <!-- Progress bar -->
    <div id="toast-progress" class="absolute bottom-0 left-0 h-1 bg-current rounded-b-2xl opacity-50"
        style="width: 100%;"></div>
</div>





<script>
    setTimeout(() => {
        document.getElementById('toast').classList.add('hidden');
    }, 3000);
</script>

<style>
    @keyframes slide-in {
        0% { transform: translateX(100%); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
</style>
@endif



<script defer src="https://unpkg.com/alpinejs"></script>




<livewire:global-loader />

    @livewireScripts



</body>
</html>
