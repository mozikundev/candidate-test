<x-app-layout>
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('suppliers.layups.show', [$supplier, $layup]) }}"
               class="text-xs font-medium text-slate-500 hover:text-emerald-700">
                ← Back to layup
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Edit Layer
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update layer data for {{ $layup->name }}.
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('suppliers.layups.layers.update', [$supplier, $layup, $layer]) }}">
                @csrf
                @method('PUT')

                @include('layers._form')
            </form>
        </div>
    </div>
</x-app-layout>