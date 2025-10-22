@extends('layouts.app')

@section('content')
    <!-- Top border and page links from original mockup -->
    <div class="top-content-border"></div>

    <div class="page-links">
        <span>
            <!-- Breadcrumb logic -->
            <a href="{{ route('products.index') }}">All Categories</a> &gt; 
            @if($product->category)
                <a href="{{ route('products.index', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a> &gt;
            @endif
            {{ $product->name }}
        </span>
        <hr>
    </div>

    <!-- Product Detail Layout -->
    <div style="display: flex; flex-wrap: wrap; gap: 40px; margin-top: 20px;">
        
        <!-- Image Column -->
        <div style="flex: 1 1 400px; max-width: 500px;">
            <img src="{{ $product->image_url ?: 'https://placehold.co/500' }}" alt="{{ $product->name }}" 
                 onerror="this.src='https://placehold.co/500'; this.onerror=null;"
                 style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
        </div>

        <!-- Details Column -->
        <div style="flex: 1 1 500px;">
            <h1 class="main-category-title" style="margin-top: 0;">{{ $product->name }}</h1>
            
            <p style="font-size: 14px; color: #666; margin-top: -15px;">SKU: {{ $product->sku ?? 'N/A' }}</p>

            <p style="font-size: 28px; font-weight: 600; color: #222; margin: 20px 0;">
                ${{ number_format($product->price, 2) }}
            </p>

            <p style="font-size: 16px; line-height: 1.6; color: #333;">
                {{ $product->description ?? 'No description available.' }}
            </p>

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.store', $product) }}" method="POST" style="margin-top: 30px;">
                @csrf
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label for="quantity" style="font-weight: 600;">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" 
                           style="width: 80px; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                    
                    <button type="submit" style="padding: 12px 24px; background: #00579a; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600;">
                        Add to Cart
                    </button>
                </div>
            </form>
            
            <!-- Admin Actions (moved from index) -->
            <div class="actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <span style="font-size: 14px; color: #666; margin-right: 10px;">Admin:</span>
                <a href="{{ route('products.edit', $product) }}" style="padding: 6px 12px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; font-weight: 500;">
                    Edit
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="post" style="display:inline; margin-left: 8px;">
                    @csrf 
                    @method('delete')
                    <button type="submit" style="padding: 6px 12px; background: #fee; color: #c00; border-radius: 4px; border: 1px solid #fcc; cursor: pointer; font-weight: 500;">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
