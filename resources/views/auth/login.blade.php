<x-guest-layout>
    <div class="relative z-20 w-full max-w-md mx-auto p-8 rounded-3xl backdrop-blur-xl bg-white/10 border border-white/20 shadow-2xl shadow-black/30 overflow-hidden">
        
        {{-- Efek Glass Tambahan --}}
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-400/20 rounded-full blur-3xl"></div>
        
        {{-- Garis Gradient Atas --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
        
        <div class="relative z-10">
            
            {{-- Logo & Judul --}}
            <div class="text-center mb-8">
                {{-- Logo dengan efek glass --}}
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl">
                    <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="Logo ISI Yogyakarta" class="w-full h-full object-contain">
                </div>
                <h1 class="text-2xl font-bold text-white mb-1 drop-shadow-lg">PRATAMA</h1>
                <p class="text-white/70 text-sm">Prestasi dan Talenta Mahasiswa</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" x-on:submit="loading = true">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email')" class="sr-only" />
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <x-text-input id="email" 
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-3 pl-12 pr-4 focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all text-sm"
                            type="email" name="email" :value="old('email')" required autofocus placeholder="Username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-xs" />
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <x-input-label for="password" :value="__('Password')" class="sr-only" />
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <x-text-input id="password" 
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-3 pl-12 pr-12 focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all text-sm"
                            type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                        <button type="button" onclick="togglePassword('password')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-white/50 hover:text-white/80 transition-colors cursor-pointer z-10">
                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                            <svg id="eye-off-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-xs" />
                </div>

                {{-- Remember Me & Lupa Password --}}
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-500 bg-white/10 border-white/20 rounded focus:ring-blue-400 focus:ring-offset-0">
                        <x-input-label for="remember_me" :value="__('Ingat Saya')" class="ml-2 text-white/70 text-sm" />
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-red-400 hover:text-red-300 transition-colors" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                {{-- Tombol Masuk --}}
                <div class="mb-6">
                    <button type="submit" :disabled="loading" class="w-full justify-center rounded-xl bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">{{ __('Masuk') }}</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Memproses...
                        </span>
                    </button>
                </div>

                {{-- Divider --}}
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 text-white/50">{{ __('Belum mempunyai akun?') }}</span>
                    </div>
                </div>

                {{-- Tombol Daftar --}}
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md">
                    {{ __('Daftar') }}
                </a>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('status_verified'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Verifikasi Berhasil!',
                text: "{{ session('status_verified') }}",
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100'
                }
            });
        });
    </script>
@endif

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById('eye-' + id);
    const eyeOff = document.getElementById('eye-off-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.add('hidden');
        eyeOff.classList.remove('hidden');
    } else {
        input.type = 'password';
        eye.classList.remove('hidden');
        eyeOff.classList.add('hidden');
    }
}
</script>
</x-guest-layout>