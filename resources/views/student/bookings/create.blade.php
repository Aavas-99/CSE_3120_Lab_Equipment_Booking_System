@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Request Equipment Booking</h2>
                <p class="text-xs text-slate-500">Submit a reservation request for your course experiments</p>
            </div>
        </div>
        
        <form method="post" action="{{ route('student.bookings.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Select Equipment</label>
                <select name="equipment_id" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                    <option value="">Choose equipment</option>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}" @selected(old('equipment_id', $selectedEquipmentId) == $item->id)>
                            {{ $item->name }} ({{ $item->available_quantity }} available)
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Borrow Date</label>
                    <input type="date" name="borrow_date" value="{{ old('borrow_date', now()->toDateString()) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Expected Return Date</label>
                    <input type="date" name="expected_return_date" value="{{ old('expected_return_date', now()->addDays(3)->toDateString()) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('student.equipment') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Cancel</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

