



<div class="text-sm text-black w-full">
    <div class="text-center font-medium py-2 bg-gradient-to-r from-green-200 via-green-100 to-green-200">
        <p>Exclusive Price Drop! Hurry, <span class="underline underline-offset-2">Offer Ends Soon!</span></p>
    </div>
</div>




<!-- Sticky Responsive Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl ml-8 px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" 
           class="flex items-center gap-2 text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 hover:scale-105 transition-transform duration-200">
            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <path d="M8 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            @php $BusinessTitle = App\Models\BusinessTitle::find(1); @endphp
            <span>{{ $BusinessTitle->business_name ?? 'Pharma' }}</span>
        </a>


        <!-- Hamburger Button -->
        <button id="nav-toggle" class="md:hidden flex items-center px-3 py-2 border rounded text-violet-600 border-violet-600">
            <svg class="fill-current h-5 w-5" viewBox="0 0 20 20">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
            </svg>
        </button>
    </div>



    <!-- if mobile Collapsible Menu -->
    <div id="nav-menu" class="hidden md:flex flex-col md:flex-row md:items-center md:justify-between max-w-7xl mx-auto px-4 py-3 transition-all duration-300 ease-in-out bg-white">
        <!-- Navigation Links -->
        <div class="flex flex-col md:flex-row gap-3 md:gap-6 text-center md:text-left">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-green-400 font-medium">Home</a>
            <a href="{{ url('/About/page') }}" class="text-gray-700 hover:text-green-400 first-letter:font-medium">About</a>
            <a href="{{ url('/Contact/page') }}" class="text-gray-700 hover:text-green-400 font-medium">Contact</a>
        </div>

        <!-- Right Section (Cart, Wishlist, Auth) -->
        <div class="flex flex-col md:flex-row md:items-center gap-3 mt-4 md:mt-0 justify-center">
            @php $ItemCart = Cart::instance('ecommerce')->content(); @endphp

            <!-- Cart -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="badge badge-sm indicator-item bg-violet-500 text-white">{{ $ItemCart->count() }}</span>
                    </div>
                </div>

                                    
  <div tabindex="0" class="card card-compact dropdown-content absolute left-0 top-full bg-base-100 z-[9999] mt-3 w-52 shadow">
                    <div class="card-body">
                        <span class="text-lg font-bold">{{ $ItemCart->count() }} Items</span>
                        @foreach ($ItemCart as $item)
                        <span class="text-info">Subtotal: {{ $item->subtotal }}</span>
                        @endforeach
                        <div class="card-actions">
                            <a href="{{ route('cart.show') }}" class="btn btn-primary btn-block">View cart</a>
                        </div>
                    </div>
                </div>

                
            </div>

            <!-- Wishlist -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 016.364 0l1.318 1.318 1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                        </svg>
                        <span class="badge badge-sm indicator-item bg-red-500 text-white">3</span>
                    </div>
                </div>

  <div tabindex="0" class="card card-compact dropdown-content absolute left-0 top-full bg-base-100 z-[9999] mt-3 w-52 shadow">
                    <div class="card-body">
                        <span class="text-lg font-bold">3 Wishlist</span>
                        <span class="text-info">Saved Items</span>
                        <div class="card-actions">
                            <a href="{{ route('wishlist.show') }}" class="btn btn-secondary btn-block">View wishlist</a>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Auth Buttons -->
            @guest('customer')
            <a href="{{ route('customer.login') }}" class="px-4 py-2 bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31] text-white rounded-lg hover:bg-blue-700">
                Login
            </a>
            @endguest

            @auth('customer')
            <div class="relative inline-block text-left">
                <button type="button" id="menu-button" class="flex items-center focus:outline-none">
                    <img src="{{ asset(Auth::guard('customer')->user()->image ?? 'uploads/noimage.png') }}" 
                         alt="Avatar" class="w-10 h-10 rounded-full border-2 border-gray-300">
                </button>
                <div id="dropdown-menu" class="hidden origin-top-left absolute left-0 mt-2 w-48 rounded-md shadow-lg z-50 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                        <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        const toggle = document.getElementById('nav-toggle');
        const menu = document.getElementById('nav-menu');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Avatar dropdown toggle
        const btn = document.getElementById('menu-button');
        const dropdown = document.getElementById('dropdown-menu');
        btn?.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });
    </script>
</nav>





        <!-- Navigation Links -->



        
        <!-- Category Bar -->
        <div class="bg-white text-gray-900 shadow-lg border-b">
            <div class="max-w-4xl mx-auto px-1 relative flex items-center">
                <!-- Left Arrow -->


     <button id="cat-left" 
            class="absolute left-0 z-10 bg-white shadow rounded-full p-2 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Category List -->
    <div id="cat-container" class="overflow-hidden w-full px-8 pt-5">
        <ul id="cat-list" class="flex space-x-3 transition-transform duration-300 ease-in-out">
            @foreach($categories as $category)
                <li class="min-w-[120px] text-center">
                    <a href="{{ route('category.show', $category->slug) }}" 
                       class="block px-3 py-2 rounded-lg hover:bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31] hover:text-white transition font-semibold text-black-600 text-sm truncate">
                        {{ $category->category_name ?? $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

            <!-- Right Arrow -->
            <button id="cat-right" 
                    class="absolute right-0 z-10 bg-white shadow rounded-full p-2 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>



            </div>



<div class="max-w-6xl mx-auto px-1 relative flex items-center justify-end">

  <!-- Brands Dropdown -->
  <div class="relative group ml-2">
    <!-- Dropdown Trigger -->
    <button class="px-4 py-2 bg-white rounded flex items-center gap-2 shadow-sm hover:text-green-700 transition-colors w-full md:w-auto">
      Brands
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    @php
        $brand = App\Models\Brand::all();
        // Group brands by first letter
        $groupedBrands = $brand->groupBy(function($brand) {
            return strtoupper(substr($brand->brand_name ?? $brand->name, 0, 1));
        });
    @endphp




    <!-- Dropdown Panel -->
    <div class="absolute top-full right-0 mt-2 w-[95%] sm:w-[80%] md:w-[400px] bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50 border border-gray-200
                left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0">



        <div class="p-4 max-h-[300px] overflow-y-auto">

    

    <h3 class="text-gray-700 font-semibold mb-3 text-base md:text-lg border-b pb-2">         
            Shop by Brand
            </h3>

            <!-- Grouped Brands -->
            @foreach($groupedBrands as $letter => $brands)
                <div class="mb-4">
                {{-- <h4 class="font-semibold text-gray-600 mb-1 text-sm md:text-base">{{ $letter }}</h4> --}}
                <ul class="space-y-1 text-sm md:text-base">
                    @foreach($brands as $brand)
                    <li>
                        <a href="{{ route('brand.show', $brand->id) }}"
                        class="block px-2 py-1 rounded hover:bg-green-50 transition">
                        {{ $brand->brand_name ?? $brand->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                </div>
            @endforeach
            </div>

        </div>
        </div>
    </div>

</div>




<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("cat-container");
        const list = document.getElementById("cat-list");
        const leftBtn = document.getElementById("cat-left");
        const rightBtn = document.getElementById("cat-right");
        const scrollAmount = 110; // smaller step to fit ~4 items

        function updateButtons() {
            const items = list.querySelectorAll("li").length;

            // hide arrows if categories <= 4
            if (items <= 4) {
                leftBtn.classList.add("hidden");
                rightBtn.classList.add("hidden");
                return;
            }

            // toggle arrows on scroll
            leftBtn.classList.toggle("hidden", container.scrollLeft <= 0);
            rightBtn.classList.toggle("hidden",
                container.scrollLeft + container.clientWidth >= list.scrollWidth
            );
        }

        leftBtn.addEventListener("click", () => {
            container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });

        rightBtn.addEventListener("click", () => {
            container.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });

        container.addEventListener("scroll", updateButtons);
        window.addEventListener("resize", updateButtons);

        updateButtons();
    });
</script>






<script>
    // Simple JS for toggling nav on mobile
    document.getElementById('nav-toggle').onclick = function() {
        var nav = document.getElementById('nav-content');
        nav.classList.toggle('hidden');
    };
</script>
