<div class="text-sm text-white w-full">
    <div class="text-center font-medium py-2 bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31]">
        <p>Exclusive Price Drop! Hurry, <span class="underline underline-offset-2">Offer Ends Soon!</span></p>
    </div>
</div>

<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap">
<a href="{{ url('/') }}" 
   class="flex items-center gap-2 text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 hover:scale-105 transition-transform duration-200">
  <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
    <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>

  @php $BusinessTitle = App\Models\BusinessTitle::find(1); @endphp
  <span>{{ $BusinessTitle->business_name ?? 'Pharma' }}</span>
</a>


        <!-- Hamburger Menu (Mobile) -->
        <button id="nav-toggle" class="md:hidden flex items-center px-3 py-2 border rounded text-violet-500 border-violet-500 ml-auto">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
            </svg>
        </button>




{{--         

        <!-- Main Content -->
        <div id="nav-content" class="w-full md:w-auto flex-col md:flex-row flex md:flex items-center justify-between md:space-x-6 space-y-4 md:space-y-0 mt-4 md:mt-0 hidden md:flex">
            <!-- Search Bar with Category Filter -->
            <form action="" method="GET" class="flex items-center space-x-2 w-full md:w-auto">
                <div class="relative">
                    <select name="category" class="border rounded-l-lg px-1 py-2 focus:outline-none appearance-none pr-8">
                        <option value="">All Categories</option>
                        <option value="cologne">Cologne</option>
                        <option value="parent">Parent</option>
                        <option value="item3">Item 3</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>
                <input
                    type="text"
                    name="query"
                    placeholder="Search products..."
                    class="border-t border-b border-r px-3 py-2 rounded-r-lg focus:outline-none"
                >
                <button type="submit" class="ml-2 px-4 py-2 bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31] text-white rounded-lg hover:bg-violet-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    Search
                </button>
            </form> --}}


                        

              @php $ItemCart = Cart::instance('ecommerce')->content();     @endphp

{{-- 
            <!-- Cart and Wishlist Icons -->
            <div class="relative inline-block text-left">


            </div> --}}






<!-- Customer Navigation -->
<div class="w-full md:w-auto flex justify-center md:justify-end">


            <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                           @foreach ($ItemCart as $item)

                            <span class="badge badge-sm indicator-item bg-violet-500 text-white">{{ $ItemCart->count() }}</span>
                        </div>
                    </div>
                    


                  
                    <div tabindex="0" class="card card-compact dropdown-content bg-base-100 z-50 mt-3 w-52 shadow">
                        <div class="card-body relative z-50">


                            <span class="text-lg font-bold">{{ $ItemCart->count() }} Items</span>
                            
                            <span class="text-info">Subtotal: {{ $item->subtotal }}</span>

                            <div class="card-actions">
                                <a href="{{ route('cart.show') }}" class="btn btn-primary btn-block">View cart</a>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="dropdown dropdown-end mr-6">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0l1.318 1.318 1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                            <span class="badge badge-sm indicator-item bg-red-500 text-white">3</span>
                        </div>
                    </div>
                    <div tabindex="0" class="card card-compact dropdown-content bg-base-100 z-50 mt-3 w-52 shadow">
                        <div class="card-body">
                            <span class="text-lg font-bold">3 Wishlist</span>
                            <span class="text-info">Saved Items</span>

                            <div class="card-actions">
                                <a href="{{ route('wishlist.show') }}" class="btn btn-secondary btn-block">View wishlist</a>
                            </div>
                        </div>
                    </div>
                </div>




            @guest('customer')
                <!-- Login Button for Guests -->
                <a href="{{ route('customer.login') }}" class="px-4 py-2 bg-gradient-to-r from-[#303034] via-[#353a41] to-[#292d31] text-white rounded-lg hover:bg-blue-700">
                    Login
                </a>
        @endguest

@auth('customer')


        <!-- Customer Avatar Dropdown -->
        <div class="relative inline-block text-left">
            <button type="button" class="flex items-center focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                <img src="{{ asset(Auth::guard('customer')->user()->image ?? 'uploads/noimage.png') }}" 
                     alt="Avatar" 
                     class="w-10 h-10 rounded-full border-2 border-gray-300">
            </button>


            <!-- Dropdown Menu -->
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        Profile
                    </a>
                    

                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            Logout
                        </button>
                    </form>


                        
                    </form>
                </div>
            </div>
        </div>

    @endauth

        <script>
            // Simple toggle dropdown
            const btn = document.getElementById('menu-button');
            const menu = document.getElementById('dropdown-menu');
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        </script>
</div>



        </div>
    </div>
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
    <div id="cat-container" class="overflow-hidden w-full px-8">
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
                <h4 class="font-semibold text-gray-600 mb-1 text-sm md:text-base">{{ $letter }}</h4>
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
