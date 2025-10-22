<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style> /* small tweak for forms */
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
                <a href="{{ route('products.create') }}">Add Product</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('cart.index') }}">Cart ({{ session('cart.items', collect())->count() }})</a>
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
