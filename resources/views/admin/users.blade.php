@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black text-blue-900 uppercase italic tracking-tighter">System <span class="text-orange-500">Users</span></h1>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-black bg-blue-900 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-orange-500 transition uppercase tracking-widest">Back</a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Student Info</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Role</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr>
                        <td class="p-6 flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center text-white font-black uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-blue-900 uppercase">{{ $user->name }}</p>
                                <p class="text-slate-400 text-xs">{{ $user->email }}</p>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-orange-500 text-white' : 'bg-blue-100 text-blue-900' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:text-red-700 transition">
                                    [ Block User ]
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
