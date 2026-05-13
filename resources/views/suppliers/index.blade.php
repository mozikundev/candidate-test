<x-app-layout>
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Suppliers
            </h1>

            <p class="mt-1 text-slate-500">
                Manage timber suppliers and material sourcing.
            </p>
        </div>

        <a href="{{ route('suppliers.create') }}"
           class="inline-flex items-center rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">
            + Add Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <form method="GET" action="{{ route('suppliers.index') }}" class="w-full max-w-sm">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search suppliers by name..."
                class="w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
            >
        </form>

        <div class="flex items-center gap-3">
            <button type="button"
                    class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-600 shadow-sm hover:bg-slate-50">
                Filter
            </button>

            <button type="button"
                    class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-600 shadow-sm hover:bg-slate-50">
                Export
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Name
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Total Layups
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Created At
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($suppliers as $supplier)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700 ring-1 ring-emerald-100">
                                    {{ strtoupper(substr($supplier->name, 0, 2)) }}
                                </div>

                                <div>
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                       class="font-semibold text-slate-900 hover:text-emerald-700">
                                        {{ $supplier->name }}
                                    </a>

                                    <div class="text-sm text-slate-500">
                                        ID: SUP-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600">
                            {{ $supplier->clt_layups_count }}
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600">
                            {{ $supplier->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('suppliers.show', $supplier) }}"
                                   class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
                                    View
                                </a>

                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>

                                <form action="{{ route('suppliers.destroy', $supplier) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this supplier?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-sm font-medium text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-slate-500">
                            No suppliers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</x-app-layout>