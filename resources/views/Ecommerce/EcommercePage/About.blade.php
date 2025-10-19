@extends('Ecommerce.Layout.ecommerce')

@section('content')



<div class="min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-12"
     x-data="{ posts: [], loading: false, category: '{{ request('category') ?? '' }}' }"
     x-init="fetchPosts(category)">

    <div class="max-w-[1200px] mx-auto">

        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight">
                Health & Advice — Pharmacy Blog
            </h1>
            <p class="mt-2 text-gray-600">
                Trusted, easy-to-read articles to help you take better care of your health.
            </p>

            <!-- Category Tabs -->
            <nav class="mt-6 flex flex-wrap gap-2">
                <button @click="category = ''; fetchPosts('')"
                        :class="category === '' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-700 border-gray-200 hover:shadow-md'"
                        class="text-sm px-3 py-1 rounded-full border">
                    All
                </button>
                @foreach($categories as $category)
                    <button @click="category = '{{ $category->slug }}'; fetchPosts('{{ $category->slug }}')"
                            :class="category === '{{ $category->slug }}' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-700 border-gray-200 hover:shadow-md'"
                            class="text-sm px-3 py-1 rounded-full border">
                        {{ $category->name }}
                    </button>
                @endforeach
            </nav>
        </header>

        <!-- Blog Posts -->
        <main>
            <!-- Loading -->
            <div x-show="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="i in 6">
                    <div class="h-64 bg-gray-200 animate-pulse rounded-2xl"></div>
                </template>
            </div>

            

            <!-- Posts -->
            <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="post in posts" :key="post.id">
                    <article class="rounded-2xl overflow-hidden bg-white shadow-lg hover:scale-[1.02] transition-transform">
                        <div class="h-44 bg-gray-100">
                            <img :src="post.image_url" :alt="post.title" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5 flex flex-col">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                <span x-text="post.category.name"></span>
                                <span x-text="post.date"></span>
                            </div>
                            <h3 class="text-lg font-semibold leading-snug" x-text="post.title"></h3>
                            <p class="mt-2 text-gray-600 flex-1" x-text="post.excerpt"></p>
                            <div class="mt-4">
                                <a :href="post.url"
                                   class="inline-flex items-center gap-2 text-emerald-600 font-medium hover:underline">
                                    Read article →
                                </a>
                            </div>
                        </div>
                    </article>
                </template>
            </div>



        </main>
    </div>
</div>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function fetchPosts(category) {
        const root = document.querySelector('[x-data]');
        root.__x.$data.loading = true;
        fetch(`/api/posts?category=${category}`)
            .then(res => res.json())
            .then(data => {
                root.__x.$data.posts = data;
                root.__x.$data.loading = false;
            });
    }
</script>

@endsection