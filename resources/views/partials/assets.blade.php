@if (app()->environment('local') && ! file_exists(public_path('hot')) && ! file_exists(public_path('build/manifest.json')))
    <script src="https://cdn.tailwindcss.com"></script>
@else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif
