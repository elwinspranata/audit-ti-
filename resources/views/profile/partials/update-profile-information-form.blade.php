<section {{-- Jika section ini adalah panelnya langsung, tambahkan kelas styling di sini.
Jika dibungkus div lain di profile.edit.blade.php, kelas panel ada di div tersebut.
Saya akan tambahkan kelas panel di sini untuk kelengkapan jika ini adalah unit yang berdiri sendiri. --}}
    class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 {{-- animate-fadeInUp (jika dianimasikan) --}}">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-sky-300">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>

        {{-- Notifikasi Jika Profil Belum Lengkap --}}
        @php
            $currentUser = Auth::user();
            $profileIsIncomplete =
                empty($currentUser->phone_number) ||
                empty($currentUser->company_name) ||
                empty($currentUser->department);
        @endphp

        @if ($profileIsIncomplete)
            <div class="mt-6 p-4 text-sm rounded-lg text-amber-700 bg-amber-100 dark:bg-amber-600/20 dark:text-amber-300 border border-amber-500/40 {{-- animate-fadeInDown (jika dianimasikan) --}}"
                role="alert">
                <span class="font-bold">Perhatian!</span> Data profil Anda belum lengkap. Mohon lengkapi Nomor HP, Nama
                Perusahaan, dan Bagian Unit Kerja untuk fungsionalitas penuh.
            </div>
        @endif
        {{-- Akhir Notifikasi --}}
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button form="send-verification"
                            class="text-sm underline transition-colors duration-150 rounded-md text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-800">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Nomor HP --}}
        <div>
            <x-input-label for="phone_number" :value="__('Nomor HP')" />
            <x-text-input id="phone_number" name="phone_number" type="tel" class="block w-full mt-1"
                :value="old('phone_number', $user->phone_number)" autocomplete="tel" placeholder="Contoh: 08123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        {{-- Nama Perusahaan --}}
        <div>
            <x-input-label for="company_name" :value="__('Nama Perusahaan')" />
            <x-text-input id="company_name" name="company_name" type="text" class="block w-full mt-1"
                :value="old('company_name', $user->company_name)" autocomplete="organization" placeholder="Nama perusahaan Anda" />
            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>

        {{-- Bagian Unit Kerja --}}
        <div>
            <x-input-label for="department" :value="__('Bagian Unit Kerja')" />
            <x-text-input id="department" name="department" type="text" class="block w-full mt-1" :value="old('department', $user->department)"
                autocomplete="organization-title" placeholder="Departemen atau unit kerja" />
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div class="flex items-center gap-6 pt-2">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90" x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 dark:text-emerald-400">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
