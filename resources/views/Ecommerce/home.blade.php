@extends('Ecommerce.Layout.ecommerce')
@section('content')


<section class="bg-gray-50 pt-6">
  <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
    <div class="relative pb-4">

      <!-- Carousel -->
      <div id="carousel" class="relative w-full overflow-hidden rounded-xl shadow-lg">
        <div id="track" class="flex transition-transform duration-700 ease-in-out">
          @foreach ($HeroSlider as $index => $item)
          <div class="w-full flex-shrink-0 relative">
            <img
              src="{{ asset($item->image) }}"
              class="w-full h-56 sm:h-72 md:h-96 lg:h-[500px] object-cover"
              alt="slide image"
            />

            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
              <div class="text-white max-w-lg px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl md:text-4xl font-bold mb-3">Stay Healthy Without Breaking the Bank</h2>
                <p class="mb-4 text-sm md:text-base">Explore top pharmacy essentials and enjoy big savings on wellness products.</p>
              <a href="{{ $item->link }}" 
                      target="_blank" 
                      rel="noopener noreferrer"
                      class="px-4 py-2 bg-green-300 hover:bg-green-700 rounded-lg text-white text-sm md:text-base">
                        Learn more
          </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        

        <!-- Arrows -->
        <button id="prev" class="absolute left-4 top-1/2 -translate-y-1/2 btn btn-circle">❮</button>
        <button id="next" class="absolute right-4 top-1/2 -translate-y-1/2 btn btn-circle">❯</button>
      </div>

      <!-- Dots -->
      <div class="flex justify-center py-4 gap-2">
        @foreach ($HeroSlider as $index => $item)
          <button class="dot btn btn-xs" data-slide="{{ $index }}">{{ $index + 1 }}</button>
        @endforeach
      </div>
    </div>
  </div>
</section>




<section class="bg-gray-50 pt-10">
  <div class="max-w-6xl mx-auto px-4">
    <div class="bg-white shadow-sm rounded-xl overflow-hidden">
      <div class="p-6">
        <!-- Section title -->
        <h3 class="text-2xl font-semibold text-gray-800">Today’s For You!</h3>
        <p class="text-sm text-gray-600 mb-6">
          This will be the best pharmacy
        </p>

        <!-- Grid of products -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 justify-items-center">
          @foreach ($inventory as $inventories)
            <form method="POST" action="{{ url('/ecommerce/add') }}" class="w-full">
              @csrf
              <div class="bg-white w-full shadow-md hover:shadow-lg transition-shadow duration-200 rounded-xl overflow-hidden relative group">
                
                <!-- Product Image -->
                <figure class="relative">
                  <img
                    src="{{ asset($inventories->product->product_image) }}"
                    alt="{{ $inventories->product->product_name }}"
                    class="h-40 sm:h-48 w-full object-cover"
                  />

                  <input type="hidden" name="id" value="{{ $inventories->product_id }}">
                  <input type="hidden" name="name" value="{{ $inventories->product->product_name }}">
                  <input type="hidden" name="qty" value="1">
                  <input type="hidden" name="selling_price" value="{{ $inventories->product->selling_price }}">
                  <input type="hidden" name="product_image" value="{{ $inventories->product->product_image }}">

                  <!-- Price + Stock + Wishlist -->
                  <div class="absolute top-2 right-2 flex flex-col items-end gap-1">
                    <span class="bg-white/90 text-gray-800 text-sm font-semibold px-2 py-1 rounded-lg shadow">
                      ₱{{ number_format($inventories->product->selling_price, 2) }}
                    </span>
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-lg">
                      {{ $inventories->product->stock }} in stock
                    </span>
                    <button type="button" class="p-2 bg-white/90 rounded-full shadow hover:bg-pink-100 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-5 h-5 text-pink-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 
                          1.126-4.312 2.733C11.597 4.876 9.935 3.75 8 
                          3.75 5.401 3.75 3.3 5.765 3.3 8.25c0 7.22 
                          8.7 11.25 8.7 11.25s8.7-4.03 8.7-11.25z" />
                      </svg>
                    </button>
                  </div>

                  <!-- Overlay for Prescription Required -->
                  @if($inventories->product->prescription_required)
                    <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                      <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full mb-2">
                        Prescription Required
                      </span>
                      <p class="text-white text-sm mb-3 px-3">
                        Available only in-store with a valid prescription.
                      </p>
                      <a href="{{ route('contact.show') }}"
                         class="bg-white text-gray-800 text-sm font-semibold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition">
                         Visit Our Store
                      </a>
                    </div>
                  @endif
                </figure>

                <!-- Card Content -->
                <div class="p-3">
                  <h2 class="text-gray-800 text-base sm:text-lg font-semibold line-clamp-1">
                    {{ $inventories->product->product_name }}
                  </h2>
                  <p class="text-gray-600 text-xs sm:text-sm line-clamp-2 mb-3">
                    {{ $inventories->product->description }}
                  </p>

                  @if(!$inventories->product->prescription_required)
                    <button type="submit" 
                            class="btn bg-violet-600 text-white hover:bg-violet-700 flex-1 w-full">
                      Add to Cart
                    </button>
                  @else
                    <button type="button"
                            class="btn bg-gray-400 text-white cursor-not-allowed w-full">
                      In-Store Only
                    </button>
                  @endif
                </div>
              </div>
            </form>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>





<section class="bg-gray-50 pt-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="card bg-base-100 shadow-sm h-[250px] rounded-xl overflow-hidden relative">
      <!-- Background Image -->
      <figure class="h-full w-full">
        <img
          class="w-full h-full object-cover"
          src="{{ url('uploads/bgBanner5.jpg') }}"
          alt="Movie"
        />
      </figure>

      <!-- Rainbow Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-r from-red-400 via-yellow-400 via-green-400 via-blue-400 via-indigo-400 to-purple-500 opacity-60 mix-blend-overlay"></div>

      <!-- Centered Content -->
      <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-6">
        <h1 class="text-3xl font-bold drop-shadow-lg">Salinio Drug Pharmacy</h1>
        <p class="mt-2 text-lg max-w-xl drop-shadow-md">
Your trusted online pharmacy for safe, affordable, and quality medicines.
        </p>
      </div>
    </div>
  </div>
</section>








<!-- Recommendation / Best Sellers Section -->
<section class="bg-white py-12">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-xl font-bold mb-6 text-center">Best Sellers</h2>
    <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      
      @foreach($bestSellers as $inventories)
        <a href="{{ route('product.show', $inventories->product_id) }}" class="bg-gray-50 rounded-lg shadow overflow-hidden hover:shadow-md transition block">
          <img src="{{ asset($inventories->product->product_image) }}" alt="{{ $inventories->product->product_name }}" class="w-full h-32 object-cover">
          <div class="p-3">
            <h3 class="text-base font-semibold">{{ $inventories->product->product_name }}</h3>
            <p class="text-gray-600 text-xs mb-1">{{ $inventories->product->product_name }}</p>
            <span class="font-bold text-blue-600 text-sm">{{ $inventories->product->selling_price }}</span>
          </div>
        </a>
      @endforeach

    </div>
  </div>
</section>


            

    </div>
  </div>
</section>


<!-- Shop by Category Section -->
<section class="py-12 px-6 bg-white">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-8">Shop by Category</h2>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
     
          @foreach($categori as $category)

      <div
        class="card bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white shadow-md hover:shadow-2xl hover:scale-105 transition duration-300 border border-gray-700 cursor-pointer"
      >
        <div class="card-body flex flex-col items-center justify-center text-center py-10">
          

          <div
            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center mb-5 shadow-inner"
          >
            <a href="{{ route('category.show', $category->slug) }}">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-10 w-10 text-gray-300 opacity-90"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.5"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </a>
          </div>
          <h3 class="text-lg font-semibold tracking-wide text-gray-100">
            {{ $category->category_name ?? '' }}
          </h3>
        </div>

      </div>
                    @endforeach

    </div>

  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const track = document.getElementById("track");
  const slides = track.children;
  const total = slides.length;
  const dots = document.querySelectorAll(".dot");
  let current = 0;
  let auto;

  function goToSlide(index) {
    current = (index + total) % total;
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((dot, i) => dot.classList.toggle("btn-primary", i === current));
  }

  document.getElementById("prev").addEventListener("click", () => goToSlide(current - 1));
  document.getElementById("next").addEventListener("click", () => goToSlide(current + 1));
  dots.forEach((dot, i) => dot.addEventListener("click", () => goToSlide(i)));

  function startAuto() {
    stopAuto();
    auto = setInterval(() => goToSlide(current + 1), 5000); // auto-slide every 5s
  }
  function stopAuto() { clearInterval(auto); }

  // Pause auto-slide on hover
  track.parentElement.addEventListener("mouseenter", stopAuto);
  track.parentElement.addEventListener("mouseleave", startAuto);

  goToSlide(0);
  startAuto();
});
</script>



@endsection

