@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="mb-5">
        <a href="{{ route('admin.equipment') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            &larr; Back to Inventory
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ $equipment->exists ? 'Edit Equipment Specifications' : 'Add New Equipment' }}</h2>
                <p class="text-xs text-slate-500">Specify details, serial code, stock levels, and laboratory alignment</p>
            </div>
        </div>

        <form method="post" action="{{ $equipment->exists ? route('admin.equipment.update', $equipment) : route('admin.equipment.store') }}" class="space-y-6">
            @csrf
            @if($equipment->exists) 
                @method('put') 
            @endif
            
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Category</label>
                    <select name="category_id" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $equipment->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Equipment Name</label>
                    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. Digital Oscilloscope">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Serial Number</label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. KUET-EEE-DS-041">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Storage Location</label>
                    <input type="text" name="location" value="{{ old('location', $equipment->location) }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. VLSI Lab, Room 302">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Total Quantity</label>
                    <input type="number" min="1" name="quantity" value="{{ old('quantity', $equipment->exists ? $equipment->quantity : 1) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Available Quantity</label>
                    <input type="number" min="0" name="available_quantity" value="{{ old('available_quantity', $equipment->exists ? $equipment->available_quantity : 1) }}" required class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Status</label>
                    <select name="status" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        @foreach(\App\Models\Equipment::STATUSES as $status)
                            <option @selected(old('status', $equipment->status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Image URL / Path <span class="text-slate-400 font-normal">(Optional)</span></label>
                    <input type="text" name="image" value="{{ old('image', $equipment->image) }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="e.g. img/oscilloscope.jpg">
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Description Specification</label>
                <textarea name="description" rows="4" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500" placeholder="Provide extra specifications or requirements for using this instrument...">{{ old('description', $equipment->description) }}</textarea>
            </div>
            
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.equipment') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Cancel</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save Equipment Info
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

