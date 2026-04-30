<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        $pickupPoints = [
            "AB4", "8no Gate", "Auditorium", "Lake par", "Admission building", 
            "Khagan", "Dattapara", "AB1", "YKGS 1", "YKGS-2", "RASG-1", 
            "RASG-2", "GREEN GARDEN", "GATE no -2", "Dadur Tong"
        ];

        return view('checkout.index', compact('cart', 'pickupPoints'));
    }

    public function process(Request $request)
    {
        // 1. Validation Logic: 
        
        $request->validate([
            'pickup_point' => 'required',
            'phone' => 'nullable|string', // Optional column validation
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            // 2. Order Create Logic:
            
            $order = Order::create([
                'user_id'      => Auth::id(),
                'total_amount' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)),
                'status'       => 'pending',
                'pickup_point' => $request->pickup_point, 
                'note'         => $request->note ?? 'No special instructions',
                'phone'        => $request->phone ?? Auth::user()->phone,
            ]);

            // 3. Items Loop:
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            // 4. Redirection:
            // route name 'orders.index'
            return redirect()->route('orders.index')->with('success', '✅ Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollback();
            // Error 
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}