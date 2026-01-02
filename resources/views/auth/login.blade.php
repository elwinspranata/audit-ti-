<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Audit Proses TI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-gray-900">

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="grid max-w-screen-xl gap-8 px-4 py-8 mx-auto lg:py-16 lg:grid-cols-2 lg:gap-16">

            <div class="flex flex-col justify-center">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Optimalkan Audit Proses TI untuk Keamanan & Efisiensi
                </h1>
                <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    Kami fokus melakukan audit dan pengawasan proses teknologi informasi untuk mendukung keamanan,
                    kepatuhan, dan pertumbuhan bisnis jangka panjang yang berkelanjutan.
                </p>

            </div>

            <div>
                <div class="w-full p-6 space-y-8 bg-white rounded-lg shadow-xl lg:max-w-xl sm:p-8 dark:bg-gray-800">

                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Masuk ke Akun Anda
                    </h2>

                    <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                                Anda</label>
                            <input id="email" name="email" type="email" required autofocus
                                value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                       dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input id="password" name="password" type="password" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                       dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                            <label for="remember_me"
                                class="block text-sm font-medium text-gray-900 ms-2 dark:text-gray-400">
                                Ingat saya
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                    Lupa password?
                                </a>
                            @endif

                            <button type="submit"
                                class="inline-flex justify-center px-5 py-3 text-base font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                                Masuk
                            </button>
                        </div>

                        <div class="mt-4 text-sm font-medium text-center text-gray-900 dark:text-white">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-blue-600 hover:underline dark:text-blue-500">
                                Daftar Sekarang
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
