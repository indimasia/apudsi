<?php

use App\Livewire\Forms\ResetPasswordForm;
use function Livewire\Volt\{state, mount, form, title, rules};
use App\Models\User;

title("Hapus User");
state([
    'email',
    'password',
    'response' => null,
]);

rules([
    'email' => 'required|email',
    'password' => 'required',
]);

$save = function () {
    $this->error_message = null;
    $this->validate();

    // Find Email on Users
    $user = User::where('email', $this->email)->first();

    // Check if User Exist
    if (!$user) {
        $this->response = [
            'message' => 'Email dan kata sandi tidak ditemukan',
            'status' => 'error',
            'success' => false,
        ];
        return;
    }

    // Check if Password Match
    if (!Hash::check($this->password, $user->password)) {
        $this->response = [
            'message' => 'Email dan kata sandi tidak ditemukan',
            'status' => 'error',
            'success' => false,
        ];
        return;
    }

    // Delete User
    $user->delete();

    $this->response = [
        'message' => 'User berhasil dihapus',
        'status' => 'success',
        'success' => true,
    ];
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
                    <input type="email" class="input input-bordered w-full" wire:model="email" />
                    @error('email')
                        <div class="text-red-500 text-xs">{{ $message }}</div>    
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Kata Sandi</span>
                    </div>
                    <input type="password" class="input input-bordered w-full" wire:model='password'/>
                    @error('password')
                        <div class="text-red-500 text-xs">{{ $message }}</div>    
                    @enderror
                </label>
                <label for="confirmation_modal" class="btn btn-error btn-block " wire:loading.attr="disabled">
                    <span wire:loading class="loading loading-spinner loading-sm"></span>
                    Hapus Akun Anda
                </label>
                <input type="checkbox" id="confirmation_modal" class="modal-toggle" />
                <div class="modal" role="dialog">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Apakah Anda yakin menghapus akun anda?</h3>
                        <div class="modal-action justify-center">
                            <label for="confirmation_modal" class="btn">Tidak</label>
                            <button type="submit" class="btn btn-error" @click="document.querySelector('#confirmation_modal').checked = false" >
                                Ya, hapus akun saya
                            </button>
                        </div>
                    </div>
                </div>
                @if ( !empty($response['message']))
                    <div class="toast toast-top toast-center" x-init="
                            setTimeout(() => {
                                $el.remove();
                                window.location.reload();
                            }, 3000);
                        ">
                        <div class="alert {{ $response['success'] ? "alert-success" : "alert-error" }}">
                            <span>{{ $response['message'] }}</span>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
