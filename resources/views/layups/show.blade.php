<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">
        <div class="flex items-start justify-between mb-8">
            <div>
                <a href="{{ route('suppliers.show', $supplier) }}" class="text-sm text-slate-500 hover:text-emerald-700">
                    ← Back to supplier
                </a>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $layup->name }}
                </h1>

                <p class="mt-1 text-slate-500">
                    Layer composition for {{ $supplier->name }}.
                </p>
            </div>

            <a href="{{ route('suppliers.layups.layers.create', [$supplier, $layup]) }}"
               class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800">
                + Add Layer
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Thickness</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Width</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Angle</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($layup->cltLayers->sortBy('layer_order') as $layer)
                        <tr>
                            <td class="px-6 py-5 font-semibold text-slate-900">
                                {{ $layer->layer_order }}
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $layer->thickness }}
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $layer->width }}
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $layer->angle }}°
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('suppliers.layups.layers.edit', [$supplier, $layup, $layer]) }}"
                                       class="text-sm font-medium text-blue-600">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('suppliers.layups.layers.destroy', [$supplier, $layup, $layer]) }}"
                                          onsubmit="return confirm('Delete this layer?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-sm font-medium text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                No layers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>