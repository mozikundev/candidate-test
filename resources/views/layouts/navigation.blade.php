<nav x-data="{ open: false }" class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-700 text-sm font-bold text-white">
                        CLT
                    </div>

                    <div>
                        <div class="text-lg font-bold leading-tight text-slate-900">
                            CLT Manager
                        </div>
                        <div class="text-xs text-slate-500">
                            Engineering Admin
                        </div>
                    </div>
                </a>

                <div class="hidden md:flex h-16 items-center gap-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                        Suppliers
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <div class="text-right">
                    <div class="text-sm font-semibold text-slate-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-xs text-slate-500">
                        administrator
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-600 shadow-sm hover:bg-slate-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>