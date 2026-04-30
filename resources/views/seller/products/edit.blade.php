@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-blue-900 uppercase tracking-tighter">Edit <span class="text-orange-500">Listing</span></h1>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Update your product information</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-slate-100">
            {{-- Error Alerts --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                    <ul class="list-disc list-inside text-red-600 text-xs font-bold uppercase tracking-widest">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Product Name --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition" placeholder="e.g. Scientific Calculator">
                </div>

                {{-- Price & Stock --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Price (BDT)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition" placeholder="500">
                    </div>

                    {{-- Stock Field --}}
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Update Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition" placeholder="Ex: 5">
                    </div>
                </div>

                {{-- Department & Pickup Point --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Department</label>
                        <select name="department" required
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition cursor-pointer">
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ old('department', $product->department) == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Pickup Point</label>
                        <input type="text" name="pickup_point" value="{{ old('pickup_point', $product->pickup_point) }}" required
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition" placeholder="e.g. AB-4 Cafe">
                    </div>
                </div>

                {{-- Product Description --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Product Description</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/20 outline-none font-bold text-blue-900 transition resize-none" 
                              placeholder="Write details about your product...">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Update Image (Optional)</label>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-orange-500/5 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-orange-500 transition-colors"></div>
                        <input type="file" name="image" class="relative w-full px-6 py-10 opacity-0 cursor-pointer z-10">
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-300 mb-2 group-hover:text-orange-500 transition-colors"></i>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Click to upload new photo</span>
                        </div>
                    </div>
                    
                    @if($product->image)
                    <div class="mt-4 flex items-center gap-4 p-4 bg-blue-50 rounded-2xl border border-blue-100 w-fit">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                        <div>
                            <span class="block text-[8px] font-black text-blue-400 uppercase tracking-widest">Active Image</span>
                            <span class="text-[10px] font-bold text-blue-900 uppercase">Keep empty to retain this</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-blue-900 text-white py-4 rounded-2xl font-black shadow-xl hover:bg-orange-600 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-xs">
                        Update Product
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="flex-1 bg-slate-100 text-slate-500 text-center py-4 rounded-2xl font-black hover:bg-slate-200 transition uppercase tracking-widest text-xs flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection