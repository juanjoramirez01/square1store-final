<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <main class="flex-1 flex-col justify-items-center">
        <div class="w-full py-12 px-4 sm:px-6 lg:px-8 max-w-7xl">
            <h2 class="text-black font-normal text-3xl md:text-5xl text-left font-volkhov md:py-8 py-6">
                {{__('Login to your account')}}
            </h2>
            <div class="mx-auto space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>