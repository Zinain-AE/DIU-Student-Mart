<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login with your DIU email first to add products to your cart!');
        }
        
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $requestedQuantity = (int) $request->input('quantity', 1);
        
        // Stock limit validation
        if ($requestedQuantity > $product->stock) {
             return redirect()->back()->with('error', "You cannot add more than {$product->stock} units.");
        }

        $currentInCart = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $totalAfterAdd = $currentInCart + $requestedQuantity;

        if ($totalAfterAdd > $product->stock) {
            return redirect()->back()->with('error', "Total in cart cannot exceed stock limit ({$product->stock} units).");
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $totalAfterAdd;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $requestedQuantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        // Ensure id exists in request
        if($request->id && $request->has('quantity')) {
            $product = Product::findOrFail($request->id);
            $cart = session()->get('cart');
            $newQty = (int) $request->quantity;

            // Check if requested quantity is valid based on DB stock
            if ($newQty > $product->stock) {
                return redirect()->back()->with('error', "Limit Reached! Only {$product->stock} units available in stock.");
            }

            // If quantity is 0 or less, remove item
            if($newQty <= 0) {
                unset($cart[$request->id]);
            } else {
                $cart[$request->id]["quantity"] = $newQty;
            }
            
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }
        
        return redirect()->route('cart.index')->with('error', 'Something went wrong!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed!');
    }
}