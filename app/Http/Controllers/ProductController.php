<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    // Departments matching your SellerController for consistency
    private $departments = [
        "CSE","SWE","BBA","NFE","Pharmacy","Civil","EEE","Textile",
        "ITM","ICE","Real Estate","Innovation & Entrepreneurship",
        "English","Law","JMC","ESDM","Public Health","PESS",
        "CIS","Architecture","MCT","Agriculture","Genetic Engineering","THM"
    ];

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
            new Middleware('seller', only: ['create', 'store', 'edit', 'update', 'destroy']), 
        ];
    }

    /**
     * Public Product Feed
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department') && $request->department != 'All Departments') {
            $query->where('department', $request->department);
        }

        $products = $query->latest()->paginate(12);
        
        // Passing departments to view for the filter dropdown
        $departments = $this->departments;

        return view('products.index', compact('products', 'departments'));
    }

    public function create()
    {
        $departments = $this->departments;
        return view('products.create', compact('departments')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'department' => 'required|string',
            'pickup_point' => 'required|string',
            'description' => 'required|string|max:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048' 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'department' => $request->department,
            'pickup_point' => $request->pickup_point,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'stock' => $request->stock,
            'is_active' => true,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Product posted successfully!');
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        $departments = $this->departments; 

        return view('seller.products.edit', compact('product', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', 
            'department' => 'required|string',
            'pickup_point' => 'required|string',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->department = $request->department;
        $product->pickup_point = $request->pickup_point;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully!');
    }
}