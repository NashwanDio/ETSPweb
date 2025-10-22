<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart with optimized product fetching.
     */
    public function index()
    {
        $cartSession = session()->get('cart', []);
        $productIds = array_keys($cartSession);

        // Fetch all products from the database in a single query
        $products = Product::whereIn('id', $productIds)->get();

        $cartItems = collect();
        $totalPrice = 0;

        foreach ($products as $product) {
            $quantity = $cartSession[$product->id]['quantity'];
            $subtotal = $product->price * $quantity;
            $totalPrice += $subtotal;

            // Add necessary info to a new collection
            $cartItems->push((object)[
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = (int)$request->input('quantity', 1);

        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                "quantity" => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $quantity = (int)$request->quantity;
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Cart updated successfully.');
            }
        }
        // If quantity is 0 or less, or item not found, it's an error or should be removed.
        return redirect()->back()->with('error', 'Invalid quantity.');
    }


    /**
     * Remove a product from the cart.
     */
    public function destroy($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart.');
    }
}