@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
    <p class="mt-1 text-sm text-slate-500">Track student reservations, issues, returns, and overdue dates</p>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @include('admin.bookings.table', ['bookings' => $bookings])
    
    @if(method_exists($bookings, 'links') && $bookings->hasPages())
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection

