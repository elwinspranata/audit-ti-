<section>
    <header class="mb-6"> {{-- Tambah margin bawah pada header --}}
        <h2 class="text-2xl font-bold text-gray-800 dark:text-sky-300">
            {{ __('Ubah Kata Sandi') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_new" :value="__('Kata Sandi Baru')" /> {{-- ID & Name mungkin 'password' bukan 'password_new' di Breeze --}}
            <x-text-input id="password_new" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation_new" :value="__('Konfirmasi Kata Sandi Baru')" /> {{-- ID & Name mungkin 'password_confirmation' --}}
            <x-text-input id="password_confirmation_new" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-6 pt-2">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 dark:text-emerald-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
