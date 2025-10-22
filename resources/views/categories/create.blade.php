@extends('layouts.app')

@section('content')
    {{-- Determine if we are editing or creating for titles and actions --}}
    @php
        $isEdit = isset($category);
    @endphp

    {{-- Top border and breadcrumbs from cart style --}}
    <div class="top-content-border"></div>
    <div class="page-links">
        <span>
            <a href="{{ route('products.index') }}">All Categories</a> &gt; 
            <a href="{{ route('categories.index') }}">Manage Categories</a> &gt; 
            {{ $isEdit ? 'Edit' : 'Create' }}
        </span>
        <hr>
    </div>

    <div style="max-width: 700px; margin: 20px auto; padding: 0 20px;">
        <h1 style="font-size: 2em; font-weight: bold; margin-bottom: 20px;">
            {{ $isEdit ? 'Edit Category' : 'Create New Category' }}
        </h1>

        <div style="background: white; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1); border-radius: 8px; padding: 30px;">
            <form action="{{ $isEdit ? route('categories.update', $category) : route('categories.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PATCH')
                @endif

                {{-- Name Field --}}
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; font-weight: 600; margin-bottom: 5px;">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $isEdit ? $category->name : '') }}" required 
                           style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
                </div>

                {{-- Description Field --}}
                <div style="margin-bottom: 25px;">
                    <label for="description" style="display: block; font-weight: 600; margin-bottom: 5px;">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4"
                              style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px; resize: vertical;">{{ old('description', $isEdit ? $category->description : '') }}</textarea>
                </div>
                
                {{-- Action Buttons --}}
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="{{ route('categories.index') }}" style="color: #555; text-decoration: none; font-weight: 500;">Cancel</a>
                    <button type="submit" style="background: #28a745; color: white; padding: 10px 25px; text-decoration: none; border-radius: 6px; font-weight: 500; border: none; cursor: pointer; font-size: 16px;">
                        {{ $isEdit ? 'Save Changes' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection