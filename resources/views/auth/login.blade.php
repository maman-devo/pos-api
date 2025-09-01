<x-guest-layout>
    <div class="grid grid-cols-1 md:grid-cols-2">
        <!-- Kolom Kiri: Form Login -->
        <div class="flex flex-col justify-center p-8 md:p-12">
            <div class="w-full">
                <!-- Logo dipindahkan ke tengah -->
                <a href="/" class="flex items-center justify-center mb-6">
                    <img src="{{ asset('images/logo_icon.png') }}" class="block h-8 w-auto" alt="Logo Aplikasi">
                </a>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">Welcome Back!</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 text-center">
                    Halo, Bagaimana kabarmu?

                </p>

                <!-- Session Status -->
                <x-auth-session-status class="my-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <x-text-input id="email" class="block w-full pl-10" type="email" name="email"
                                :value="old('email')" required autofocus placeholder="Email Address" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </span>
                            <x-text-input id="password" class="block w-full pl-10" type="password" name="password"
                                required autocomplete="current-password" placeholder="Password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-primary-600 hover:underline dark:text-primary-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center bg-[#025863]">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Gambar -->
        <div class="hidden md:block">
            <img class="object-cover w-full h-full" src="{{ asset('images/login_image.png') }}" alt="Login Image">
        </div>
    </div>
</x-guest-layout>
