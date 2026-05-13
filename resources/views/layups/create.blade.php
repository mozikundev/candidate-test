<x-app-layout>
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('suppliers.show', $supplier) }}"
               class="text-xs font-medium text-slate-500 hover:text-emerald-700">
                ← Back to supplier
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Create Layup
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Add a new CLT layup configuration.
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST"
                  action="{{ route('suppliers.layups.store', $supplier) }}">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Layup Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: L-2023-X"
                        class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button
                        type="submit"
                        class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                        Save Layup
                    </button>

                    <a href="{{ route('suppliers.show', $supplier) }}"
                       class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>