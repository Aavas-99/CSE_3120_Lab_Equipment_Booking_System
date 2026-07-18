@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Available Equipment</h1>
        <p class="mt-1 text-sm text-slate-500">Search and reserve academic lab tools for class experiments</p>
    </div>
</div>

<!-- Search and Filter Panel -->
<div class="mb-8 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <form method="get" class="grid grid-cols-1 gap-4 sm:grid-cols-4 items-end">
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Search</label>
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Equipment name..." class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 pl-9">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Category</label>
            <select name="category_id" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Status</label>
            <select name="status" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                <option value="">Any bookable status</option>
                <option @selected(request('status') === 'Available')>Available</option>
                <option @selected(request('status') === 'Reserved')>Reserved</option>
            </select>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'category_id', 'status']))
                <a href="{{ route('student.equipment') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Wrap -->
<div class="overflow-x-auto rounded-lg border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
        <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Category</th>
                <th class="px-6 py-4">Available Qty</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Location</th>
                <th class="px-6 py-4 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($equipment as $item)
                <tr class="transition hover:bg-slate-50">
                    <td class="whitespace-nowrap px-6 py-4.5 font-semibold text-slate-900">
                        {{ $item->name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 text-slate-500">
                        {{ $item->category->name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 font-medium text-slate-700">
                        {{ $item->available_quantity }} <span class="text-xs font-normal text-slate-400">/ {{ $item->quantity }}</span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5">
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
                    <td class="whitespace-nowrap px-6 py-4.5 text-slate-600">
                        {{ $item->location }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 text-right text-xs">
                        <a href="{{ route('student.equipment.show', $item) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                            View Details
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        No equipment found matching criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(method_exists($equipment, 'links') && $equipment->hasPages())
    <div class="mt-6">
        {{ $equipment->links() }}
    </div>
@endif
@endsection

