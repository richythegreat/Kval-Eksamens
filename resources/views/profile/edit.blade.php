<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-900 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-10 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                {{-- Profile Info --}}
                <div>
                    @includeFirst([
                        'profile.update-profile-information-form',
                        'profile.partials.update-profile-information-form'
                    ])
                </div>

                {{-- Update Password --}}
                <div>
                    @includeFirst([
                        'profile.update-password-form',
                        'profile.partials.update-password-form'
                    ])
                </div>

                {{-- Delete Account (full width) --}}
                <div class="lg:col-span-2">
                    @includeFirst([
                        'profile.delete-user-form',
                        'profile.partials.delete-user-form'
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
