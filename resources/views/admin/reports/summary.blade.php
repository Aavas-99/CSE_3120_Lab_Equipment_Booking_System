<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    <!-- Stat 1 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $totalEquipment }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Total Equipment</span>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-700 ring-1 ring-teal-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $availableEquipment }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Available Qty</span>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700 ring-1 ring-blue-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $activeBookings }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Active Bookings</span>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700 ring-1 ring-amber-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $pendingRequests }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Requests</span>
        </div>
    </div>

    <!-- Stat 5 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-700 ring-1 ring-rose-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ $overdueItems }}</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Overdue Items</span>
        </div>
    </div>

    <!-- Stat 6 -->
    <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-2xl font-bold text-slate-900">{{ number_format($totalFines, 2) }} BDT</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Total Fines</span>
        </div>
    </div>
</div>

