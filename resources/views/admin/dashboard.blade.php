@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-100">
    {{-- Simple Admin Sidebar --}}
    <div class="w-64 bg-blue-900 text-white p-8 hidden md:block">
        <h2 class="text-2xl font-black italic mb-10 tracking-tighter">ADMIN <span class="text-orange-500">PRO</span></h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block font-bold text-orange-500">Overview</a>
            <a href="{{ route('admin.products') }}" class="block font-bold hover:text-orange-400 transition">Manage Products</a>
            <a href="{{ route('admin.users') }}" class="block font-bold hover:text-orange-400 transition">Manage Users</a>
            <a href="{{ route('home') }}" class="block font-bold hover:text-orange-400 transition border-t border-blue-800 pt-4">Back to Mart</a>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 p-8 md:p-12">
        <h1 class="text-4xl font-black text-blue-900 mb-8 uppercase italic">System <span class="text-orange-600">Overview</span></h1>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2rem] shadow-xl border-b-8 border-blue-900">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Students</p>
                <h3 class="text-5xl font-black text-blue-900">{{ $total_users }}</h3>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-xl border-b-8 border-orange-500">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Live Products</p>
                <h3 class="text-5xl font-black text-blue-900">{{ $total_products }}</h3>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-xl border-b-8 border-green-500">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Sellers</p>
                <h3 class="text-5xl font-black text-blue-900">{{ $total_sellers }}</h3>
            </div>
        </div>

        {{-- Recent Products Table --}}
        <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl overflow-hidden">
            <h4 class="text-xl font-black text-blue-900 mb-6 uppercase italic">Recent Listings</h4>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Product</th>
                        <th class="py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Seller</th>
                        <th class="py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Price</th>
                        <th class="py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recent_products as $product)
                    <tr>
                        <td class="py-4 font-bold text-blue-900 uppercase text-sm">{{ $product->name }}</td>
                        <td class="py-4 text-slate-500 font-medium text-sm">{{ $product->user->name }}</td>
                        <td class="py-4 font-black text-orange-600 italic">৳{{ number_format($product->price) }}</td>
                        <td class="py-4 text-right">
                            <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:underline text-xs font-black uppercase tracking-widest mr-4">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection