<x-app-layout>
    <div class="max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">
                Create Supplier
            </h1>

            <p class="mt-1 text-slate-500">
                Add a new CLT material supplier.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Supplier Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: Nordic Timber"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-8 flex items-center gap-3">
                    <button
                        type="submit"
                        class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800"
                    >
                        Save Supplier
                    </button>

                    <a href="{{ route('suppliers.index') }}"
                       class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>