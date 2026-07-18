@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Damage Reports</h1>
    <p class="mt-1 text-sm text-slate-500">Review equipment malfunction issues submitted by students and toggle maintenance status</p>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Equipment</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Admin Note</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($reports as $report)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                            {{ $report->user->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-800">
                            {{ $report->equipment->name }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 max-w-xs break-words">
                            {{ $report->description }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <form id="damage-report-{{ $report->id }}" method="post" action="{{ route('admin.damage_reports.update', $report) }}">
                                @csrf 
                                @method('patch')
                            </form>
                            <select form="damage-report-{{ $report->id }}" name="status" class="rounded-lg border border-slate-300 bg-slate-50 px-2.5 py-1.5 text-xs text-slate-700 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 w-28">
                                <option value="pending" @selected($report->status === 'pending')>Pending</option>
                                <option value="reviewed" @selected($report->status === 'reviewed')>Reviewed</option>
                                <option value="resolved" @selected($report->status === 'resolved')>Resolved</option>
                            </select>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <input form="damage-report-{{ $report->id }}" type="text" name="admin_note" value="{{ $report->admin_note }}" class="rounded-lg border border-slate-300 bg-slate-50 px-3 py-1.5 text-xs text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 w-48" placeholder="Admin note...">
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-xs">
                            <div class="flex items-center justify-end gap-3.5">
                                <label class="inline-flex items-center gap-1.5 text-slate-600 cursor-pointer">
                                    <input form="damage-report-{{ $report->id }}" type="checkbox" name="mark_maintenance" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="font-semibold">Maintenance</span>
                                </label>
                                <button form="damage-report-{{ $report->id }}" type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-3 py-1.5 font-bold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none">
                                    Update
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            No damage reports registered in the database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($reports, 'links') && $reports->hasPages())
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection

