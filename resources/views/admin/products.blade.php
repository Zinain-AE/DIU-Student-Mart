@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black text-blue-900 uppercase italic tracking-tighter">Manage <span class="text-orange-500">Products</span></h1>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-black bg-blue-900 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-orange-500 transition uppercase tracking-widest">Back to Dashboard</a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Image</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Product Details</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Seller</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($products as $product)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 w-32">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-2xl shadow-md border-2 border-white">
                        </td>
                        <td class="p-6">
                            <p class="font-black text-blue-900 uppercase text-lg">{{ $product->name }}</p>
                            <p class="text-orange-600 font-bold italic">৳{{ number_format($product->price) }}</p>
                            <span class="text-[9px] bg-slate-100 px-2 py-1 rounded-md text-slate-400 font-black uppercase tracking-widest mt-1 inline-block">{{ $product->department }}</span>
                        </td>
                        <td class="p-6">
                            <p class="text-blue-900 font-bold uppercase text-sm">{{ $product->user->name }}</p>
                            <p class="text-slate-400 text-xs">{{ $product->user->email }}</p>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('products.show', $product->id) }}" class="p-3 bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-900 hover:text-white transition">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-6 border-t border-slate-50">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection