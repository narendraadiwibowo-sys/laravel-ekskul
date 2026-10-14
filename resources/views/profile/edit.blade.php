<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="card" style="background:#1e293b; border:1px solid #334155; border-radius:14px; padding:2rem;">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card" style="background:#1e293b; border:1px solid #334155; border-radius:14px; padding:2rem;">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card" style="background:#1e293b; border:1px solid #334155; border-radius:14px; padding:2rem;">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
