<aside class="flex w-72 shrink-0 flex-col bg-slate-950 text-white">
    <div class="border-b border-white/10 px-6 py-5">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-tight">
            Admin Panel
        </a>
    </div>

    <nav class="flex-1 space-y-1 px-4 py-6" aria-label="Main navigation">
        <x-ui.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('cate.list')" :active="request()->routeIs('cate.*')">
            Categories
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('product.list')" :active="request()->routeIs('product.*')">
            Products
        </x-ui.nav-link>
    </nav>

    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-950"
            >
                Logout
            </button>
        </form>
    </div>
</aside>
