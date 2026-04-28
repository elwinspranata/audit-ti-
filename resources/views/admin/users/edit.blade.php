<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-700 dark:text-sky-300">Edit User</h2>
            {{-- Optional breadcrumb --}}
            {{-- @if (Breadcrumbs::has())
                {{ Breadcrumbs::render('users.edit', $user) }}
            @endif --}}
        </div>
    </x-slot>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <div
                class="p-6 bg-white border shadow-xl border-sky-400 rounded-xl dark:bg-slate-800/70 dark:border-sky-700/30 animate-fadeInUp">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700/80 dark:border-slate-600 dark:text-slate-200" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700/80 dark:border-slate-600 dark:text-slate-200" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-200">
                            Password Baru <span class="text-xs font-normal text-gray-500">(kosongkan jika tidak
                                diubah)</span>
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700/80 dark:border-slate-600 dark:text-slate-200" />
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="mb-4">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700/80 dark:border-slate-600 dark:text-slate-200" />
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label for="role"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200">Role</label>
                        <select name="role" id="role"
                            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700/80 dark:border-slate-600 dark:text-slate-200">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(old('role', $user->role) == $role)>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('users.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
