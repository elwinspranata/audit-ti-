<section class="space-y-6">
    <header class="mb-6"> {{-- Tambah margin bawah pada header --}}
        <h2 class="text-2xl font-bold text-gray-800 dark:text-red-400">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button {{-- Gunakan komponen danger button yang sudah di-styling --}}
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun Saya') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        {{-- Panel Modal di-styling di sini atau di dalam komponen x-modal --}}
        <div class="p-6 sm:p-8 bg-white dark:bg-gradient-to-br dark:from-slate-800 dark:to-red-950/80 dark:border dark:border-red-700/60 rounded-xl shadow-2xl">
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <h2 class="text-xl font-bold text-gray-800 dark:text-red-300">
                    {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password_delete_confirm" value="{{ __('Kata Sandi') }}" class="sr-only" /> {{-- Ganti ID jika bentrok --}}
                    <x-text-input
                        id="password_delete_confirm" {{-- Ganti ID jika bentrok --}}
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4" {{-- Atau w-full --}}
                        placeholder="{{ __('Kata Sandi') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button class="sm:ms-3"> {{-- ms-3 jika di baris yang sama --}}
                        {{ __('Hapus Akun Saya') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
