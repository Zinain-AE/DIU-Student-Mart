@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-3xl font-black text-blue-900 mb-8 uppercase italic tracking-tighter">
            Incoming <span class="text-orange-500">Orders</span>
        </h1>

        @if($orders->isEmpty())
            <div class="bg-white p-20 rounded-[3rem] text-center shadow-xl border border-slate-100">
                <div class="relative inline-block mb-6">
                    <i class="fa-solid fa-box-open text-slate-100 text-9xl"></i>
                    <i class="fa-solid fa-magnifying-glass text-orange-500 text-3xl absolute bottom-4 right-4"></i>
                </div>
                <h3 class="text-2xl font-black text-blue-900 uppercase italic tracking-tighter mb-2">
                    No Sales <span class="text-orange-500">History!</span>
                </h3>
                <p class="text-slate-400 font-bold text-sm uppercase tracking-widest mb-8">
                    You haven't received any orders for your products yet.
                </p>
                <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center gap-3 bg-blue-900 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-500 transition shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-gauge-high"></i> Back to Dashboard
                </a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($orders as $order)
                <div class="bg-white rounded-[2.5rem] p-8 shadow-lg border-l-8 
                    @if($order->status == 'pending') border-orange-500 
                    @elseif($order->status == 'delivered') border-green-500 
                    @else border-red-500 @endif">
                    
                    <div class="flex flex-wrap justify-between items-start mb-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer ID</p>
                            <p class="font-black text-blue-900">#USER-{{ $order->user_id }}</p>
                            
                            {{-- FIXED: Logic to check order phone, then user phone --}}
                            <p class="text-xs text-slate-500 mt-1 font-bold">
                                <i class="fa-solid fa-phone text-orange-500"></i> 
                                {{ $order->phone ?? ($order->user->phone ?? 'Not Provided') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Order Status</p>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase 
                                @if($order->status == 'pending') bg-orange-100 text-orange-600 
                                @elseif($order->status == 'delivered') bg-green-100 text-green-600 
                                @else bg-red-100 text-red-600 @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div> 

                    <div class="bg-slate-50 rounded-2xl p-4 mb-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Products to Deliver:</p>
                        @foreach($order->items as $item)
                            @if($item->product->user_id == auth()->id())
                                <div class="flex justify-between border-b border-slate-200 py-2 last:border-0">
                                    <span class="text-sm font-bold text-blue-900">
                                        {{ $item->product->name ?? 'Deleted Product' }} (x{{ $item->quantity }})
                                    </span>
                                    <span class="text-sm font-black text-orange-600">৳{{ number_format($item->price * $item->quantity) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex flex-wrap justify-between items-center gap-4">
                        <div class="max-w-md">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-orange-500">Pickup Location</p>
                            {{-- FIXED: Changed 'note' to 'pickup_point' --}}
                            <p class="text-sm font-black text-slate-700 italic">
                                {{ $order->pickup_point ?? 'No Location Provided' }}
                            </p>
                        </div>
                        
                        <div class="flex gap-2">
                            @if($order->status == 'pending')
                                <form action="{{ route('seller.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded-xl font-black uppercase text-[10px] hover:bg-green-600 transition shadow-lg flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i> Mark as Delivered
                                    </button>
                                </form>
                            @elseif($order->status == 'delivered')
                                <div class="bg-green-50 text-green-600 px-6 py-3 rounded-xl font-black uppercase text-[10px] flex items-center gap-2 border border-green-200">
                                    <i class="fa-solid fa-check-double"></i> Successfully Delivered
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection