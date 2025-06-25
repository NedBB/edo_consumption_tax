<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\View\View;

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

        $user = Auth::user();

        $defaultRoutes = [
            'admin' => route('dashboard'),
            'manager' => route('manager.dashboard'),
            'tax-payer' => route('user.dashboard'),
        ];

        $this->redirectIntended(
            default: $defaultRoutes[$user->type] ?? route('user.dashboard'),
            navigate: true
        );

        //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    public function render():View
    {
        return view('livewire.pages.auth.login')
                ->layout('layouts.app-plain');
    }

}; ?>

<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
        <!-- Login -->
        <div class="card">
            <div class="card-body">
                <h4 class="mb-1 pt-2">Welcome to Tax Collection! 👋</h4>
                <p class="mb-4">Please sign-in to your account and start the adventure</p>

                <div>
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form wire:submit="login">
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        {{-- <div class="block mt-4">
                            <label for="remember" class="inline-flex items-center">
                                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div> --}}

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3 btn btn-primary d-grid w-100">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Register -->
    </div>
</div>


