<x-guest-layout>
    <div class="relative z-20 w-full max-w-md mx-auto p-8 rounded-3xl backdrop-blur-lg bg-white/10 border border-white/20 shadow-2xl overflow-hidden">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-isi.png') }}" alt="Logo ISI Yogyakarta" class="w-21 h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-white mb-1">SIPRESMA ISI Yogyakarta</h1>
            <p class="text-white/80">Sistem Informasi Prestasi Mahasiswa</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <x-input-label for="email" :value="__('Email')" class="sr-only" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    <x-text-input id="email" class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 pl-12 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" 
                                    type="email" name="email" :value="old('email')" required autofocus placeholder="Username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200" />
            </div>

            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <x-text-input id="password" class="block mt-1 w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-3 pl-12 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" 
                                    type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
            </div>

            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-white/10 border-white/20 rounded focus:ring-blue-500">
                    <x-input-label for="remember_me" :value="__('Remember Me')" class="ml-2 text-white/80" />
                </div>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-red-400 hover:text-red-300 transition" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            <div class="mb-6">
                <button class="w-full justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md">
                    {{ __('Masuk') }}
                </button>
            </div>

            <div class="text-center">
                <p class="text-white/80 mb-4">{{ __('Belum mempunyai akun?') }}</p>
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md">
                    {{ __('Daftar') }}
                </a>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success_register'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Pendaftaran Berhasil',
    html: `
        <div style="text-align:left">
            <p>Akun Anda berhasil didaftarkan.</p>
            <br>
            <p>Silakan tunggu persetujuan dari Admin sebelum dapat masuk ke sistem.</p>
        </div>
    `,
    confirmButtonText: 'Baik',
    confirmButtonColor: '#2563eb'
});
</script>
@endif
</x-guest-layout>