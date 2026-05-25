<x-guest-layout>
    <div class="relative z-20 w-full max-w-md mx-auto p-8 rounded-3xl backdrop-blur-lg bg-white/10 border border-white/20 shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-isi.png') }}" 
                 alt="Logo ISI Yogyakarta" 
                 class="w-21 h-20 mx-auto mb-4">

            <h1 class="text-2xl font-bold text-white mb-1">
                Reset Password
            </h1>

            <p class="text-white/80 text-sm">
                Masukkan password baru akun Anda
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Email')" class="sr-only" />

                <x-text-input 
                    id="email"
                    class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 px-5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />

                <x-text-input 
                    id="password"
                    class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 px-5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Password Baru"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="sr-only" />

                <x-text-input 
                    id="password_confirmation"
                    class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 px-5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Konfirmasi Password"
                />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-200" />
            </div>

            <!-- Button -->
            <div>
                <button 
                    class="w-full justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md"
                >
                    {{ __('Reset Password') }}
                </button>
            </div>

        </form>
    </div>
</x-guest-layout>