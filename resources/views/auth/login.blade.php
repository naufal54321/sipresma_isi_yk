<x-guest-layout>
    <div class="relative z-20 w-full max-w-md mx-auto p-8 rounded-3xl backdrop-blur-xl bg-white/10 border border-white/20 shadow-2xl shadow-black/30 overflow-hidden animate-fade-in-up">
        
        {{-- Efek Glass Tambahan dengan Animasi Pulsing --}}
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-400/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-60 h-60 bg-cyan-400/10 rounded-full blur-3xl animate-float"></div>
        
        {{-- Garis Gradient Atas dengan Animasi Shimmer --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent animate-shimmer"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
        
        {{-- Partikel Background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
        </div>
        
        <div class="relative z-10">
            
            {{-- Logo & Judul --}}
            <div class="text-center mb-8">
                {{-- Logo tanpa animasi --}}
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl">
                    <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="Logo ISI Yogyakarta" class="w-full h-full object-contain">
                </div>
                <h1 class="text-2xl font-bold text-white mt-4 mb-1 drop-shadow-lg">
                    PRATAMA
                </h1>
                <p class="text-white/70 text-sm">Prestasi dan Talenta Mahasiswa</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" x-on:submit="loading = true">
                @csrf

                {{-- Email dengan Animasi Slide --}}
                <div class="mb-5 animate-slide-in-left animation-delay-100">
                    <x-input-label for="email" :value="__('Email')" class="sr-only" />
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <x-text-input id="email" 
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-3 pl-12 pr-4 focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 text-sm hover:border-white/20"
                            type="email" name="email" :value="old('email')" required autofocus placeholder="Username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-xs" />
                </div>

                {{-- Password dengan Animasi Slide --}}
                <div class="mb-5 animate-slide-in-right animation-delay-200">
                    <x-input-label for="password" :value="__('Password')" class="sr-only" />
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <x-text-input id="password" 
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-3 pl-12 pr-12 focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 text-sm hover:border-white/20"
                            type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                        <button type="button" onclick="togglePassword('password')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-white/50 hover:text-white/80 transition-all duration-300 cursor-pointer z-10 hover:scale-110">
                            <svg id="eye-password" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                            <svg id="eye-off-password" class="w-5 h-5 hidden transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-xs" />
                </div>

               {{-- Lupa Password dengan Animasi Fade --}}
                <div class="flex items-center justify-end mb-8 animate-fade-in animation-delay-300">
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-red-400 hover:text-red-300 transition-all duration-300 hover:scale-105 inline-block" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                {{-- Tombol Masuk dengan Efek Ripple --}}
                <div class="mb-6 animate-fade-in-up animation-delay-400">
                    <button type="submit" :disabled="loading" class="ripple-btn w-full justify-center rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span x-show="!loading">{{ __('Masuk') }}</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Memproses...
                        </span>
                    </button>
                </div>

                {{-- Divider --}}
                <div class="relative mb-6 animate-fade-in animation-delay-500">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 text-white/50">{{ __('Belum mempunyai akun?') }}</span>
                    </div>
                </div>

                {{-- Tombol Daftar dengan Efek Ripple --}}
                <a href="{{ route('register') }}" class="ripple-btn w-full inline-flex justify-center rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 text-lg font-semibold focus:ring-2 focus:ring-blue-400 transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5 animate-fade-in-up animation-delay-600">
                    {{ __('Daftar') }}
                </a>

            </form>
        </div>
    </div>

    <style>
        /* Animasi Utama */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulseSlow {
            0%, 100% {
                opacity: 0.2;
                transform: scale(1);
            }
            50% {
                opacity: 0.4;
                transform: scale(1.1);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(-50%, -50%) translateY(0);
            }
            50% {
                transform: translate(-50%, -50%) translateY(-10px);
            }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        
        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(20px);
                opacity: 0;
            }
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        /* Kelas Animasi */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-fade-in-down {
            animation: fadeInDown 0.6s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-shimmer {
            animation: shimmer 2s linear infinite;
        }
        
        /* Animation Delays */
        .animation-delay-100 {
            animation-delay: 0.1s;
            animation-fill-mode: both;
        }
        
        .animation-delay-200 {
            animation-delay: 0.2s;
            animation-fill-mode: both;
        }
        
        .animation-delay-300 {
            animation-delay: 0.3s;
            animation-fill-mode: both;
        }
        
        .animation-delay-400 {
            animation-delay: 0.4s;
            animation-fill-mode: both;
        }
        
        .animation-delay-500 {
            animation-delay: 0.5s;
            animation-fill-mode: both;
        }
        
        .animation-delay-600 {
            animation-delay: 0.6s;
            animation-fill-mode: both;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        /* Partikel */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 4s ease-in-out infinite;
        }
        
        .particle-1 {
            top: 80%;
            left: 20%;
            animation-delay: 0s;
            width: 3px;
            height: 3px;
        }
        
        .particle-2 {
            top: 60%;
            left: 80%;
            animation-delay: 1s;
            width: 2px;
            height: 2px;
        }
        
        .particle-3 {
            top: 90%;
            left: 50%;
            animation-delay: 2s;
            width: 3px;
            height: 3px;
        }
        
        .particle-4 {
            top: 70%;
            left: 10%;
            animation-delay: 3s;
            width: 2px;
            height: 2px;
        }
        
        .particle-5 {
            top: 85%;
            left: 90%;
            animation-delay: 2.5s;
            width: 3px;
            height: 3px;
        }
        
        /* Efek Ripple untuk Tombol */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }
        
        .ripple-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.3);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .ripple-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('status_verified'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Verifikasi Berhasil!',
                text: "{{ session('status_verified') }}",
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 animate-fade-in-up'
                }
            }).then(() => location.reload());
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
    
    // Efek Ripple pada Tombol
    document.addEventListener('DOMContentLoaded', function() {
        const rippleButtons = document.querySelectorAll('.ripple-btn');
        rippleButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.4)';
                ripple.style.width = ripple.style.height = '20px';
                ripple.style.left = x - 10 + 'px';
                ripple.style.top = y - 10 + 'px';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
    </script>
</x-guest-layout>