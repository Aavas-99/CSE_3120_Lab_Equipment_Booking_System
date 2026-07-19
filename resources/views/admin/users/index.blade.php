@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Manage Students</h1>
    <p class="mt-1 text-sm text-slate-500">View student borrowing history metrics and toggle account activation status</p>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Total Bookings</th>
                    <th class="px-6 py-4">Account Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($students as $student)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4.5 font-semibold text-slate-900">
                            {{ $student->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5 text-slate-600">
                            {{ $student->email }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5 font-bold text-slate-800">
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-700">
                                {{ $student->bookings_count }} bookings
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5">
                            @php
                                $badgeStyle = match(strtolower($student->status)) {
                                    'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'blocked' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyle }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4.5 text-right text-xs">
                            <form method="post" action="{{ route('admin.users.toggle', $student) }}" onsubmit="return confirm('Are you sure you want to change this student account status?');">
                                @csrf 
                                @method('patch')
                                @if($student->status === 'active')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3.5 py-1.5 font-bold text-rose-700 transition hover:bg-rose-100">
                                        Block Student
                                    </button>
                                @else
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 px-3.5 py-1.5 font-bold text-emerald-800 transition hover:bg-emerald-100">
                                        Activate Student
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            No student accounts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

