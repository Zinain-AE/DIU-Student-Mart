<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // Central Department List for consistency
    private $departments = [
        "CSE","SWE","BBA","NFE","Pharmacy","Civil","EEE","Textile",
        "ITM","ICE","Real Estate","Innovation & Entrepreneurship",
        "English","Law","JMC","ESDM","Public Health","PESS",
        "CIS","Architecture","MCT","Agriculture","Genetic Engineering","THM"
    ];

    /**
     * Seller dashboard
     */
    public function index() {
        $user = auth()->user();
        $totalProducts = Product::where('user_id', $user->id)->count();
        $activeProducts = Product::where('user_id', $user->id)->where('is_active', true)->count();
        
        $myProducts = Product::where('user_id', $user->id)
                             ->latest()
                             ->paginate(10);

        return view('seller.dashboard', compact('totalProducts', 'activeProducts', 'myProducts'));
    }

    /**
     * Orders page
     */
    public function orders()
    {
        $sellerId = auth()->id();
        $orders = Order::whereHas('items.product', function($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with(['items.product', 'user'])->latest()->get();

        return view('seller.orders', compact('orders'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $departments = $this->departments;
        return view('seller.products.create', compact('departments'));
    }

    /**
     * Store New Product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0', // ✅ Added
            'department'   => 'required|string',
            'pickup_point' => 'required|string',
            'description'  => 'required|string',
            'image'        => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->stock, // ✅ Added
            'department'   => $request->department,
            'pickup_point' => $request->pickup_point,
            'description'  => $request->description,
            'image'        => $imagePath,
            'is_active'    => true,
        ]);

        return redirect()->route('seller.dashboard')->with('success', '🔥 Product added!');
    }

    /**
     * Show Edit Form
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();
        
        $departments = $this->departments;
        return view('seller.products.edit', compact('product', 'departments'));
    }

    /**
     * Update Product Logic
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0', // ✅ Added Validation
            'department'   => 'required|string',
            'pickup_point' => 'required|string',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->stock, // ✅ Added to data array
            'department'   => $request->department,
            'pickup_point' => $request->pickup_point,
            'description'  => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.dashboard')->with('success', '✅ Product updated!');
    }

    /**
     * Delete logic
     */
    public function delete($id)
    {
        $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $hasOrders = OrderItem::where('product_id', $id)->exists();

        if (!$hasOrders) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return back()->with('success', '🗑️ Product permanently deleted!');
        }

        return back()->with('error', '🚫 Product has orders, cannot delete from DB.');
    }

    /**
     * Status Update Logic
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'delivered']);

        return redirect()->back()->with('success', '✅ Order marked as delivered!');
    }
}