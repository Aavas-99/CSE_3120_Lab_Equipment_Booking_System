@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Admin Control Center</h1>
    <p class="mt-1 text-sm text-slate-500">Monitor lab activities, approve booking requests, track inventory metrics, and manage user accounts.</p>
</div>

<!-- Statistical Summary Widget -->
@include('admin.reports.summary')

<!-- Recent Bookings Section -->
<div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Recent Portal Activities</h2>
            <p class="text-xs text-slate-500">Latest reservations and transaction requests from students</p>
        </div>
        <a href="{{ route('admin.bookings') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">View All Bookings &rarr;</a>
    </div>
    
    @include('admin.bookings.table', ['bookings' => $recentBookings])
</div>
@endsection

