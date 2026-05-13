<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Suppliers
                </h1>

                <p class="mt-1 text-slate-500">
                    Manage CLT material suppliers.
                </p>
            </div>

            <a
                href="{{ route('suppliers.create') }}"
                class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800"
            >
                + Add Supplier
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
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Name
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Layups
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-5">
                                <div class="font-semibold text-slate-900">
                                    {{ $supplier->name }}
                                </div>
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $supplier->clt_layups_count }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-3">
                                    <a
                                        href="{{ route('suppliers.show', $supplier) }}"
                                        class="text-sm font-medium text-emerald-700 hover:text-emerald-900"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('suppliers.edit', $supplier) }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('suppliers.destroy', $supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this supplier?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-sm font-medium text-red-600 hover:text-red-800"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="3"
                                class="px-6 py-16 text-center text-slate-500"
                            >
                                No suppliers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $suppliers->links() }}
        </div>
    </div>
</x-app-layout>