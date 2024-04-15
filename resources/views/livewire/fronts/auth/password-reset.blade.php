<?php

use App\Livewire\Forms\ResetPasswordForm;
use function Livewire\Volt\{state, mount, form, title};

form(ResetPasswordForm::class);
title("Reset Password");

state([
    'token' => '',
]);

mount(function() {
    $this->form->email = request()->email;
    $this->form->token = $this->token;
});

$save = function () {
    $this->form->save();
};

?>

<div>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            {{ config('app.name') }}
        </a>
        <div class="w-full p-6 rounded-lg shadow dark:border md:mt-0 sm:max-w-md sm:p-8">
            <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Reset Password Password
            </h2>
            <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="save">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email Anda</span>
                    </div>
                    <input type="email" disabled placeholder="Type here" class="input input-bordered w-full" wire:model="form.email"/>
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Password</span>
                    </div>
                    <input type="password" class="input input-bordered w-full" required wire:model='form.password'/>
                    @error('form.password')
                        <div class="text-red-500 text-xs">{{ $message }}</div>    
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Konfirmasi Password</span>
                    </div>
                    <input type="password" class="input input-bordered w-full" required wire:model='form.password_confirmation'/>
                    @error('form.password_confirmation')
                        <div class="text-red-500 text-xs">{{ $message }}</div>    
                    @enderror
                </label>
                <button type="submit" class="btn btn-primary btn-block ">Reset passwod</button>
            </form>
        </div>
    </div>
</div>
