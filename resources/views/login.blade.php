@extends('layouts.app')

@section('content')
<div class="mx-auto w-full max-w-md">
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-6 text-center">
            <img src="{{ asset('kuet_logo.png') }}" alt="KUET Logo" class="mx-auto mb-3 h-16 w-auto">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Sign In to Portal</h2>
            <p class="mt-1 text-sm text-slate-500">Enter your email or roll to access your dashboard</p>
        </div>

        <form method="post" action="{{ route('login.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-600">Email or Roll</label>
                <input type="text" name="login" value="{{ old('login') }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. rana.2207094@kuet.ac.bd or 2207094">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-600">Password</label>
                <input type="password" name="password" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="password">
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="h-4 w-4 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign In
            </button>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-6 text-center text-xs">
            <span class="text-slate-500">Demo Credentials:</span>
            <div class="mt-1 font-medium text-slate-700">Admin: <span class="text-emerald-700">lab.admin@kuet.ac.bd</span> / password</div>
            <div class="mt-1 font-medium text-slate-700">Student: <span class="text-emerald-700">2207094</span> or <span class="text-emerald-700">rana.2207094@kuet.ac.bd</span> / password</div>
        </div>
    </div>
</div>
@endsection