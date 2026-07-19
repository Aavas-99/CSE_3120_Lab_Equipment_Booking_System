@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Manage Categories</h1>
    <p class="mt-1 text-sm text-slate-500">Group laboratory equipment by department field, utility, or equipment category types.</p>
</div>

<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <!-- Add Category Form -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1 h-fit">
        <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Add Category</h2>
        
        <form method="post" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Category Name</label>
                <input type="text" name="name" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. Electrical Instruments">
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="Brief details about equipment under this category..."></textarea>
            </div>
            
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Save Category
            </button>
        </form>
    </div>

    <!-- Categories List Table -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
        <h2 class="text-base font-bold text-slate-900 mb-5">Registered Categories</h2>
        
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 bg-white text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Stock Types</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($categories as $category)
                        <tr class="transition hover:bg-slate-50">
                            <!-- Update Form -->
                            <form id="update-category-{{ $category->id }}" method="post" action="{{ route('admin.categories.update', $category) }}">
                                @csrf 
                                @method('put')
                            </form>
                            
                            <td class="whitespace-nowrap px-6 py-3 font-semibold text-slate-900">
                                <input form="update-category-{{ $category->id }}" name="name" value="{{ $category->name }}" required class="rounded border border-slate-300 px-2 py-1 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 w-44 bg-transparent hover:bg-white focus:bg-white">
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">
                                <input form="update-category-{{ $category->id }}" name="description" value="{{ $category->description }}" class="rounded border border-slate-300 px-2 py-1 text-sm text-slate-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 w-64 bg-transparent hover:bg-white focus:bg-white">
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium text-slate-500">
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-700">
                                    {{ $category->equipment_count }} items
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-xs">
                                <div class="flex items-center justify-end gap-2">
                                    <button form="update-category-{{ $category->id }}" type="submit" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                        Update
                                    </button>
                                    <form method="post" action="{{ route('admin.categories.delete', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category? All associated equipment items will lose their classification.');">
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 font-bold text-rose-700 transition hover:bg-rose-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                No categories created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

