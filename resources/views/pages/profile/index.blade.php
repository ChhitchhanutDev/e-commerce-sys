@extends('layouts.app')


@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card class="p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xl font-bold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="mt-8 grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Role</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">
                    <span @class([
                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-purple-100 text-purple-700' => $user->role === 'admin',
                        'bg-blue-100 text-blue-700' => $user->role === 'user',
                    ])>
                        {{ ucfirst($user->role) }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Member Since</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">
                    {{ $user->created_at->format('F j, Y') }}
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email Verified</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">
                    {{ $user->email_verified_at ? $user->email_verified_at->format('F j, Y') : 'Not verified' }}
                </dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap gap-3">
            <div x-data="{ open: false }">
                <x-ui.button type="button" @click="open = !open" variant="primary">
                    <span x-show="!open">Update Profile</span>
                    <span x-show="open" style="display: none;">Cancel</span>
                </x-ui.button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="mt-6"
                    style="display: none;"
                >
                    <x-ui.card class="p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Update Profile</h2>
                        <p class="mt-1 text-sm text-slate-500">Change your name and email address.</p>

                        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-4" novalidate>
                            @csrf
                            @method('PUT')

                            <x-ui.form-field name="name" label="Name" :value="old('name', $user->name)" required />
                            <x-ui.form-field name="email" label="Email Address" type="email" :value="old('email', $user->email)" required />

                            <x-ui.button type="submit">
                                Save Changes
                            </x-ui.button>
                        </form>
                    </x-ui.card>
                </div>
            </div>

            <div x-data="{ open: false }">
                <x-ui.button type="button" @click="open = !open" variant="warning">
                    <span x-show="!open">Change Password</span>
                    <span x-show="open" style="display: none;">Cancel</span>
                </x-ui.button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="mt-6"
                    style="display: none;"
                >
                    <x-ui.card class="p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Change Password</h2>
                        <p class="mt-1 text-sm text-slate-500">Use a strong password you don't use elsewhere.</p>

                        <form method="POST" action="{{ route('profile.password') }}" class="mt-6 space-y-4" novalidate>
                            @csrf
                            @method('PUT')

                            <x-ui.form-field name="current_password" label="Current Password" type="password" required />
                            <x-ui.form-field name="password" label="New Password" type="password" required />
                            <x-ui.form-field name="password_confirmation" label="Confirm New Password" type="password" required />

                            <x-ui.button type="submit">
                                Change Password
                            </x-ui.button>
                        </form>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </x-ui.card>
@endsection
