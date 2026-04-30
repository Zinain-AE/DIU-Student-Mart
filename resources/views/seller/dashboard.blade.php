@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-black text-blue-900 tracking-tight uppercase italic">
                    Seller <span class="text-orange-600">Central</span>
                </h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-10 h-1 bg-blue-900 rounded-full"></span>
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Manage your campus listings</p>
                </div>
            </div>
            
            <a href="{{ route('seller.products.create') }}" class="group bg-blue-900 text-white px-8 py-4 rounded-2xl font-black shadow-2xl hover:bg-orange-600 transition-all transform hover:-translate-y-1 flex items-center gap-3 uppercase text-xs tracking-widest">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i> 
                Add New Item
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- Active Listings Card --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-rocket"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Active Now</p>
                        <h2 class="text-3xl font-black text-blue-900">{{ $activeProducts ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            
            {{-- Total Products Card --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Inventory</p>
                        <h2 class="text-3xl font-black text-blue-900">{{ $totalProducts ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            {{-- User Role Card --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Verified Status</p>
                        <h2 class="text-xl font-black text-orange-500 uppercase italic">
                            {{ auth()->user()->role ?? 'Student' }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Products Table Container --}}
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="font-black text-blue-900 text-xl uppercase tracking-tighter">Your Inventory</h3>
                <div class="flex items-center gap-2 bg-slate-50 px-5 py-2 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Live Updates</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <tr>
                            <th class="p-8">Product Information</th>
                            <th class="p-8">Price</th>
                            <th class="p-8">Status</th>
                            <th class="p-8 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($myProducts as $product)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/80 transition-all group">
                            <td class="p-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 shadow-inner border border-slate-200">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fa-solid fa-camera text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-black text-blue-900 text-base mb-1">{{ $product->name }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">{{ $product->department }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8">
                                <span class="text-lg font-black text-blue-900">৳{{ number_format($product->price) }}</span>
                            </td>
                            <td class="p-8">
                                @if($product->is_active ?? true)
                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-tighter border border-green-200">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Public
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-500 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-tighter border border-slate-200">
                                        <i class="fa-solid fa-eye-slash mr-1"></i> Hidden
                                    </span>
                                @endif
                            </td>
                            <td class="p-8 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('seller.products.edit', $product->id) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all transform hover:scale-110 shadow-sm" title="Edit Item">
                                        <i class="fa-solid fa-pen-nib text-sm"></i>
                                    </a>
                                    
                                    <form action="{{ route('seller.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Do you really want to remove this product from the marketplace?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all transform hover:scale-110 shadow-sm" title="Delete Item">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                        <i class="fa-solid fa-store-slash text-4xl text-slate-200"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-blue-900 uppercase">Your shop is empty</h3>
                                    <p class="text-slate-400 font-bold mt-2 mb-8">Ready to make some extra cash?</p>
                                    <a href="{{ route('seller.products.create') }}" class="bg-orange-500 text-white px-10 py-4 rounded-2xl font-black text-xs hover:bg-blue-900 transition-all shadow-2xl uppercase tracking-[0.2em]">
                                        List Your First Item
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection