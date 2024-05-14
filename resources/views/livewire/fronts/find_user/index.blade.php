<?php

use App\Livewire\Forms\ResetPasswordForm;
use function Livewire\Volt\{state, mount, form, title};
use App\Models\User;

title("Lihat Lokasi Anggota keluarga");

state([
    'spph',
    'phone',
    "data_not_found"
]);

$search = function() {
    // Replace 08 with 628 on first character
    $this->phone = preg_replace('/^08/', '628', $this->phone);
    $data = User::where('spph', $this->spph)->where('phone', $this->phone)->first();
    if ($data) {
        return $this->redirectRoute('find_user.maps', navigate:false, parameters: [
                'spph' => $this->spph,
                'phone' => $this->phone
            ]);
    } else {
        $this->data_not_found = true;
    }
};

?>

<div>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            {{ config('app.name') }}
        </a>
        <div class="w-full p-6 rounded-lg shadow dark:border md:mt-0 sm:max-w-md sm:p-8">
            <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Lihat Lokasi Anggota keluarga
            </h2>
            <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="search">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">No SPPH / No Haji</span>
                    </div>
                    <input type="spph" class="input input-bordered w-full" required wire:model='spph'/>
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">No Telepon</span>
                    </div>
                    <input type="phone" class="input input-bordered w-full" required wire:model='phone'/>
                </label>
                @if ($this->data_not_found)
                    <div role="alert" class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Data tidak ditemukan!</span>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-block ">Cari</button>
            </form>
        </div>
    </div>
</div>
