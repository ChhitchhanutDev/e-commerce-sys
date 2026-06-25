@extends('layouts.guest')

@section('title', 'Admin Login')

@section('content')
    <x-ui.card class="w-full max-w-md p-8">
        <header class="text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Admin Login</h1>
            <p class="mt-2 text-sm text-slate-500">Sign in to manage the store catalog.</p>
        </header>

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}" class="mt-8 space-y-5" novalidate>
            @csrf

            <x-ui.form-field name="email" label="Email Address" type="email" placeholder="admin@example.com" required
                autofocus />

            <x-ui.form-field name="password" label="Password" type="password" placeholder="Enter your password" required />

            <x-ui.button type="submit" class="w-full">
                Login
            </x-ui.button>
        </form>
    </x-ui.card>
@endsection
