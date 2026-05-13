<x-app-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <a href="{{ route('suppliers.index') }}"
               class="text-xs font-medium text-slate-500 hover:text-emerald-700">
                ← Back to suppliers
            </a>

            <div class="mt-1 flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $supplier->name }}
                </h1>

                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                    {{ $supplier->cltLayups->count() }} Layups
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('suppliers.import', $supplier) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="flex items-center gap-2">
                @csrf

                <input
                    type="file"
                    name="file"
                    accept=".json,application/json"
                    required
                    class="block rounded-lg border border-slate-300 bg-slate-50 px-2 py-1.5 text-xs text-slate-600 shadow-sm
                           file:mr-3
                           file:rounded-md
                           file:border-0
                           file:bg-white
                           file:px-3
                           file:py-2
                           file:text-xs
                           file:font-semibold
                           file:text-slate-700
                           hover:file:bg-slate-100"
                >

                <button type="submit"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Import
                </button>
            </form>

            <a href="{{ route('suppliers.export', $supplier) }}"
               class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Export
            </a>

            <a href="{{ route('suppliers.layups.create', $supplier) }}"
               class="rounded-lg bg-emerald-700 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                + Add Layup
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('conflictReports') && count(session('conflictReports')) > 0)
        <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 p-3">
            <div class="mb-2 flex items-center justify-between">
                <h2 class="text-sm font-bold text-amber-900">
                    Conflict Resolution Report
                </h2>

                <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800">
                    {{ count(session('conflictReports')) }} Conflicts
                </span>
            </div>

            <div class="space-y-2">
                @foreach(session('conflictReports') as $report)
                    <div class="rounded-lg border border-amber-200 bg-white p-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">
                                    {{ $report['layup'] }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    Layer {{ $report['layer_order'] }}
                                </div>
                            </div>

                            <div class="text-xs text-amber-700">
                                Overwrite Existing
                            </div>
                        </div>

                        <div class="mt-2 grid grid-cols-2 gap-3 text-xs">
                            <div class="rounded bg-slate-50 p-2">
                                <div class="mb-1 font-semibold text-slate-700">
                                    Existing
                                </div>

                                <div>T: {{ $report['existing']['thickness'] }}</div>
                                <div>W: {{ $report['existing']['width'] }}</div>
                                <div>A: {{ $report['existing']['angle'] }}</div>
                            </div>

                            <div class="rounded bg-emerald-50 p-2">
                                <div class="mb-1 font-semibold text-emerald-700">
                                    Incoming
                                </div>

                                <div>T: {{ $report['incoming']['thickness'] }}</div>
                                <div>W: {{ $report['incoming']['width'] }}</div>
                                <div>A: {{ $report['incoming']['angle'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @error('file')
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            {{ $message }}
        </div>
    @enderror

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Name
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Layers
                    </th>

                    <th class="px-4 py-3 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($supplier->cltLayups as $layup)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-900">
                                {{ $layup->name }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $layup->cltLayers->count() }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3 text-sm">
                                <a href="{{ route('suppliers.layups.show', [$supplier, $layup]) }}"
                                   class="font-medium text-emerald-700 hover:text-emerald-900">
                                    View
                                </a>

                                <a href="{{ route('suppliers.layups.edit', [$supplier, $layup]) }}"
                                   class="font-medium text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('suppliers.layups.destroy', [$supplier, $layup]) }}"
                                      onsubmit="return confirm('Delete this layup?')">
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
                        <td colspan="3"
                            class="px-4 py-10 text-center text-sm text-slate-500">
                            No layups found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>