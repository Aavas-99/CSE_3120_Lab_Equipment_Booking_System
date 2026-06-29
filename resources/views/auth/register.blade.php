@extends('layouts.app')

@section('content')
<div class="mx-auto w-full max-w-md">
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-6 text-center">
            <img src="{{ asset('kuet_logo.png') }}" alt="KUET Logo" class="mx-auto h-16 w-auto mb-3">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Student Registration</h2>
            <p class="mt-1 text-sm text-slate-500">Create an account to start booking lab equipment</p>
        </div>
        
        <form method="post" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. John Doe">
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. student@kuet.ac.bd">
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="********">
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="********">
            </div>
            
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 mt-2">
                <svg class="h-4 w-4 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Create Student Account
            </button>
        </form>
    </div>
</div>
@endsection


