<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Auth user
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        
        return view('orders.index', compact('orders'));
    }

public function cancelOrder($id)
{
    // Order 
    $order = \App\Models\Order::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

    // Relationship 
    $order->items()->delete();
    
    // Order delete 
    $order->delete();

    return back()->with('success', '🗑️ Order has been cancelled and removed.');
} }