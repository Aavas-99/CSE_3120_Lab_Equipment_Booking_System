@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Statistical Inventory Reports</h1>
    <p class="mt-1 text-sm text-slate-500">Overview of lab transactions, stock levels, and booking statistics</p>
</div>

<!-- Stats Summary -->
@include('admin.reports.summary')

<div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-5 border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-900">Most Borrowed Equipment</h2>
        <p class="text-xs text-slate-500">Popular items frequently reserved by students for academic experiments</p>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Equipment</th>
                    <th class="px-6 py-4">Serial Number</th>
                    <th class="px-6 py-4">Borrow Count</th>
                    <th class="px-6 py-4">Current Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($mostBorrowed as $item)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                            {{ $item->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-slate-500">
                            {{ $item->serial_number }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="rounded-full bg-emerald-50 border border-emerald-100 px-3 py-0.5 text-xs font-bold text-emerald-800">
                                {{ $item->borrow_count }} times
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @php
                                $badgeStyle = match($item->status) {
                                    'Available' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Reserved' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'Maintenance' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Damaged' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyle }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            No borrowing activities recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

