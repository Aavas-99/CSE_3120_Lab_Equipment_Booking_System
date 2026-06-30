@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Student Dashboard</h1>
    <p class="mt-1 text-sm text-slate-500">Welcome to your portal. Here is a summary of your lab bookings and active records.</p>
</div>

<!-- Stats Grid -->
<div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
    <!-- Card 1 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 ring-1 ring-amber-500/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $pending }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Requests</span>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $active }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Active Bookings</span>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 ring-1 ring-rose-500/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ number_format($fines, 2) }} BDT</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Unpaid Fines</span>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-900">Recent Booking Activities</h2>
        <a href="{{ route('student.bookings') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">View All Bookings &rarr;</a>
    </div>
    @include('student.bookings.table', ['bookings' => $recentBookings])
</div>
@endsection

