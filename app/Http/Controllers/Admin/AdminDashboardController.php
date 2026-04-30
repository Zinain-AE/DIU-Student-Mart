<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
        ];
        
        $recent_products = Product::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_products'));
    }
}