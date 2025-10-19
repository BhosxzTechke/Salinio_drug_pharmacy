@extends('Ecommerce.Layout.ecommerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- LEFT FILTER PANEL -->
    <aside class="md:col-span-1 space-y-6">
        <form id="filterForm" class="space-y-6">

            <!-- Price Range -->
            <div>
                <h2 class="font-semibold mb-2">Price</h2>
                <div class="flex space-x-2">
                    <input type="number" name="price_min" placeholder="Min"
                        value="{{ request('price_min') }}" class="w-1/2 border p-2 rounded">
                    <input type="number" name="price_max" placeholder="Max"
                        value="{{ request('price_max') }}" class="w-1/2 border p-2 rounded">
                </div>
            </div>

            <!-- Prescription -->
            <div>
                <h2 class="font-semibold mb-2">Prescription</h2>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="prescription_required" value="1"
                        {{ request('prescription_required') == 1 ? 'checked' : '' }}>
                    <span>Prescription Required</span>
                </label>

            </div>

            <!-- Categories -->
            <div>
                <h2 class="font-semibold mb-2">Categories</h2>
                <div class="max-h-40 overflow-y-auto space-y-1">
                    @foreach($allCategories as $cat)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                {{ collect(request('categories'))->contains($cat->id) ? 'checked' : '' }}>
                            <span>{{ $cat->category_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Brands -->
            <div>
                <h2 class="font-semibold mb-2">Brands</h2>
                <div class="max-h-40 overflow-y-auto space-y-1">
                    @foreach($brands as $brand)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                {{ collect(request('brands'))->contains($brand->id) ? 'checked' : '' }}>
                            <span>{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Health Concern -->
            <div>
                <h2 class="font-semibold mb-2">Health Concern</h2>
                <div class="max-h-40 overflow-y-auto space-y-1">
                    @if(!empty($healthConcerns))
                        @foreach($healthConcerns as $value => $label)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="health_concerns[]" value="{{ $value }}"
                                    {{ collect(request('health_concerns'))->contains($value) ? 'checked' : '' }}>
                                <span>{{ $label ?: 'All' }}</span>
                            </label>
                        @endforeach
                    @else
                        <p class="text-gray-400 text-sm">No health concerns available</p>
                    @endif
                </div>
            </div>



            <!-- Health Concern -->
            <div>
                <h2 class="font-semibold mb-2">Age group</h2>
                <div class="max-h-40 overflow-y-auto space-y-1">
                    @if(!empty($age_group))
                        @foreach($age_group as $value => $label)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="age_group[]" value="{{ $value }}"
                                    {{ collect(request('age_group'))->contains($value) ? 'checked' : '' }}>
                                    
                                <span>{{ $label ?: 'All' }}</span>
                            </label>
                        @endforeach
                    @else
                        <p class="text-gray-400 text-sm">No Age Group available</p>
                    @endif
                </div>
            </div>




            

            <!-- Apply Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Apply Filters
            </button>
        </form>
    </aside>

    <!-- PRODUCT GRID -->
    <main class="md:col-span-3">
        <h1 class="text-2xl font-bold mb-4">{{ $category->name }}</h1>

        <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($inventory as $inventories)
                <a href="{{ route('product.show', $inventories->product_id) }}"
                   class="border p-4 rounded shadow hover:shadow-lg transition block">
                    <img src="{{ asset($inventories->product->product_image) }}"
                         alt="{{ $inventories->product->product_name }}"
                         class="w-full h-40 object-cover rounded">
                    <h2 class="text-sm font-semibold mt-2 line-clamp-2">
                        {{ $inventories->product->product_name }}
                    </h2>
                    <p class="text-gray-600">₱{{ number_format($inventories->product->selling_price) }}</p>
                </a>
            @empty
                <p class="col-span-4 text-center text-gray-500">No products in this category.</p>
            @endforelse
        </div>

        <div id="paginationLinks" class="mt-6">
            {{ $inventory->links() }}
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('filterForm');
    const grid = document.getElementById('productGrid');
    const pagination = document.getElementById('paginationLinks');

    // Submit form without reloading
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    // Reusable AJAX filter loader
    function applyFilters(pageUrl = null) {
        const url = pageUrl || "{{ route('category.show', $category->slug) }}";
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        fetch(url + '?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newGrid = doc.querySelector('#productGrid');
            const newPagination = doc.querySelector('#paginationLinks');

            if (newGrid && newPagination) {
                grid.innerHTML = newGrid.innerHTML;
                pagination.innerHTML = newPagination.innerHTML;
            }
        })
        .catch(err => console.error('AJAX Filter Error:', err));
    }

    // Pagination click (AJAX)
    pagination.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;
        e.preventDefault();
        applyFilters(link.href);
    });
});
</script>
@endsection
