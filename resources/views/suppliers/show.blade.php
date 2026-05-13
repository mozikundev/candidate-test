<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">
        <div class="flex items-start justify-between mb-8">
            <div>
                <a href="{{ route('suppliers.index') }}" class="text-sm text-slate-500 hover:text-emerald-700">
                    ← Back to suppliers
                </a>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $supplier->name }}
                </h1>

                <p class="mt-1 text-slate-500">
                    Supplier details and CLT layups.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('suppliers.export', $supplier) }}"
                class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Export JSON
                </a>

                <form action="{{ route('suppliers.import', $supplier) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="flex items-center gap-2">
                    @csrf

                    <input
                        type="file"
                        name="file"
                        accept=".json,application/json"
                        class="block w-52 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200"
                        required
                    >

                    <button type="submit"
                            class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">
                        Import
                    </button>
                </form>

                <a href="{{ route('suppliers.layups.create', $supplier) }}"
                class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800">
                    + Add Layup
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('conflictReports') && count(session('conflictReports')) > 0)
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-6">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-amber-900">
                        Import Conflict Report
                    </h2>

                    <p class="mt-1 text-sm text-amber-700">
                        Conflicts were detected and resolved using the overwrite existing strategy.
                    </p>
                </div>

                <div class="space-y-4">
                    @foreach(session('conflictReports') as $report)
                        <div class="rounded-xl border border-amber-200 bg-white p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="font-semibold text-slate-900">
                                        Layup: {{ $report['layup'] }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        Layer Order: {{ $report['layer_order'] }}
                                    </div>
                                </div>

                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                    {{ $report['strategy'] }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <h3 class="mb-2 text-sm font-semibold text-slate-700">
                                        Existing Version
                                    </h3>

                                    <div class="space-y-1 text-sm text-slate-600">
                                        <div>Thickness: {{ $report['existing']['thickness'] }}</div>
                                        <div>Width: {{ $report['existing']['width'] }}</div>
                                        <div>Angle: {{ $report['existing']['angle'] }}</div>
                                    </div>
                                </div>

                                <div class="rounded-lg bg-emerald-50 p-4">
                                    <h3 class="mb-2 text-sm font-semibold text-emerald-800">
                                        Incoming Version
                                    </h3>

                                    <div class="space-y-1 text-sm text-emerald-700">
                                        <div>Thickness: {{ $report['incoming']['thickness'] }}</div>
                                        <div>Width: {{ $report['incoming']['width'] }}</div>
                                        <div>Angle: {{ $report['incoming']['angle'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @error('file')
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Layers</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($supplier->cltLayups as $layup)
                        <tr>
                            <td class="px-6 py-5 font-semibold text-slate-900">
                                {{ $layup->name }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $layup->clt_layers_count ?? $layup->cltLayers->count() }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('suppliers.layups.show', [$supplier, $layup]) }}"
                                       class="text-sm font-medium text-emerald-700">View</a>

                                    <a href="{{ route('suppliers.layups.edit', [$supplier, $layup]) }}"
                                       class="text-sm font-medium text-blue-600">Edit</a>

                                    <form method="POST"
                                          action="{{ route('suppliers.layups.destroy', [$supplier, $layup]) }}"
                                          onsubmit="return confirm('Delete this layup?')">
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
                            <td colspan="3" class="px-6 py-16 text-center text-slate-500">
                                No layups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>