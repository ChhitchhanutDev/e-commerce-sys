<aside class="sticky top-0 flex h-screen w-72 shrink-0 flex-col bg-slate-950 text-slate-700 shadow-sm">
    <div class="border-b border-slate-200 px-6 py-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ Storage::url('logo.png') }}" alt="Logo" class="h-12 w-12 rounded-full object-cover">
            <span class="text-2xl font-medium text-slate-500">Vandy's Store</span>
        </a>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Main navigation">
        <x-ui.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('cate.list')" :active="request()->routeIs('cate.*')">
            Categories
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('product.list')" :active="request()->routeIs('product.*')">
            Products
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('order.list')" :active="request()->routeIs('order.*')">
            Orders
        </x-ui.nav-link>

        <x-ui.nav-link :href="route('user.list')" :active="request()->routeIs('user.*')">
            Users
        </x-ui.nav-link>
    </nav>
</aside>
