<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">
                Create Supplier
            </h1>

            <p class="mt-1 text-slate-500">
                Add a new CLT supplier.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">
            <form
                action="{{ route('suppliers.store') }}"
                method="POST"
            >
                @include('suppliers._form')
            </form>
        </div>
    </div>
</x-app-layout>