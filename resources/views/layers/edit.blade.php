<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-slate-900">Edit Layer</h1>
        <p class="mt-1 mb-8 text-slate-500">
            Update layer from {{ $layup->name }}.
        </p>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">
            <form method="POST" action="{{ route('suppliers.layups.layers.update', [$supplier, $layup, $layer]) }}">
                @csrf
                @method('PUT')

                @include('layers._form')
            </form>
        </div>
    </div>
</x-app-layout>