<div class="overflow-x-auto rounded-lg border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
        <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-6 py-4">Equipment</th>
                <th class="px-6 py-4">Borrow Date</th>
                <th class="px-6 py-4">Expected Return</th>
                <th class="px-6 py-4">Actual Return</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Fine</th>
                <th class="px-6 py-4 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($bookings as $booking)
                <tr class="transition hover:bg-slate-50">
                    <td class="whitespace-nowrap px-6 py-4.5 font-semibold text-slate-900">
                        {{ $booking->equipment->name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5">
                        {{ $booking->borrow_date?->format('M d, Y') }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5">
                        {{ $booking->expected_return_date?->format('M d, Y') }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 text-slate-500">
                        {{ $booking->actual_return_date?->format('M d, Y') ?? '-' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5">
                        @php
                            $statusClass = match($booking->status) {
                                'Pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'Approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Issued' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Return Requested' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'Returned' => 'bg-slate-100 text-slate-600 border-slate-200',
                                'Rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'Overdue' => 'bg-rose-100 text-rose-800 border-rose-300 animate-pulse',
                                default => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                        @endphp
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $statusClass }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 font-medium {{ $booking->fine ? 'text-rose-600' : 'text-slate-500' }}">
                        {{ $booking->fine ? number_format($booking->fine->amount, 2).' BDT' : '-' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4.5 text-right text-xs">
                        <div class="flex items-center justify-end gap-2">
                            @if($booking->status === 'Pending')
                                <form method="post" action="{{ route('student.bookings.cancel', $booking) }}" onsubmit="return confirm('Are you sure you want to cancel this booking request?');">
                                    @csrf 
                                    @method('patch')
                                    <button class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 font-bold text-rose-700 transition hover:bg-rose-100 hover:text-rose-800">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                            @if($booking->status === 'Issued')
                                <form method="post" action="{{ route('student.bookings.return_request', $booking) }}">
                                    @csrf 
                                    @method('patch')
                                    <button class="inline-flex items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 font-bold text-emerald-800 transition hover:bg-emerald-100">
                                        Request Return
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        No bookings found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

