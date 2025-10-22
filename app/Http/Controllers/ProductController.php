<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * (This method is updated to group products by category)
     */
    public function index(Request $request)
    {
        // Get all categories for the sidebar/filter dropdown
        $categories = Category::orderBy('name')->get();
        $selectedCategory = null;

        // Start building the product query
        $productQuery = Product::query()->with('category'); // Eagerness load category

        // Filter by search query (using your advanced search)
        if ($request->filled('q')) {
            $q = $request->input('q');
            $productQuery->where(function ($qBuilder) use ($q) {
                $qBuilder->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        // Filter by selected category (from sidebar or filter dropdown)
        if ($request->filled('category')) {
            $selectedCategory = Category::find($request->input('category'));
            if ($selectedCategory) {
                $productQuery->where('category_id', $request->input('category'));
            }
        }

        // --- THIS IS THE KEY CHANGE ---
        // Instead of paginating, get ALL products that match the filters.
        $allProducts = $productQuery->orderBy('name')->get();

        // Now, group the results by the category's name.
        // This creates a collection where keys are category names
        // and values are arrays of products in that category.
        $groupedProducts = $allProducts->groupBy(function($product) {
            // Handle products with no category
            return $product->category->name ?? 'Uncategorized';
        });

        // Pass the grouped data to the view
        return view('products.index', [
            'groupedProducts' => $groupedProducts,
            'categories' => $categories, // For the filter dropdown
            'selectedCategory' => $selectedCategory, // For the title/breadcrumb
        ]);
    }

    /**
     * --- NEW METHOD ---
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Eager load the category for the breadcrumb
        $product->load('category');
        return view('products.show', compact('product'));
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image_url' => 'nullable|url',
        ]);

        Product::create($data);
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image_url' => 'nullable|url',
        ]);

        $product->update($data);
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}

