<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">
                Edit Supplier
            </h1>

            <p class="mt-1 text-slate-500">
                Update supplier information.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">
            <form
                action="{{ route('suppliers.update', $supplier) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                @include('suppliers._form')
            </form>
        </div>
    </div>
</x-app-layout>