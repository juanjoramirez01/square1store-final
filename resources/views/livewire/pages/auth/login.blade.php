<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect('/', navigate: true);
    }

}; ?>
<main class="flex-1 flex-col justify-items-center">
    <div class="w-full px-8 max-w-7xl flex-1 flex-col">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="text-black font-normal text-3xl md:text-5xl text-left font-volkhov md:py-8 py-6">
            {{__('Login to your account')}}
        </h2>

        <div class="font-poppins pb-4">
            <span class="text-sm text-gray-600">{{ __("Don't have an account?") }}</span>
            <a class="underline text-sm text-gray-600 hover:text-red-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('register') }}" wire:navigate>
                {{ __('Register') }}
            </a>
        </div>

        <form wire:submit="login">
            <!-- Email Address -->
            <div class="font-poppins">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full max-w-[60rem]" type="email" name="email" required autofocus autocomplete="username" placeholder="name@email.com"/>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 font-poppins">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input wire:model="form.password" id="password" placeholder="{{__('Your password')}}" class="block mt-1 w-full max-w-[60rem]"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 font-poppins">
                <label for="remember" class="inline-flex items-center ">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4 font-poppins">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-red-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 bg-black hover:bg-red-600">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</main>
