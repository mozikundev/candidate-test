@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Layer Order</label>
        <input type="number" name="layer_order" value="{{ old('layer_order', $layer->layer_order ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('layer_order') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Thickness</label>
        <input type="number" step="0.01" name="thickness" value="{{ old('thickness', $layer->thickness ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('thickness') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Width</label>
        <input type="number" step="0.01" name="width" value="{{ old('width', $layer->width ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('width') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Angle</label>
        <input type="number" step="0.01" name="angle" value="{{ old('angle', $layer->angle ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('angle') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit"
            class="rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">
        Save Layer
    </button>

    <a href="{{ route('suppliers.layups.show', [$supplier, $layup]) }}"
       class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
        Cancel
    </a>
</div>