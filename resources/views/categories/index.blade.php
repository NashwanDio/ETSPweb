@extends('layouts.app')

@section('content')
    {{-- Top border and breadcrumbs from cart style --}}
    <div class="top-content-border"></div>
    <div class="page-links">
        <span>
            <a href="{{ route('products.index') }}">All Categories</a> &gt; Manage Categories
        </span>
        <hr>
    </div>

    <div style="max-width: 900px; margin: 20px auto; padding: 0 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 2em; font-weight: bold; margin: 0;">Manage Categories</h1>
            <a href="{{ route('categories.create') }}" style="background: #00579a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 500;">
                Create New Category
            </a>
        </div>

        {{-- Session Success Message --}}
        @if (session('success'))
            <div style="padding: 15px; margin-bottom: 20px; border: 1px solid #d6e9c6; border-radius: 6px; color: #3c763d; background-color: #dff0d8;">
                {{ session('success') }}
            </div>
        @endif

        @if($categories->count() > 0)
            <div style="background: white; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1); border-radius: 8px; overflow: hidden;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    
                    {{-- Header Row --}}
                    <li style="display: grid; grid-template-columns: 1fr auto; padding: 10px 20px; font-weight: 600; color: #666; font-size: 14px; background-color: #f9f9f9; border-bottom: 1px solid #eee;">
                        <span>Category Name</span>
                        <span style="text-align: right;">Actions</span>
                    </li>
                    
                    {{-- Category Items Loop --}}
                    @foreach($categories as $category)
                        <li style="display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 15px; padding: 15px 20px; border-bottom: 1px solid #eee;">
                            
                            {{-- Category Name --}}
                            <p style="font-weight: 600; color: #333; margin: 0;">{{ $category->name }}</p>

                            {{-- Actions --}}
                            <div style="text-align: right;">
                                <a href="{{ route('categories.edit', $category) }}" style="color: #00579a; font-weight: 500; text-decoration: none; margin-right: 15px;">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="font-size: 14px; color: #c00; background: none; border: none; padding: 0; cursor: pointer; font-weight: 500;">Remove</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            {{-- Empty State Message --}}
            <div style="text-align: center; padding: 50px; background: #fafafa; border-radius: 8px;">
                <p style="font-size: 18px; color: #666;">No categories have been created yet.</p>
            </div>
        @endif
    </div>
@endsection