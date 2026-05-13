<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-slate-900">Edit Layup</h1>
        <p class="mt-1 mb-8 text-slate-500">Update layup for {{ $supplier->name }}.</p>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">
            <form method="POST" action="{{ route('suppliers.layups.update', [$supplier, $layup]) }}">
                @csrf
                @method('PUT')

                @include('layups._form')
            </form>
        </div>
    </div>
</x-app-layout>