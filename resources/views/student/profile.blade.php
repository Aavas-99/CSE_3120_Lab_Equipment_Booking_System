@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-slate-50 border-b border-slate-100 p-6">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-lg font-bold text-emerald-800">
                    {{ substr($user->name, 0, 1) }}
                </span>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">My Profile</h1>
                    <p class="text-xs text-slate-500">Your account identity details and status</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-lg border border-slate-100 p-4">
                    <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">Full Name</span>
                    <span class="block mt-1 font-semibold text-slate-800 text-sm">{{ $user->name }}</span>
                </div>
                
                <div class="rounded-lg border border-slate-100 p-4">
                    <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">Email Address</span>
                    <span class="block mt-1 font-semibold text-slate-800 text-sm">{{ $user->email }}</span>
                </div>
                
                <div class="rounded-lg border border-slate-100 p-4">
                    <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">System Role</span>
                    <span class="block mt-1 font-semibold text-slate-850 text-sm uppercase tracking-wide">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                
                <div class="rounded-lg border border-slate-100 p-4">
                    <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">Account Status</span>
                    <div class="mt-1">
                        @php
                            $badgeStyle = match(strtolower($user->status)) {
                                'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'blocked' => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                        @endphp
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyle }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

