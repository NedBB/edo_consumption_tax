<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

new class extends Component {

    public string $rin = '';
    public string $password = '';
    public bool $remember = false;

    public function rules()
    {
        return [
            'rin' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function login()
    {
        $validated = $this->validate();

        if (Auth::guard('taxpayer')->attempt([
            'rin' => $validated['rin'],
            'password' => $validated['password'],
        ], $this->remember)) {
            return redirect()->intended('/dashboard/tax-payer');
        }

        $this->addError('rin', 'Invalid credentials.');
    }

    public function render():View
    {
        return view('livewire.taxpayerlogin')
                ->layout('layouts.app-plain');
    }

}; ?>

<div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="../../assets/img/illustrations/auth-login-illustration-light.png"
              alt="auth-login-cover"
              class="img-fluid my-5 auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />

            <img
              src="../../assets/img/illustrations/bg-shape-image-light.png"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
         <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            <h3 class="mb-1">Welcome to Tax Payer 👋</h3>
            <p class="mb-4">Please sign-in to your account</p>
            <form wire:submit="login">
                <div class="mb-3">
                    <label for="email" class="form-label">RIN</label>
                    <input wire:model="rin" name="rin" type="text" class="form-control" placeholder="RIN" required>
                    @error('rin') <span>{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>

                </div>
                <div class="input-group input-group-merge">
                    <input wire:model="password" name="password" class="form-control"  type="password" placeholder="Password" required>
                    @error('password') <span>{{ $message }}</span> @enderror

                </div>
                </div>

                <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>
          </div>
        </div>
    </div>
</div>
