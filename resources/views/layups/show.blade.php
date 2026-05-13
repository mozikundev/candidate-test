<x-app-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <a href="{{ route('suppliers.show', $supplier) }}"
               class="text-xs font-medium text-slate-500 hover:text-emerald-700">
                ← Back to supplier
            </a>

            <div class="mt-1 flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $layup->name }}
                </h1>

                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                    {{ $layup->cltLayers->count() }} Layers
                </span>
            </div>

            <p class="mt-1 text-sm text-slate-500">
                Layer composition for {{ $supplier->name }}.
            </p>
        </div>

        <a href="{{ route('suppliers.layups.layers.create', [$supplier, $layup]) }}"
           class="rounded-lg bg-emerald-700 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
            + Add Layer
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Order
                    </th>
                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Thickness
                    </th>
                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Width
                    </th>
                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Angle
                    </th>
                    <th class="px-4 py-3 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($layup->cltLayers->sortBy('layer_order') as $layer)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">
                                {{ $layer->layer_order }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $layer->thickness }}
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $layer->width }}
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $layer->angle }}°
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3 text-sm">
                                <a href="{{ route('suppliers.layups.layers.edit', [$supplier, $layup, $layer]) }}"
                                   class="font-medium text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('suppliers.layups.layers.destroy', [$supplier, $layup, $layer]) }}"
                                      onsubmit="return confirm('Delete this layer?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="font-medium text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="px-4 py-10 text-center text-sm text-slate-500">
                            No layers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>