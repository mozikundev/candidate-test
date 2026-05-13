<x-app-layout>
    <div class="mb-5 flex items-center justify-between">
        <div>
            <a href="{{ route('suppliers.show', $supplier) }}"
               class="text-xs font-medium text-slate-500 hover:text-emerald-700">
                ← Back to supplier
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Resolve Import Conflicts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Choose whether to keep existing data or accept incoming data for each conflict.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('suppliers.import.resolve', $supplier) }}">
        @csrf

        <div class="space-y-4">
            @foreach($conflicts as $index => $conflict)
                <div class="rounded-xl border border-amber-200 bg-white p-4 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">
                                {{ $conflict['layup_name'] }}
                            </div>

                            <div class="text-sm text-slate-500">
                                Layer Order: {{ $conflict['layer_order'] }}
                            </div>
                        </div>

                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            {{ $index + 1 }} of {{ count($conflicts) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="cursor-pointer rounded-lg border border-slate-200 bg-slate-50 p-4 hover:border-slate-400">
                            <div class="mb-3 flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="resolutions[{{ $conflict['key'] }}]"
                                    value="existing"
                                    class="text-emerald-700 focus:ring-emerald-600"
                                    checked
                                >

                                <span class="text-sm font-semibold text-slate-800">
                                    Keep Existing
                                </span>
                            </div>

                            <div class="space-y-1 text-sm text-slate-600">
                                <div>Thickness: {{ $conflict['existing']['thickness'] }}</div>
                                <div>Width: {{ $conflict['existing']['width'] }}</div>
                                <div>Angle: {{ $conflict['existing']['angle'] }}</div>
                            </div>
                        </label>

                        <label class="cursor-pointer rounded-lg border border-emerald-200 bg-emerald-50 p-4 hover:border-emerald-500">
                            <div class="mb-3 flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="resolutions[{{ $conflict['key'] }}]"
                                    value="incoming"
                                    class="text-emerald-700 focus:ring-emerald-600"
                                >

                                <span class="text-sm font-semibold text-emerald-800">
                                    Accept Incoming
                                </span>
                            </div>

                            <div class="space-y-1 text-sm text-emerald-700">
                                <div>Thickness: {{ $conflict['incoming']['thickness'] }}</div>
                                <div>Width: {{ $conflict['incoming']['width'] }}</div>
                                <div>Angle: {{ $conflict['incoming']['angle'] }}</div>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                Apply Resolutions
            </button>

            <a href="{{ route('suppliers.show', $supplier) }}"
               class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Cancel
            </a>
        </div>
    </form>
</x-app-layout>