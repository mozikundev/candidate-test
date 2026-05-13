@csrf

<div class="space-y-6">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Supplier Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $supplier->name ?? '') }}"
            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
            placeholder="Enter supplier name"
        >

        @error('name')
            <p class="mt-2 text-sm text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button
            type="submit"
            class="rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800"
        >
            Save Supplier
        </button>

        <a
            href="{{ route('suppliers.index') }}"
            class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50"
        >
            Cancel
        </a>
    </div>
</div>