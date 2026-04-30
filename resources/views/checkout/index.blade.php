@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white rounded-[3rem] p-10 shadow-2xl border border-slate-100 relative overflow-hidden">
            {{-- Decorative Element --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/5 rounded-full -mr-16 -mt-16"></div>

            <h1 class="text-3xl font-black text-blue-900 mb-8 uppercase italic tracking-tighter">
                Final <span class="text-orange-500">Checkout</span>
            </h1>

            {{-- Order Summary Table --}}
            <div class="bg-slate-50 rounded-3xl p-6 mb-8 border border-slate-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-200">
                            <th class="pb-4">Product</th>
                            <th class="pb-4 text-center">Qty</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <tr>
                            <td class="py-4 font-bold text-blue-900 uppercase text-xs">{{ $item['name'] }}</td>
                            <td class="py-4 text-center font-bold text-slate-500 text-xs">{{ $item['quantity'] }}</td>
                            <td class="py-4 text-right font-black text-blue-900 text-xs">৳{{ number_format($item['price'] * $item['quantity']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4 flex justify-between items-center pt-4 border-t-2 border-dashed border-slate-200">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Amount</span>
                    <span class="text-2xl font-black text-orange-600 tracking-tighter">৳{{ number_format($total) }}</span>
                </div>
            </div>

            {{-- Checkout Form --}}
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    
                    {{-- Department Dropdown --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Your Department</label>
                        <div class="relative">
                            <select name="department" required 
                                    class="w-full px-8 py-5 bg-slate-50 border-none rounded-[2rem] focus:ring-4 focus:ring-blue-900/10 outline-none font-bold text-blue-900 shadow-inner appearance-none cursor-pointer">
                                <option value="">Select Department</option>
                                <option value="SWE" class="font-black text-blue-600">SWE (Software Engineering) ⭐</option>
                                <optgroup label="Science & IT">
                                    <option value="CSE">CSE</option>
                                    <option value="CIS">CIS</option>
                                    <option value="MCT">MCT</option>
                                </optgroup>
                                <optgroup label="Business">
                                    <option value="BBA">BBA</option>
                                    <option value="I & E">Innovation & Entrepreneurship</option>
                                </optgroup>
                                <optgroup label="Engineering">
                                    <option value="Civil">Civil</option>
                                    <option value="EEE">EEE</option>
                                    <option value="Textile">Textile</option>
                                </optgroup>
                                <option value="Agriculture">Agriculture</option>
                            </select>
                            <i class="fa-solid fa-building-user absolute right-8 top-1/2 -translate-y-1/2 text-blue-900/30"></i>
                        </div>
                    </div>

                    {{-- Contact Number --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Contact Number</label>
                        <input type="tel" name="phone" placeholder="017XXXXXXXX" required
                               class="w-full px-8 py-5 bg-slate-50 border-none rounded-[2rem] focus:ring-4 focus:ring-blue-900/10 outline-none font-bold text-blue-900 shadow-inner">
                    </div>

                    {{-- Pickup Point Dropdown (Fixed Options) --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Select Pickup Point (Smart City)</label>
                        <div class="relative">
                            <select name="pickup_point" required 
                                    class="w-full px-8 py-5 bg-slate-50 border-none rounded-[2rem] focus:ring-4 focus:ring-blue-900/10 outline-none font-bold text-blue-900 shadow-inner appearance-none cursor-pointer">
                                <option value="">Select a location</option>
                                <optgroup label="Main Campus">
                                    <option value="AB4">AB4 (Main Building)</option>
                                    <option value="8no Gate">8no Gate</option>
                                    <option value="Dadur Tong">Dadur Tong ☕</option>
                                    <option value="Admission building">Admission Building</option>
                                </optgroup>
                                <optgroup label="Halls / Dorms">
                                    <option value="YKGS 1">YKGS 1</option>
                                    <option value="RASG-1">RASG-1</option>
                                    <option value="GREEN GARDEN">Green Garden</option>
                                </optgroup>
                            </select>
                            <i class="fa-solid fa-location-dot absolute right-8 top-1/2 -translate-y-1/2 text-orange-500"></i>
                        </div>
                    </div>

                    {{-- Additional Note --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Pickup Note (Optional)</label>
                        <textarea name="pickup_note" placeholder="Any specific instructions (e.g. Meet me at the cafe entrance)"
                                  class="w-full px-8 py-5 bg-slate-50 border-none rounded-[2rem] focus:ring-4 focus:ring-blue-900/10 outline-none font-bold text-blue-900 shadow-inner h-24"></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full mt-10 bg-blue-900 text-white py-6 rounded-[2rem] font-black shadow-xl hover:bg-orange-500 transition-all transform hover:scale-[1.02] active:scale-95 uppercase tracking-[0.2em] text-xs">
                    Confirm Order Now <i class="fa-solid fa-bolt ml-2"></i>
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            <i class="fa-solid fa-shield-halved mr-1"></i> Secure Campus Transaction
        </p>
    </div>
</div>
@endsection
