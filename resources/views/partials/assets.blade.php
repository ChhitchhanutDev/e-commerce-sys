@vite(['resources/css/app.css', 'resources/js/app.js'])
@if (app()->environment('local'))
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endif
