@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Damage Reports</h1>
    <p class="mt-1 text-sm text-slate-500">Report any damaged, malfunctioning, or missing laboratory equipment</p>
</div>

<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <!-- Submit Report Form -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1 h-fit">
        <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Submit Damage Report</h2>
        
        <form method="post" action="{{ route('student.damage_reports.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Equipment</label>
                <select name="equipment_id" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                    <option value="">Choose equipment</option>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Related Booking <span class="text-slate-400 font-normal">(Optional)</span></label>
                <select name="booking_id" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                    <option value="">No booking selected</option>
                    @foreach($bookings as $booking)
                        <option value="{{ $booking->id }}">{{ $booking->equipment->name }} - {{ $booking->status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Problem Description</label>
                <textarea name="description" rows="4" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="Please describe the malfunction or issue in detail...">{{ old('description') }}</textarea>
            </div>
            
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Submit Report
            </button>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
        <h2 class="text-base font-bold text-slate-900 mb-5">Your Submitted Reports</h2>
        
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Equipment</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Admin Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($reports as $report)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4.5 font-semibold text-slate-900">
                                {{ $report->equipment->name }}
                            </td>
                            <td class="px-6 py-4.5 max-w-xs break-words text-slate-600">
                                {{ $report->description }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4.5">
                                @php
                                    $badgeStyle = match(strtolower($report->status)) {
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'reviewed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyle }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4.5 text-slate-500 max-w-xs break-words">
                                {{ $report->admin_note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                No damage reports submitted.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($reports, 'links') && $reports->hasPages())
            <div class="mt-5 border-t border-slate-100 pt-5">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

