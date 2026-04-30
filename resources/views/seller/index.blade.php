@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-blue-900 tracking-tighter uppercase">Seller <span class="text-orange-500">Dashboard</span></h1>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">Manage your campus listings</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-blue-900 text-white px-8 py-4 rounded-2xl font-black hover:bg-orange-600 transition shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> POST NEW ITEM
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Listings</p>
                <h3 class="text-4xl font-black text-blue-900">{{ $products->total() }}</h3>
            </div>
            {{-- Amra ekhane baki stats pore add korte parbo --}}
        </div>

        {{-- My Products Table --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Product</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Department</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Price</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 shrink-0 shadow-sm">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="font-black text-blue-900 truncate max-w-[200px]">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500 uppercase tracking-tighter">
                                {{ $product->department }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-black text-blue-900 text-lg">৳{{ number_format($product->price) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="w-10 h-10 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center hover:bg-blue-900 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <button class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center hover:bg-orange-600 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <p class="text-slate-400 font-bold uppercase tracking-widest">You haven't posted any items yet!</p>
                                <a href="{{ route('products.create') }}" class="text-orange-500 font-black border-b-2 border-orange-500 mt-2 inline-block">Post Your First Item</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection