<x-app-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">
            Dashboard
        </h1>

        <p class="mt-1 text-slate-500">
            Overview of CLT supplier and layup management.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Total Suppliers
            </div>

            <div class="mt-3 text-4xl font-bold text-slate-900">
                {{ $stats['suppliers'] }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Total Layups
            </div>

            <div class="mt-3 text-4xl font-bold text-slate-900">
                {{ $stats['layups'] }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Total Layers
            </div>

            <div class="mt-3 text-4xl font-bold text-slate-900">
                {{ $stats['layers'] }}
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                Recent Suppliers
            </h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($recentSuppliers as $supplier)
                <div class="flex items-center justify-between px-6 py-5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr($supplier->name, 0, 2)) }}
                        </div>

                        <div>
                            <div class="font-semibold text-slate-900">
                                {{ $supplier->name }}
                            </div>

                            <div class="text-sm text-slate-500">
                                Created {{ $supplier->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('suppliers.show', $supplier) }}"
                       class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
                        View
                    </a>
                </div>
            @empty
                <div class="px-6 py-16 text-center text-slate-500">
                    No suppliers available.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>