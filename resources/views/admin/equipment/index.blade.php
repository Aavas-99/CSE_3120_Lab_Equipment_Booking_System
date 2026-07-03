@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Equipment Inventory</h1>
        <p class="mt-1 text-sm text-slate-500">Add, update, or remove laboratory instruments and track stock availability</p>
    </div>
    <div>
        <a href="{{ route('admin.equipment.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <svg class="h-5 w-5 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Equipment
        </a>
    </div>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Serial Number</th>
                    <th class="px-6 py-4">Total Qty</th>
                    <th class="px-6 py-4">Available</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Location</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($equipment as $item)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                            {{ $item->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                            {{ $item->category->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-slate-500">
                            {{ $item->serial_number }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-700">
                            {{ $item->quantity }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                            {{ $item->available_quantity }}
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
                        <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                            {{ $item->location ?: '-' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-xs">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.equipment.edit', $item) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                    Edit
                                </a>
                                <form method="post" action="{{ route('admin.equipment.delete', $item) }}" onsubmit="return confirm('Are you sure you want to delete this equipment? This action cannot be undone.');">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 font-bold text-rose-700 transition hover:bg-rose-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                            No equipment registered in the inventory.
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
</div>
@endsection

