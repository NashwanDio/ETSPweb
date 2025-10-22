@extends('layouts.app')

@section('content')
    {{-- 
      This blade logic checks if a $product variable was passed from the controller.
      If it exists, $isEdit becomes true, and the form switches to "Edit" mode.
      For create.blade.php, $isEdit will be false.
    --}}
    @php
        $isEdit = isset($product);
    @endphp

    {{-- Top border and breadcrumbs from cart style --}}
    <div class="top-content-border"></div>
    <div class="page-links">
        <span>
            <a href="{{ route('products.index') }}">All Categories</a> &gt; 
            {{ $isEdit ? 'Edit' : 'Create' }} Product
        </span>
        <hr>
    </div>

    <div style="max-width: 700px; margin: 20px auto; padding: 0 20px;">
        <h1 style="font-size: 2em; font-weight: bold; margin-bottom: 20px;">
            {{ $isEdit ? 'Edit Product' : 'Create New Product' }}
        </h1>

        <div style="background: white; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1); border-radius: 8px; padding: 30px;">
            {{-- The form action and method are set dynamically --}}
            <form action="{{ $isEdit ? route('products.update', $product) : route('products.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PATCH') {{-- This is crucial for an update --}}
                @endif

                {{-- This includes all the form fields from the partial file --}}
                {{-- We pass the categories and the (optional) product variable --}}
                @include('products._form', [
                    'categories' => $categories, 
                    'product' => $product ?? null
                ])
                
                {{-- Action Buttons --}}
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; border-top: 1px solid #eee; padding-top: 20px; margin-top: 25px;">
                    <a href="{{ route('products.index') }}" style="color: #555; text-decoration: none; font-weight: 500;">Cancel</a>
                    <button type="submit" style="background: #28a745; color: white; padding: 10px 25px; text-decoration: none; border-radius: 6px; font-weight: 500; border: none; cursor: pointer; font-size: 16px;">
                        {{ $isEdit ? 'Save Changes' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
