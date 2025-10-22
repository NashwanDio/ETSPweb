@extends('layouts.app')

@section('content')
    <!-- Top border and page links from original mockup -->
    <div class="top-content-border"></div>

    <div class="page-links">
        <span>
            <!-- Breadcrumb logic -->
            @if($selectedCategory)
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">All Categories</a> &gt; {{ $selectedCategory->name }}
            @else
                All Categories
            @endif
        </span>
        <hr>
    </div>

    <!-- Main title -->
    <h1 class="main-category-title">
        {{ $selectedCategory->name ?? 'All Products' }}
    </h1>


    <!-- This is the main layout fix: Loop by category group -->
    <div class="category-groups-container">

        @forelse($groupedProducts as $categoryName => $productsInGroup)
            <div class="category-group">
                <!-- Use the category name as the group heading -->
                <h4>{{ $categoryName }}</h4>
                <div class="item-grid">
                    
                    @foreach($productsInGroup as $product)
                        <div class="item-card">
                            <!-- Use the product card layout from your CRUD version -->
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <img src="{{ $product->image_url ?: 'https://placehold.co/150' }}" alt="{{ $product->name }}" 
                                     onerror="this.src='https://placehold.co/150'; this.onerror=null;"
                                     style="width: 100%; height: auto; object-fit: cover; aspect-ratio: 1 / 1; border-radius: 0 0 0 0;">
                                
                                <div style="padding: 12px;">
                                    <p style="font-weight: 600; color: #333;">{{ $product->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div> <!-- .item-grid -->
            </div> <!-- .category-group -->
        @empty
            <div style="padding: 20px; text-align: center; color: #666;">
                <p>No products found matching your criteria.</p>
            </div>
        @endforelse

    </div> <!-- .category-groups-container -->

    <!-- 
    NOTE ON PAGINATION:
    Grouping all products like this (which matches your mockup) makes standard pagination difficult.
    The old version paginated a flat list. This version shows ALL filtered products, grouped.
    If you have thousands of products, you might need a more advanced solution
    (e.g., paginating the *groups* or using "load more" buttons).
    -->
@endsection
