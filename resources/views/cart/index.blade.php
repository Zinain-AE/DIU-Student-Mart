@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-black text-blue-900 mb-10 uppercase italic tracking-tighter text-center">Your <span class="text-orange-500">Cart</span></h1>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Product</th>
                            <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Quantity</th>
                            <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Subtotal</th>
                            <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td class="p-8 flex items-center gap-6">
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-cover rounded-2xl shadow-md">
                                    <p class="font-black text-blue-900 uppercase text-lg">{{ $details['name'] }}</p>
                                </td>
                                
                                <td class="p-8">
                                    <div class="flex items-center justify-center gap-4">
                                        {{-- Minus Form --}}
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                            <button type="submit" class="w-10 h-10 bg-slate-100 rounded-full font-black text-blue-900 hover:bg-orange-500 hover:text-white transition shadow-sm border border-slate-200">-</button>
                                        </form>

                                        <span class="font-black text-blue-900 text-xl w-8 text-center">{{ $details['quantity'] }}</span>

                                        {{-- Plus Form --}}
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                            <button type="submit" class="w-10 h-10 bg-slate-100 rounded-full font-black text-blue-900 hover:bg-orange-500 hover:text-white transition shadow-sm border border-slate-200">+</button>
                                        </form>
                                    </div>
                                </td>

                                <td class="p-8 text-center font-black text-blue-900 italic text-lg">৳{{ number_format($details['price'] * $details['quantity']) }}</td>
                                
                                <td class="p-8 text-right">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition p-2">
                                            <i class="fa-solid fa-trash-can text-2xl"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-10 bg-blue-900 text-white flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Total Amount</p>
                        <h2 class="text-4xl font-black italic tracking-tighter">৳{{ number_format($total) }}</h2>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="bg-orange-500 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-white hover:text-blue-900 transition shadow-2xl scale-110">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-[3rem] shadow-xl">
                <i class="fa-solid fa-cart-shopping text-slate-100 text-[120px] mb-6"></i>
                <h3 class="text-2xl font-black text-slate-300 uppercase italic">Your cart is empty</h3>
                <a href="{{ route('products.index') }}" class="inline-block mt-8 bg-blue-900 text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-orange-500 transition">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection