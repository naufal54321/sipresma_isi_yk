<x-guest-layout>
    <div class="relative z-20 w-full max-w-md mx-auto p-8 rounded-3xl backdrop-blur-lg bg-white/10 border border-white/20 shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo_isi_dashboard.png') }}" 
                 alt="Logo ISI Yogyakarta" 
                 class="w-21 h-20 mx-auto mb-4">

            <h1 class="text-2xl font-bold text-white mb-1">
                SIPRESMA ISI Yogyakarta
            </h1>

            <p class="text-white/80 text-sm">
                Lupa password? Masukkan email Anda untuk mendapatkan link reset password.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status 
            class="mb-4 text-green-200 text-sm" 
            :status="session('status')" 
        />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
                <x-input-label 
                    for="email" 
                    :value="__('Email')" 
                    class="sr-only" 
                />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" 
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M16 12H8m0 0l4-4m-4 4l4 4">
                            </path>
                        </svg>
                    </span>

                    <x-text-input 
                        id="email"
                        class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 pl-12 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="Masukkan Email"
                    />
                </div>

                <x-input-error 
                    :messages="$errors->get('email')" 
                    class="mt-2 text-red-200" 
                />
            </div>

            <!-- Button -->
            <div class="mb-6">
                <button 
                    class="w-full justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md"
                >
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>

            <!-- Back Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" 
                   class="text-sm font-medium text-white/80 hover:text-white transition">
                    ← Kembali ke Login
                </a>
            </div>

        </form>
    </div>
</x-guest-layout>