@extends('layouts.app')

@section('content')
<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h2 class="mt-4 text-lg font-bold text-slate-900">Successfully Signed In</h2>
        <p class="mt-2 text-sm text-slate-500">Redirecting you to your workspace dashboard...</p>
        <div class="mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'student.dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none">
                Go to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

