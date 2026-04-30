@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">
    {{-- Hero Section --}}
    <div class="bg-blue-900 py-16 mb-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4 italic tracking-tighter uppercase leading-none">
                DIU STUDENT <span class="text-orange-500">MARKETPLACE</span>
            </h1>
            <p class="text-blue-200 font-bold max-w-lg mx-auto text-sm md:text-base uppercase tracking-widest opacity-80">
                Find books, gadgets, and essentials from fellow campus mates
            </p>
            
            {{-- Unified Search Bar --}}
            <form action="{{ route('products.index') }}" method="GET" class="mt-10 max-w-3xl mx-auto group">
                <div class="flex flex-col md:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-[2.5rem] border border-white/20 shadow-2xl transition-all focus-within:bg-white/20">
                    @if(request('department'))
                        <input type="hidden" name="department" value="{{ request('department') }}">
                    @endif

                    <div class="flex-1 relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-orange-500"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="What are you looking for?" 
                               class="w-full pl-14 pr-6 py-5 bg-white rounded-[2rem] border-none focus:ring-0 outline-none font-bold text-blue-900 shadow-inner">
                    </div>
                    <button type="submit" class="bg-orange-500 text-white px-10 py-5 rounded-[2rem] font-black hover:bg-orange-600 transition transform hover:scale-[1.02] active:scale-95 shadow-lg flex items-center justify-center gap-2 uppercase tracking-widest">
                        <span>Search</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4">
        {{-- Section Header & Fixed Department Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 border-b border-slate-200 pb-10">
            <div>
                <h2 class="text-3xl font-black text-blue-900 tracking-tight uppercase leading-none mb-2">
                    Recent <span class="text-orange-600">Listings</span>
                </h2>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-1 bg-orange-500 rounded-full"></span>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Verified Campus Items</p>
                </div>
            </div>
            
            <div class="w-full md:w-80">
                <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Filter By Department</label>
                    <div class="relative group">
                        <select name="department" onchange="this.form.submit()" 
                                class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-slate-600 appearance-none cursor-pointer shadow-sm">
                            
                            <option value="">Select Department</option>
                            <option value="SWE" {{ request('department') == 'SWE' ? 'selected' : '' }} class="font-black text-blue-600">SWE (Software Engineering) ⭐</option>
                            
                            <optgroup label="Faculty of Science & IT">
                                <option value="CSE" {{ request('department') == 'CSE' ? 'selected' : '' }}>CSE</option>
                                <option value="CIS" {{ request('department') == 'CIS' ? 'selected' : '' }}>CIS</option>
                                <option value="MCT" {{ request('department') == 'MCT' ? 'selected' : '' }}>MCT</option>
                                <option value="ITM" {{ request('department') == 'ITM' ? 'selected' : '' }}>ITM</option>
                                <option value="ICE" {{ request('department') == 'ICE' ? 'selected' : '' }}>ICE</option>
                            </optgroup>

                            <optgroup label="Business & Entrepreneurship">
                                <option value="BBA" {{ request('department') == 'BBA' ? 'selected' : '' }}>BBA</option>
                                <option value="Innovation & Entrepreneurship" {{ request('department') == 'Innovation & Entrepreneurship' ? 'selected' : '' }}>Innovation & Entrepreneurship</option>
                                <option value="Real Estate" {{ request('department') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                                <option value="THM" {{ request('department') == 'THM' ? 'selected' : '' }}>THM</option>
                            </optgroup>

                            <optgroup label="Engineering">
                                <option value="Civil" {{ request('department') == 'Civil' ? 'selected' : '' }}>Civil</option>
                                <option value="EEE" {{ request('department') == 'EEE' ? 'selected' : '' }}>EEE</option>
                                <option value="Textile" {{ request('department') == 'Textile' ? 'selected' : '' }}>Textile</option>
                                <option value="Architecture" {{ request('department') == 'Architecture' ? 'selected' : '' }}>Architecture</option>
                            </optgroup>

                            <optgroup label="Allied Health Science">
                                <option value="Pharmacy" {{ request('department') == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                <option value="NFE" {{ request('department') == 'NFE' ? 'selected' : '' }}>NFE</option>
                                <option value="Public Health" {{ request('department') == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                                <option value="Genetic Engineering" {{ request('department') == 'Genetic Engineering' ? 'selected' : '' }}>Genetic Engineering</option>
                            </optgroup>

                            <optgroup label="Humanities & Social Science">
                                <option value="English" {{ request('department') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Law" {{ request('department') == 'Law' ? 'selected' : '' }}>Law</option>
                                <option value="JMC" {{ request('department') == 'JMC' ? 'selected' : '' }}>JMC</option>
                                <option value="ESDM" {{ request('department') == 'ESDM' ? 'selected' : '' }}>ESDM</option>
                                <option value="PESS" {{ request('department') == 'PESS' ? 'selected' : '' }}>PESS</option>
                            </optgroup>

                            <option value="Agriculture" {{ request('department') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                        </select>
                        {{-- Custom Arrow --}}
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all group border border-slate-100 flex flex-col h-full relative">
                {{-- NEW: Stock Status Badge (Top-Right) --}}
                <div class="absolute top-5 right-5 z-20">
                    @if($product->stock > 0)
                        <div class="bg-green-500/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-lg">
                            {{ $product->stock }} In Stock
                        </div>
                    @else
                        <div class="bg-red-600/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-lg">
                            Out of Stock
                        </div>
                    @endif
                </div>

                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out {{ $product->stock <= 0 ? 'grayscale opacity-50' : '' }}">
                    <div class="absolute top-5 left-5 bg-white/80 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/50">
                        <p class="text-[9px] font-black text-blue-900 uppercase tracking-wider">{{ $product->department }}</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <div class="mb-4">
                        <h3 class="font-black text-blue-900 text-lg mb-1 truncate group-hover:text-orange-600 transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-[10px] text-orange-500"></i>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">{{ $product->pickup_point }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="flex justify-between items-center mb-5">
                            <span class="text-xl font-black text-blue-900">৳{{ number_format($product->price) }}</span>
                            <a href="{{ route('products.show', $product->id) }}" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-blue-900 hover:bg-orange-500 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                        
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-900 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-orange-500 transition shadow-lg flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-slate-100 text-slate-400 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest cursor-not-allowed flex items-center justify-center gap-2 border border-slate-200">
                                <i class="fa-solid fa-ban"></i> Sold Out
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-24 text-center text-slate-400 font-bold uppercase tracking-widest">
                No products found.
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-20 mb-10">
            <div class="flex justify-center items-center">
                <div class="bg-white p-3 rounded-3xl shadow-sm border border-slate-100">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
            <p class="text-center text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mt-6">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
            </p>
        </div>
    </div>
</div>
@endsection