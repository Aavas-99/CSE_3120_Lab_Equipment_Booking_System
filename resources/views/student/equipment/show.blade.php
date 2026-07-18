@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-5">
        <a href="{{ route('student.equipment') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            &larr; Back to Inventory
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-slate-50 border-b border-slate-100 p-6">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 ring-1 ring-inset ring-emerald-600/10 mb-2">
                        {{ $equipment->category->name }}
                    </span>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $equipment->name }}</h1>
                </div>
                <div>
                    @php
                        $badgeStyle = match($equipment->status) {
                            'Available' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Reserved' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Maintenance' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Damaged' => 'bg-rose-50 text-rose-700 border-rose-200',
                            default => 'bg-slate-50 text-slate-600 border-slate-200',
                        };
                    @endphp
                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold {{ $badgeStyle }}">
                        Status: {{ $equipment->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            @if($equipment->description)
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Equipment Description</h2>
                    <p class="text-sm leading-6 text-slate-600 bg-slate-50 rounded-lg p-4 border border-slate-100">{{ $equipment->description }}</p>
                </div>
            @endif

            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Specification Details</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-slate-100 p-4">
                        <span class="block text-xs text-slate-400 font-medium">Serial Number</span>
                        <span class="block mt-1 font-semibold text-slate-800 text-sm">{{ $equipment->serial_number }}</span>
                    </div>
                    
                    <div class="rounded-lg border border-slate-100 p-4">
                        <span class="block text-xs text-slate-400 font-medium">Storage Location</span>
                        <span class="block mt-1 font-semibold text-slate-800 text-sm">{{ $equipment->location ?: 'Not Specified' }}</span>
                    </div>
                    
                    <div class="rounded-lg border border-slate-100 p-4">
                        <span class="block text-xs text-slate-400 font-medium">Stock Quantities</span>
                        <span class="block mt-1 font-semibold text-slate-800 text-sm">
                            {{ $equipment->available_quantity }} Available <span class="text-xs font-normal text-slate-400">/ {{ $equipment->quantity }} Total</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-6 flex justify-end">
                @if($equipment->available_quantity > 0 && $equipment->status === 'Available')
                    <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('student.bookings.create', ['equipment_id' => $equipment->id]) }}">
                        Request Booking Reservation
                    </a>
                @else
                    <button disabled class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-400 border border-slate-200 cursor-not-allowed">
                        Currently Unavailable
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

