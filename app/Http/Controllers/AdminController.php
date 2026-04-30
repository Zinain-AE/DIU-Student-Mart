<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Overview
     */
    public function index()
    {
        $total_users = User::count();
        $total_products = Product::count();
        $total_sellers = User::where('role', 'seller')->count();
        
        // Choto ekta list dekhabo dashboard-e
        $recent_products = Product::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('total_users', 'total_products', 'total_sellers', 'recent_products'));
    }

    /**
     * List of all products for management
     */
    public function products()
    {
        $products = Product::with('user')->latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    /**
     * List of all registered users
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Delete a product (for moderation)
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product removed by Admin.');
    }

}