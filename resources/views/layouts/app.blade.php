<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIU Student Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fade-in-right {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-right {
            animation: fade-in-right 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans">
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="container mx-auto px-4 h-20 flex justify-between items-center">
            
            {{-- Logo Section --}}
            <div class="flex items-center mr-12">
                <a href="/">
                    <span class="text-2xl font-black text-blue-900 tracking-tight italic">
                        DIU STUDENT <span class="text-orange-600">MART</span>
                    </span>
                </a>
            </div>

            {{-- Navigation Links --}}
            <div class="hidden lg:flex items-center gap-10 text-gray-700 font-bold uppercase text-[13px] tracking-wide flex-1">
                <a href="/" class="hover:text-blue-700 transition {{ Request::is('/') ? 'text-blue-900 border-b-2 border-orange-500 pb-1' : '' }}">Marketplace</a>
                
                @auth
                    @if(auth()->user()->role !== 'admin')
                        @if(auth()->user()->role == 'seller')
                            <a href="{{ route('seller.orders') }}" class="hover:text-blue-700 transition flex items-center gap-2 {{ Request::is('seller/orders*') ? 'text-blue-900 border-b-2 border-orange-500 pb-1' : '' }}">
                                <i class="fa-solid fa-clipboard-list text-orange-500"></i> Incoming Orders
                            </a>
                            <a href="{{ route('seller.dashboard') }}" class="hover:text-blue-700 transition {{ Request::is('seller/dashboard*') ? 'text-blue-900 border-b-2 border-orange-500 pb-1' : '' }}">Seller Dashboard</a>
                        @else
                            <form action="{{ route('become.seller') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-orange-600 hover:text-orange-700 transition font-black flex items-center gap-2">
                                    <i class="fa-solid fa-store"></i> Start Selling
                                </button>
                            </form>
                            <a href="{{ route('orders.index') }}" class="hover:text-blue-700 transition {{ Request::is('my-orders*') ? 'text-blue-900 border-b-2 border-orange-500 pb-1' : '' }}">My Order History</a>
                        @endif
                    @endif

                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-red-600 font-black flex items-center gap-2">
                            <i class="fa-solid fa-gauge-high"></i> Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            {{-- User Section --}}
            <div class="flex items-center gap-6">
                @auth
                    @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('cart.index') }}" class="group flex items-center bg-slate-100 px-4 py-2.5 rounded-xl hover:bg-blue-900 hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-cart-shopping mr-2 text-slate-500 group-hover:text-white"></i>
                        <span class="text-[11px] font-black uppercase tracking-widest">My Cart</span>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="ml-2 bg-orange-600 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full shadow-lg">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                    @endif

                    <div class="flex items-center gap-4 border-l pl-6 border-slate-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-[9px] font-black text-slate-400 uppercase leading-none mb-1">Campus ID</p>
                            <p class="text-[12px] font-black text-blue-900 leading-none lowercase">
                                {{ explode('@', auth()->user()->email)[0] }}
                            </p>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="w-10 h-10 bg-blue-900 text-white rounded-full flex items-center justify-center font-black shadow-md border-2 border-white ring-2 ring-slate-100 hover:ring-orange-500 transition-all">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-300 hover:text-red-600 transition-colors ml-1" title="Logout">
                                <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-blue-900 font-black text-sm hover:text-orange-600 transition">LOGIN</a>
                    <a href="{{ route('register') }}" class="bg-blue-900 text-white px-6 py-2.5 rounded-xl font-black shadow-lg hover:bg-black transition text-sm">JOIN NOW</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Floating Centralized Alerts --}}
    <div class="fixed top-24 right-4 z-[60] w-full max-w-sm px-4 md:px-0 pointer-events-none">
        @if(session('success'))
            <div id="alert-success" class="pointer-events-auto flex items-center p-4 mb-4 text-white bg-green-500 rounded-2xl shadow-2xl border border-green-400 animate-fade-in-right">
                <i class="fa-solid fa-circle-check text-xl mr-3"></i>
                <div class="text-[11px] font-black uppercase tracking-widest">{{ session('success') }}</div>
                <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-white/70 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" class="pointer-events-auto flex items-center p-4 mb-4 text-white bg-red-600 rounded-2xl shadow-2xl border border-red-500 animate-pulse">
                <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
                <div class="text-[11px] font-black uppercase tracking-widest">{{ session('error') }}</div>
                <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-white/70 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <main class="min-h-[70vh]">
        @yield('content')
    </main>

    <footer class="bg-blue-900 text-white py-12 mt-20">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-black mb-2 uppercase tracking-tighter">DIU Student Mart</h3>
            <p class="text-blue-300 text-[11px] font-bold uppercase tracking-widest opacity-70 mb-4">Connecting Daffodil Students</p>
            
            <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-8">
                Developed by 
                <a href="https://www.linkedin.com/in/zinain-afrin-elma-1118a2286?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="text-white hover:text-orange-400 transition-colors duration-300 underline underline-offset-4">
                    Zinain Afrin Elma
                </a>
            </p>

            <div class="pt-8 border-t border-blue-800/50">
                <p class="text-[10px] text-blue-500 uppercase tracking-[0.3em] font-black">© 2026 DIU Marketplace. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Auto-Hide Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['alert-success', 'alert-error'].forEach(id => {
                let el = document.getElementById(id);
                if(el) {
                    setTimeout(() => {
                        el.style.transition = "all 0.6s ease";
                        el.style.opacity = "0";
                        el.style.transform = "translateX(100px)";
                        setTimeout(() => el.remove(), 600);
                    }, 4000);
                }
            });
        });
    </script>
</body>
</html>