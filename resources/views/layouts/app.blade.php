<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-row { margin-bottom: 8px; }
        input[type=text], input[type=number], textarea, select { width: 100%; padding: 6px; }
        .actions { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="grid-container">
        <header class="top-bar">
            <div class="logo"><span>ATK-Solihin</span></div>
            <div class="search-container">
                <form action="{{ route('products.index') }}" method="get">
                    <input type="search" name="q" placeholder="Search" value="{{ request('q') }}">
                    <button type="submit">🔍</button>
                </form>
            </div>
            <div class="header-buttons">
                {{-- Show admin links only to authenticated admin users --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('products.create') }}">Add Product</a>
                        <a href="{{ route('categories.index') }}">Categories</a>
                    @endif
                @endauth
                
                <a href="{{ route('cart.index') }}">Cart</a>
                
                {{-- Authentication links --}}
                @auth
                    <span style="color: #666; margin: 0 10px;">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #00579a; cursor: pointer; text-decoration: underline;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </header>

        <aside class="left-sidebar">
            <h3>Choose a category</h3>
            <hr>
            <ul>
                <li><a href="{{ route('products.index') }}">All Categories</a></li>
                @foreach(App\Models\Category::orderBy('name')->get() as $cat)
                    <li><a href="{{ route('products.index', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>
