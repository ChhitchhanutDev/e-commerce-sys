<header class="sticky top-0 z-40 border-b border-l border-slate-200 bg-white">
    <div class="flex items-center justify-between px-6 py-5">
        <div>
            <h1 class="text-xl font-semibold tracking-tight text-slate-800">Admin Panel</h1>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative" x-data="{
                notifications: [],
                showNotify: false,
                get count() { return this.notifications.length; },
                init() {
                    if (typeof window.Echo !== 'undefined') {
                        window.Echo.channel('orders')
                            .listen('.App\\Events\\NewOrder', (e) => {
                                this.notifications.unshift({
                                    id: e.id,
                                    customer: e.customer,
                                    total: e.total,
                                    time: new Date().toLocaleTimeString(),
                                });
                            });
                    }
                },
                toggle() {
                    this.showNotify = !this.showNotify;
                    if (this.showNotify) this.notifications = [];
                }
            }">
                <button type="button" @click="toggle()"
                    class="relative flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <span x-show="count > 0" x-text="count"
                        class="absolute -right-1 -top-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-400 px-1 text-[11px] font-bold leading-none text-white"
                        style="display: none;"></span>
                </button>

                <div x-show="showNotify" @click.away="showNotify = false"
                    x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 z-50 mt-2 w-72 origin-top-right rounded-lg border border-slate-200 bg-white shadow-lg"
                    style="display: none;">
                    <div class="border-b border-slate-200 px-4 py-3">
                        <p class="text-sm font-semibold text-slate-800">Notifications</p>
                    </div>

                    <div class="max-h-64 overflow-y-auto">
                        <template x-if="notifications.length === 0">
                            <p class="px-4 py-6 text-center text-sm text-slate-400">No new notifications.</p>
                        </template>

                        <template x-for="n in notifications" :key="n.id">
                            <a :href="'/orders/' + n.id"
                                class="block border-b border-slate-100 px-4 py-3 transition hover:bg-slate-50">
                                <p class="text-sm font-medium text-slate-800"
                                    x-text="'Order #' + n.id + ' — ' + n.customer"></p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    <span x-text="'$' + n.total"></span>
                                    <span x-text="' — ' + n.time"></span>
                                </p>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-lg border border-slate-200 bg-white shadow-lg"
                    style="display: none;">
                    <a href="{{ route('profile') }}"
                        class="block px-4 py-2.5 text-sm text-slate-700 transition hover:bg-slate-50">
                        Profile
                    </a>

                    <hr class="border-slate-200">

                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full px-4 py-2.5 text-left text-sm text-slate-700 transition hover:bg-slate-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
