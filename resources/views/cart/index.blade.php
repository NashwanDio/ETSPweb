@extends('layouts.app')

@section('content')
    <div class="top-content-border"></div>
    <div class="page-links">
        <span>
            <a href="{{ route('products.index') }}">All Categories</a> &gt; Shopping Cart
        </span>
        <hr>
    </div>

    <div style="max-width: 900px; margin: 20px auto; padding: 0 20px;">
        <h1 style="font-size: 2em; font-weight: bold; margin-bottom: 20px;">Shopping Cart</h1>

        {{-- Session Success Message --}}
        @if (session('success'))
            <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($cartItems) && $cartItems->count() > 0)
            <div style="background: white; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1); border-radius: 8px;">
                <ul style="list-style: none; padding: 0; margin: 0; divide-y: 1px solid #eee;">
                    {{-- Cart Header --}}
                    <li style="display: grid; grid-template-columns: 3fr 1fr 1fr 1fr; padding: 10px 20px; font-weight: 600; color: #666; font-size: 14px; border-bottom: 1px solid #eee;">
                        <span>Product</span>
                        <span style="text-align: right;">Price</span>
                        <span style="text-align: center;">Quantity</span>
                        <span style="text-align: right;">Subtotal</span>
                    </li>
                    
                    {{-- Cart Items Loop --}}
                    @foreach($cartItems as $item)
                        <li style="padding: 20px; display: grid; grid-template-columns: 3fr 1fr 1fr 1fr; align-items: center; gap: 15px;">
                            {{-- Product Info --}}
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="{{ $item->image_url ?: 'https://placehold.co/100' }}" alt="{{ $item->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                                <div>
                                    <p style="font-weight: 600;">{{ $item->name }}</p>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="font-size: 12px; color: #c00; background: none; border: none; padding: 0; cursor: pointer;">Remove</button>
                                    </form>
                                </div>
                            </div>
                            
                            {{-- Price --}}
                            <p style="text-align: right;">${{ number_format($item->price, 2) }}</p>

                            {{-- Quantity Form --}}
                            <div style="text-align: center;">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()" style="width: 60px; text-align: center; padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <p style="text-align: right; font-weight: bold;">${{ number_format($item->subtotal, 2) }}</p>
                        </li>
                    @endforeach
                </ul>

                {{-- Cart Footer --}}
                <div style="border-top: 1px solid #eee; padding: 20px; text-align: right;">
                    <div style="margin-bottom: 20px;">
                        <span style="font-size: 18px; color: #555;">Total:</span>
                        <span style="font-size: 22px; font-weight: bold; color: #111;">${{ number_format($totalPrice, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 20px;">
                        <a href="{{ route('products.index') }}" style="color: #00579a; text-decoration: none;">&larr; Continue Shopping</a>
                        
                        @auth
                            {{-- User is logged in, can proceed to checkout --}}
                            <form action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" style="padding: 12px 24px; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600;">
                                    Proceed to Checkout
                                </button>
                            </form>
                        @else
                            {{-- User is not logged in, prompt to login --}}
                            <a href="{{ route('login') }}" style="padding: 12px 24px; background: #28a745; color: white; border: none; border-radius: 6px; text-decoration: none; font-size: 16px; font-weight: 600; display: inline-block;">
                                Login to Checkout
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @else
            {{-- Empty Cart Message --}}
            <div style="text-align: center; padding: 50px; background: #fafafa; border-radius: 8px;">
                <p style="font-size: 18px; color: #666;">Your cart is empty.</p>
                <a href="{{ route('products.index') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #00579a; color: white; text-decoration: none; border-radius: 6px;">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection