<div class="form-row">
    <label>Category</label>
    <select name="category_id" required>
        <option value="">Select category</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" @if(old('category_id', $product->category_id ?? '') == $c->id) selected @endif>{{ $c->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-row">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="form-row">
    <label>SKU</label>
    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
</div>

<div class="form-row">
    <label>Description</label>
    <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="form-row">
    <label>Price</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}">
</div>

<div class="form-row">
    <label>Image URL</label>
    <input type="text" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}">
</div>
