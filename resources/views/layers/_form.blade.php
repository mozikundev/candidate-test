@csrf

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Layer Order
        </label>

        <input
            type="number"
            name="layer_order"
            value="{{ old('layer_order', $layer->layer_order ?? '') }}"
            placeholder="1"
            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
        >

        @error('layer_order')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Thickness
        </label>

        <input
            type="number"
            step="0.01"
            name="thickness"
            value="{{ old('thickness', $layer->thickness ?? '') }}"
            placeholder="12.00"
            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
        >

        @error('thickness')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Width
        </label>

        <input
            type="number"
            step="0.01"
            name="width"
            value="{{ old('width', $layer->width ?? '') }}"
            placeholder="100.00"
            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
        >

        @error('width')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Angle
        </label>

        <input
            type="number"
            step="0.01"
            name="angle"
            value="{{ old('angle', $layer->angle ?? '') }}"
            placeholder="45.00"
            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
        >

        @error('angle')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit"
            class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        Save Layer
    </button>

    <a href="{{ route('suppliers.layups.show', [$supplier, $layup]) }}"
       class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
        Cancel
    </a>
</div>