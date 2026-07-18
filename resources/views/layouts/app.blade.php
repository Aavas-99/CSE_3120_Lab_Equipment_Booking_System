<!doctype html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KUET Lab Equipment Booking System</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased" x-data="{ mobileSidebarOpen: false }">
    
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 flex h-16 w-full items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <!-- Mobile Menu Toggle -->
            @auth
            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none lg:hidden" aria-label="Toggle Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            @endauth
            
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('kuet_logo.png') }}" alt="KUET Logo" class="h-9 w-auto">
                <div>
                    <span class="block text-base font-bold tracking-tight text-emerald-800 sm:text-lg">KUET Lab Portal</span>
                    <span class="hidden text-xs font-medium text-slate-500 sm:block">Lab Equipment Booking System</span>
                </div>
            </a>
        </div>
        
        <div class="flex items-center gap-4">
            @auth
                <div class="hidden items-center gap-3 border-r border-slate-200 pr-4 sm:flex">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-800">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                    <div class="text-left">
                        <span class="block text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                        <span class="block text-[11px] font-medium uppercase tracking-wider text-slate-500">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
                <form method="post" action="{{ route('logout') }}" class="inline-block">
                    @csrf
                    <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="rounded-lg px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 transition">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">Register</a>
                </div>
            @endauth
        </div>
    </header>

    @auth
        <div class="flex min-h-[calc(100vh-64px)] w-full">
            
            <!-- Sidebar (Desktop) -->
            <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white p-5 lg:block">
                <nav class="flex flex-col gap-1.5">
                    @if(auth()->user()->isAdmin())
                        <div class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Admin Control</div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.equipment') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.equipment*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            Equipment Inventory
                        </a>
                        
                        <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.categories') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Categories
                        </a>
                        
                        <a href="{{ route('admin.requests') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.requests') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Booking Requests
                        </a>
                        
                        <a href="{{ route('admin.issued') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.issued') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Issued Equipment
                        </a>
                        
                        <a href="{{ route('admin.overdue') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.overdue') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0x" />
                            </svg>
                            Overdue Tracking
                        </a>

                        <a href="{{ route('admin.bookings') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.bookings') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            All Bookings
                        </a>

                        <a href="{{ route('admin.fines') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.fines') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Fines Management
                        </a>

                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.users') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Students / Users
                        </a>

                        <a href="{{ route('admin.damage_reports') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.damage_reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Damage Reports
                        </a>

                        <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Statistical Reports
                        </a>
                    @else
                        <div class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Student Menu</div>
                        
                        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('student.equipment') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.equipment*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 00-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            Available Equipment
                        </a>
                        
                        <a href="{{ route('student.bookings.create') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.bookings.create') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Book Equipment
                        </a>
                        
                        <a href="{{ route('student.bookings') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.bookings') && !request()->routeIs('student.bookings.create') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            My Bookings
                        </a>
                        
                        <a href="{{ route('student.fines') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.fines') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            My Fines
                        </a>
                        
                        <a href="{{ route('student.damage_reports') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.damage_reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Damage Reports
                        </a>
                        
                        <a href="{{ route('student.profile') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.profile') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                    @endif
                </nav>
            </aside>
            
            <!-- Mobile Sidebar Overlay & Sidebar Panel (controlled by x-show) -->
            <div x-show="mobileSidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
                <!-- Overlay background -->
                <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80" @click="mobileSidebarOpen = false"></div>
                
                <div class="fixed inset-0 flex">
                    <!-- Sidebar Drawer Panel -->
                    <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex w-full max-w-xs flex-1 flex-col bg-white p-5 shadow-xl" @click.away="mobileSidebarOpen = false">
                        
                        <!-- Close button -->
                        <div class="absolute right-4 top-4">
                            <button @click="mobileSidebarOpen = false" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none" aria-label="Close menu">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mb-6 flex items-center gap-2">
                            <img src="{{ asset('kuet_logo.png') }}" alt="KUET Logo" class="h-9 w-auto">
                            <div>
                                <span class="block text-base font-bold tracking-tight text-emerald-800">KUET Lab Portal</span>
                                <span class="block text-xxs font-medium text-slate-500">Equipment Booking System</span>
                            </div>
                        </div>
                        
                        <nav class="flex flex-col gap-1.5 overflow-y-auto">
                            @if(auth()->user()->isAdmin())
                                <div class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Admin Control</div>
                                
                                <a href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.equipment') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.equipment*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Equipment Inventory
                                </a>
                                <a href="{{ route('admin.categories') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.categories') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Categories
                                </a>
                                <a href="{{ route('admin.requests') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.requests') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Booking Requests
                                </a>
                                <a href="{{ route('admin.issued') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.issued') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Issued Equipment
                                </a>
                                <a href="{{ route('admin.overdue') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.overdue') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Overdue Tracking
                                </a>
                                <a href="{{ route('admin.bookings') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.bookings') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    All Bookings
                                </a>
                                <a href="{{ route('admin.fines') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.fines') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Fines Management
                                </a>
                                <a href="{{ route('admin.users') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.users') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Students / Users
                                </a>
                                <a href="{{ route('admin.damage_reports') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.damage_reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Damage Reports
                                </a>
                                <a href="{{ route('admin.reports') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Statistical Reports
                                </a>
                            @else
                                <div class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Student Menu</div>
                                
                                <a href="{{ route('student.dashboard') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('student.equipment') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.equipment*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Available Equipment
                                </a>
                                <a href="{{ route('student.bookings.create') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.bookings.create') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Book Equipment
                                </a>
                                <a href="{{ route('student.bookings') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.bookings') && !request()->routeIs('student.bookings.create') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    My Bookings
                                </a>
                                <a href="{{ route('student.fines') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.fines') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    My Fines
                                </a>
                                <a href="{{ route('student.damage_reports') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.damage_reports') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Damage Reports
                                </a>
                                <a href="{{ route('student.profile') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('student.profile') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    Profile
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-x-hidden">
                <div class="mx-auto max-w-7xl">
                    @include('layouts.flash')
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        <!-- Guest View Content Shell -->
        <main class="min-h-[calc(100vh-64px)] w-full flex items-center justify-center p-4 sm:p-6 md:p-8">
            <div class="w-full max-w-7xl">
                @include('layouts.flash')
                @yield('content')
            </div>
        </main>
    @endauth
</body>
</html>

