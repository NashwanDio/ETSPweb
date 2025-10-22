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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Image Column -->
            <div class="aspect-square">
                <img src="{{ $product->image_url ?: 'https://placehold.co/500' }}" 
                     alt="{{ $product->name }}" 
                     onerror="this.src='https://placehold.co/500'; this.onerror=null;"
                     class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>

            <!-- Details Column -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    @if($product->sku)
                        <p class="text-sm text-gray-500 mt-1">SKU: {{ $product->sku }}</p>
                    @endif
                </div>

                <div class="border-t border-b border-gray-200 py-4">
                    <p class="text-3xl font-bold text-gray-900">
                        ${{ number_format($product->price, 2) }}
                    </p>
                </div>

                @if($product->description)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Admin Actions -->
                @auth
                    <div class="flex gap-4 py-4 border-t border-gray-200">
                        <a href="{{ route('products.edit', $product) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endauth

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.store', $product) }}" method="POST" class="mt-6">
                    @csrf
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mr-3">Quantity:</label>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   value="1" 
                                   min="1" 
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-20 sm:text-sm border-gray-300 rounded-md">
                    
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
