@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-20">
    <div class="max-w-md mx-auto bg-white rounded-[2.5rem] shadow-2xl p-10 border border-gray-50">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-blue-900">Welcome Back</h2>
            <p class="text-gray-400 font-medium mt-2 text-sm">Use your DIU Student Email to log in</p>
        </div>
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 rounded-2xl text-red-600 text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf <div class="space-y-2">
                <label class="text-xs font-black text-gray-400 uppercase ml-2">Student Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="elma23... @diu.edu.bd" 
                    class="w-full p-4 bg-gray-50 rounded-2xl border-none focus:ring-2 focus:ring-blue-500 outline-none" required autofocus>
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-black text-gray-400 uppercase ml-2">Password</label>
                <input type="password" name="password" placeholder="••••••••" 
                    class="w-full p-4 bg-gray-50 rounded-2xl border-none focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <div class="flex items-center ml-2">
                <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-blue-500">
                <label for="remember" class="ml-2 text-xs font-bold text-gray-400 uppercase">Remember Me</label>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-5 rounded-2xl font-black text-lg hover:bg-orange-600 shadow-xl transition">
                Log In
            </button>
        </form>
        
        <p class="text-center mt-8 text-sm text-gray-500 font-medium">
            New here? <a href="{{ route('register') }}" class="text-blue-900 font-black underline">Create Student Account</a>
        </p>
    </div>
</div>
@endsection