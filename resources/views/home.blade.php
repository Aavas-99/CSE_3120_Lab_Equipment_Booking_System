@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200 p-8 shadow-sm sm:p-12 lg:p-16">
    <!-- Background abstract patterns -->
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.emerald.50),white)] opacity-70"></div>
    <div class="absolute right-0 top-0 -z-10 h-72 w-72 translate-x-1/4 -translate-y-1/4 rounded-full bg-emerald-100/40 blur-3xl"></div>
    
    <div class="mx-auto max-w-3xl text-center">
        <!-- University Badge -->
        <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-slate-50 p-2 shadow-sm ring-1 ring-slate-100">
            <img src="{{ asset('kuet_logo.png') }}" alt="KUET Logo" class="h-20 w-auto">
        </div>
        
        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-inset ring-emerald-600/20">
            Khulna University of Engineering & Technology
        </span>
        
        <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
            Lab Equipment <span class="text-emerald-700">Booking System</span>
        </h1>
        
        <p class="mt-6 text-base leading-7 text-slate-600 sm:text-lg">
            Welcome to the official KUET Lab Portal. A simplified academic platform for students to browse and reserve laboratory tools, request equipment bookings, and track returns, helping laboratory assistants manage inventory efficiently.
        </p>
        
        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-700 px-6 py-3.5 text-sm font-semibold text-white shadow-md transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign In to Portal
            </a>
            <a href="{{ route('register') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Create Student Account
            </a>
        </div>
    </div>

    <!-- Quick portal details grid -->
    <div class="mx-auto mt-16 max-w-5xl border-t border-slate-100 pt-12">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">
            <div class="flex flex-col items-center text-center p-4">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Browse Inventory</h3>
                <p class="mt-2 text-xs leading-5 text-slate-500">Explore and search through available lab instruments and components across different department domains.</p>
            </div>
            
            <div class="flex flex-col items-center text-center p-4">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Instant Requests</h3>
                <p class="mt-2 text-xs leading-5 text-slate-500">Choose dates, select quantities, and submit reservation requests directly from your dashboard.</p>
            </div>
            
            <div class="flex flex-col items-center text-center p-4">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Clear Accountability</h3>
                <p class="mt-2 text-xs leading-5 text-slate-500">Track pending/active/returned bookings, report damages, and manage any late return fines effortlessly.</p>
            </div>
        </div>
    </div>
</div>
@endsection

