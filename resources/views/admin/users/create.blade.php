<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            {{-- Breadcrumb --}}
            <a href="{{ route('users.index') }}" class="text-sky-500 hover:text-sky-600">Users</a>
            <span class="text-gray-400">/</span>
            <span class="font-semibold text-gray-800 dark:text-gray-200">Tambah User Baru</span>
        </div>
    </x-slot>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl rounded-2xl dark:bg-slate-800">

                <div
                    class="px-6 py-6 border-b border-gray-200 dark:border-slate-700 bg-gradient-to-r from-sky-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-sky-300">Form Tambah User</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400">Isi detail di bawah ini untuk membuat akun
                        pengguna baru.</p>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name"
                                class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Nama
                                Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                autofocus autocomplete="name" placeholder="John Doe"
                                class="block w-full px-4 py-3 mt-1 text-sm transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder-slate-400" />
                            @error('name')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email"
                                class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Alamat
                                Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autocomplete="username" placeholder="user@example.com"
                                class="block w-full px-4 py-3 mt-1 text-sm transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder-slate-400" />
                            @error('email')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="role"
                                class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Role</label>
                            <select id="role" name="role" required
                                class="block w-full px-4 py-3 mt-1 text-sm transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password"
                                    class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Password</label>
                                <input id="password" name="password" type="password" required
                                    autocomplete="new-password" placeholder="Minimal 8 karakter"
                                    class="block w-full px-4 py-3 mt-1 text-sm transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder-slate-400" />
                                @error('password')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Konfirmasi
                                    Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    autocomplete="new-password" placeholder="Ulangi password"
                                    class="block w-full px-4 py-3 mt-1 text-sm transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder-slate-400" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t dark:border-slate-700">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform shadow-lg rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/30 hover:scale-105 group">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
