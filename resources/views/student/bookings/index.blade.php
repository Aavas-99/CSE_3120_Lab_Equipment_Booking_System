@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 font-sans">My Bookings</h1>
        <p class="mt-1 text-sm text-slate-500">Track and manage all your active and historic lab equipment reservations</p>
    </div>
    <div>
        <a href="{{ route('student.bookings.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <svg class="h-5 w-5 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Book New Equipment
        </a>
    </div>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @include('student.bookings.table', ['bookings' => $bookings])
    
    @if(method_exists($bookings, 'links') && $bookings->hasPages())
        <div class="mt-6 border-t border-slate-100 pt-6">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection

