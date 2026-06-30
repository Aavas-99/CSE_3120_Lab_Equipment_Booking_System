@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">My Fines</h1>
    <p class="mt-1 text-sm text-slate-500">View and track all outstanding late return fines</p>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Equipment</th>
                    <th class="px-6 py-4">Days Late</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($fines as $fine)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4.5 font-semibold text-slate-900">
                            {{ $fine->booking->equipment->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5 text-slate-600 font-medium">
                            {{ $fine->days_late }} days
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5 font-bold text-rose-600">
                            {{ number_format($fine->amount, 2) }} BDT
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5">
                            @php
                                $badgeStyle = match(strtolower($fine->status)) {
                                    'unpaid' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyle }}">
                                {{ ucfirst($fine->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            No fines recorded. You are clear!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($fines, 'links') && $fines->hasPages())
        <div class="mt-5">
            {{ $fines->links() }}
        </div>
    @endif
</div>
@endsection

