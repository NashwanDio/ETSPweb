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

    <!-- Filter Bar (from your CRUD version, slightly styled) -->
    <div style="margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
        <form method="get" action="{{ route('products.index') }}" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            
            <!-- Hidden input to preserve category selection if filtering by name -->
            @if($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory->id }}">
            @endif
            
            <div style="flex: 1 1 200px;">
                <label for="q" style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Search Products</label>
                <input type="search" name="q" id="q" placeholder="Search products..." value="{{ request('q') }}" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
            </div>
            
            <!-- Only show category filter if we're on the "All Categories" page -->
            @if(!$selectedCategory)
            <div style="flex: 1 1 200px;">
                <label for="category_filter" style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Filter by Category</label>
                <select name="category" id="category_filter" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="">All categories</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if(request('category') == $c->id) selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <button type="submit" style="padding: 8px 16px; background: #00579a; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Filter</button>
            </div>
        </form>
    </div>

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
                            <img src="{{ $product->image_url ?: 'https://placehold.co/150' }}" alt="{{ $product->name }}" 
                                 onerror="this.src='https://placehold.co/150'; this.onerror=null;"
                                 style="width: 100%; height: 150px; object-fit: cover; border-radius: 6px 6px 0 0;">
                            
                            <div style="padding: 12px;">
                                <p style="font-weight: 600; color: #333;">{{ $product->name }}</p>
                                
                                <p style="font-size:14px; color:#222; font-weight: 600; margin-top: 4px;">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                                
                                <div class="actions" style="margin-top: 12px; display: flex; gap: 8px; justify-content: flex-start; font-size: 12px;">
                                    <a href="{{ route('products.edit', $product) }}" style="padding: 4px 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; font-weight: 500;">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="post" style="display:inline">
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" style="padding: 4px 10px; background: #fee; color: #c00; border-radius: 4px; border: 1px solid #fcc; cursor: pointer; font-weight: 500;">Delete</button>
                                    </form>
                                </div>
                            </div>
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
