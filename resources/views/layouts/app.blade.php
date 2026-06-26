<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>@yield('title', 'Vandy\'s Store')</title>

    @include('partials.assets')
</head>
<body class="h-screen overflow-hidden bg-slate-100 text-slate-900 antialiased">
    <div class="flex h-screen">
        @include('partials.sidebar')

        <div class="flex min-w-0 flex-1 flex-col overflow-y-auto">
            @include('partials.page-header')

            <main class="flex-1 px-6 py-8">
                <div class="mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
