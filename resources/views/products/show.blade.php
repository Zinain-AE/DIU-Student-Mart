@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4">
        {{-- Back Button --}}
        <div class="max-w-6xl mx-auto mb-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-900 font-black text-xs hover:text-orange-600 transition-colors group uppercase tracking-widest">
                <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Back to Marketplace
            </a>
        </div>

        {{-- Main Product Card --}}
        <div class="max-w-6xl mx-auto bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100">
            <div class="flex flex-col lg:flex-row">
                
                {{-- Image Section --}}
                <div class="lg:w-1/2 h-[350px] lg:h-[650px] bg-slate-200 relative">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    
                    <div class="absolute top-6 left-6 bg-blue-900/90 backdrop-blur-md text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-xl">
                        {{ $product->department }}
                    </div>

                    <div class="absolute bottom-6 left-6">
                        @if($product->stock > 0)
                            <div class="bg-green-500 text-white px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest shadow-xl flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                </span>
                                In Stock: {{ $product->stock }} Units
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info Section --}}
                <div class="lg:w-1/2 p-8 md:p-12 flex flex-col justify-between bg-white">
                    <div>
                        <span class="inline-block bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest mb-4 italic border border-orange-200">
                            {{ $product->department }} Student's Item
                        </span>
                        
                        <h1 class="text-3xl md:text-5xl font-black text-blue-900 mb-3 leading-tight tracking-tighter uppercase italic">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-4 mb-8">
                            <p class="text-4xl font-black text-orange-600 tracking-tighter">৳{{ number_format($product->price) }}</p>
                            @if($product->stock <= 5 && $product->stock > 0)
                                <span class="text-red-500 font-black text-[10px] uppercase tracking-tighter animate-bounce">🔥 Only {{ $product->stock }} left!</span>
                            @endif
                        </div>

                        <div class="mb-8">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] mb-3 ml-1">Item Description</p>
                            <div class="text-blue-900/80 text-sm font-bold leading-relaxed bg-slate-50/50 p-6 rounded-3xl border border-slate-100 italic shadow-inner">
                                {!! nl2br(e($product->description ?? 'No detailed description provided.')) !!}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                    <i class="fa-solid fa-location-dot text-sm"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Pickup</p>
                                    <p class="text-blue-900 font-bold text-xs truncate uppercase">{{ $product->pickup_point }}</p>
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-orange-500 shadow-sm shrink-0">
                                    <i class="fa-solid fa-user-graduate text-sm"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Seller</p>
                                    <p class="text-blue-900 font-bold text-xs truncate uppercase">{{ $product->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Section --}}
                    <div class="space-y-4">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Select Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                           class="w-full px-4 py-3 border border-slate-200 rounded-xl font-bold text-blue-900 focus:ring-2 focus:ring-orange-500 outline-none">
                                </div>

                                <button type="submit" class="w-full bg-orange-600 hover:bg-blue-900 text-white py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all shadow-xl shadow-orange-100 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                                    <i class="fa-solid fa-cart-plus text-base"></i> Add to Cart
                                </button>
                            </form>

                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://wa.me/{{ $product->user->phone ?? '' }}" target="_blank" class="bg-green-500 text-white text-center py-3.5 rounded-xl font-black shadow-lg hover:bg-green-600 transition flex items-center justify-center gap-2 uppercase text-[9px] tracking-widest">
                                    <i class="fa-brands fa-whatsapp text-base"></i> WhatsApp
                                </a>
                                <a href="mailto:{{ $product->user->email }}" class="bg-blue-900 text-white text-center py-3.5 rounded-xl font-black shadow-lg hover:bg-blue-800 transition flex items-center justify-center gap-2 uppercase text-[9px] tracking-widest">
                                    <i class="fa-solid fa-envelope text-base"></i> Email
                                </a>
                            </div>
                        @else
                            <button disabled class="w-full bg-slate-100 text-slate-400 py-4 rounded-2xl font-black uppercase tracking-widest text-xs cursor-not-allowed">
                                <i class="fa-solid fa-face-frown mr-2"></i> Sold Out
                            </button>
                        @endif

                        <div class="py-2.5 px-4 rounded-xl bg-orange-50/50 border border-orange-100/30">
                            <p class="text-center text-orange-600/90 text-[8px] font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                                <span>Meet in DIU campus areas only.Verify before making any payment</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Review Section --}}
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100 mb-10">
            <h2 class="text-2xl font-black text-blue-900 uppercase italic mb-6">Customer Reviews</h2>
            
            @auth
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    @csrf
                    {{-- Star Rating UI --}}
                    <div class="flex gap-1 mb-4" id="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="hidden peer" required>
                            <label for="star{{ $i }}" class="text-slate-300 text-2xl cursor-pointer peer-checked:text-orange-500 hover:text-orange-400">★</label>
                        @endfor
                    </div>

                    <textarea name="comment" required class="w-full p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Share your experience..."></textarea>
                    
                    <div class="flex items-center gap-4 mt-4">
                        <input type="file" name="image" class="text-xs text-slate-500">
                        <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-xl font-black text-xs uppercase hover:bg-orange-500 transition">Post Review</button>
                    </div>
                </form>
            @else
                <p class="text-slate-400 italic mb-4">Please <a href="{{ route('login') }}" class="text-blue-900 font-bold underline">login</a> to leave a review.</p>
            @endauth

            {{-- Reviews List --}}
            <div class="space-y-6">
                @forelse($product->reviews as $review)
                    <div class="flex gap-4 p-4 border-b border-slate-100">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <p class="font-black text-blue-900">{{ $review->user->name }}</p>
                                {{-- Displaying Stars --}}
                                <div class="text-orange-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-orange-500' : 'text-slate-200' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mt-1">{{ $review->comment }}</p>
                            @if($review->image)
                                <img src="{{ asset('storage/' . $review->image) }}" class="w-32 h-32 object-cover mt-3 rounded-xl border">
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 italic text-center">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection