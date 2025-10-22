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
            $cart[$productId]['quantity'] = (int)$request->input('quantity', 1);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
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

    /**
     * Handle checkout (requires authentication)
     */
    public function checkout(Request $request)
    {
        // This route is protected by 'auth' middleware
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // TODO: Implement your checkout logic here
        // - Create order
        // - Process payment
        // - Clear cart
        // - Send confirmation email
        
        // For now, just clear the cart and show success message
        session()->forget('cart');
        
        return redirect()->route('products.index')->with('success', 'Order placed successfully! (Checkout functionality to be implemented)');
    }
}