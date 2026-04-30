@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-3xl font-black text-blue-900 mb-8 uppercase italic tracking-tighter">
            My <span class="text-orange-500">Order History</span>
        </h1>

        @if($orders->isEmpty())
            <div class="bg-white p-20 rounded-[3rem] text-center shadow-xl border border-slate-100">
                <i class="fa-solid fa-box-open text-slate-200 text-8xl mb-6"></i>
                <p class="text-slate-400 font-bold text-xl uppercase italic">No orders found yet!</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-blue-900 text-white px-8 py-3 rounded-xl font-black uppercase text-xs">Shop Now</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($orders as $order)
                <div class="bg-white rounded-[2.5rem] p-8 shadow-lg border border-slate-100 hover:border-orange-200 transition-all">
                    {{-- Order Header --}}
                    <div class="flex flex-wrap justify-between items-center mb-6 border-b border-dashed border-slate-200 pb-6">
                        <div class="flex gap-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Order ID</p>
                                <p class="font-black text-blue-900">#DIU-{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</p>
                                <p class="font-bold text-slate-600 text-sm">{{ $order->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest 
                                {{ $order->status == 'pending' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }}">
                                <i class="fa-solid {{ $order->status == 'pending' ? 'fa-clock' : 'fa-check-circle' }} mr-1"></i>
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100">
                                    <i class="fa-solid fa-mobile-screen-button text-blue-900"></i>
                                </div>
                                <div>
                                    <p class="font-black text-blue-900 text-sm uppercase leading-none">{{ $item->product->name ?? 'Product Deleted' }}</p>
                                    <p class="text-xs font-bold text-slate-400 mt-1 italic">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price) }}</p>
                                </div>
                            </div>
                            <p class="font-black text-blue-900 text-sm italic">৳{{ number_format($item->price * $item->quantity) }}</p>
                        </div>
                        @endforeach
                    </div> 

                    {{-- Footer Info & Cancel Action --}}
                    <div class="mt-8 flex flex-wrap justify-between items-center bg-slate-50 rounded-3xl p-6">
                        <div class="max-w-xs">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                <i class="fa-solid fa-map-marker-alt text-orange-500"></i> Pickup Point & Note
                            </p>
                            {{-- FIXED: Changed $order->note to $order->pickup_point --}}
                            <p class="text-xs font-bold text-blue-900 leading-tight">
                                {{ $order->pickup_point ?? 'No Location Set' }} 
                                <span class="text-slate-400 block mt-1 font-normal italic">Note: {{ $order->note ?? 'None' }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-6">
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-white hover:bg-red-500 text-red-500 hover:text-white border border-red-100 px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all flex items-center gap-2 shadow-sm">
                                        <i class="fa-solid fa-trash-can"></i> Cancel Order
                                    </button>
                                </form>
                            @endif

                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Paid</p>
                                <p class="text-2xl font-black text-orange-600 italic tracking-tighter">৳{{ number_format($order->total_amount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection