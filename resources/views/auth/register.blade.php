<x-guest-layout>
    <div class="flex flex-col lg:flex-row w-full max-w-5xl mx-auto min-h-[600px] rounded-3xl overflow-hidden shadow-2xl shadow-black/30 relative z-20">

        {{-- ═══ LEFT: BRANDING PANEL ═══ --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary via-primary-container to-primary p-10 md:p-14 flex-col justify-center relative overflow-hidden animate-slide-in-left">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-secondary/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-primary-fixed/10 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-cyan-400/10 rounded-full blur-3xl animate-float"></div>
            
            {{-- Partikel Background --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="Logo ISI" class="h-14 w-14 object-contain rounded-xl bg-white/10 p-2">
                    <div>
                        <span class="text-2xl font-black text-white tracking-tight">PRATAMA</span>
                        <p class="text-[11px] text-white/60 tracking-[0.15em] font-semibold">PRESTASI &amp; TALENTA MAHASISWA</p>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-white mb-4 leading-tight animate-fade-in animation-delay-200">Selamat Datang</h2>
                <p class="text-white/70 text-sm leading-relaxed mb-10 animate-fade-in animation-delay-300">
                    Platform digital resmi Institut Seni Indonesia Yogyakarta untuk mendokumentasikan, mengelola, dan mengembangkan prestasi serta talenta mahasiswa secara profesional.
                </p>

                <div class="space-y-5">
                    <div class="flex items-center gap-4 animate-fade-in-up animation-delay-400">
                        <div class="w-10 h-10 rounded-xl bg-secondary-fixed/20 flex items-center justify-center shrink-0 group hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">emoji_events</span>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">Catat Prestasi</h4>
                            <p class="text-white/60 text-xs">Dokumentasikan pencapaian akademik &amp; non-akademik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 animate-fade-in-up animation-delay-500">
                        <div class="w-10 h-10 rounded-xl bg-secondary-fixed/20 flex items-center justify-center shrink-0 group hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">verified</span>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">Verifikasi Terpadu</h4>
                            <p class="text-white/60 text-xs">Verifikasi oleh dosen pembimbing &amp; admin</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 animate-fade-in-up animation-delay-600">
                        <div class="w-10 h-10 rounded-xl bg-secondary-fixed/20 flex items-center justify-center shrink-0 group hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white text-2xl">bar_chart</span>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">Laporan Prestasi</h4>
                            <p class="text-white/60 text-xs">Lihat statistik prestasi</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-white/10 animate-fade-in animation-delay-700">
                    <p class="text-white/40 text-xs">Institut Seni Indonesia Yogyakarta</p>
                </div>
            </div>
        </div>

        {{-- ═══ RIGHT: FORM PANEL ═══ --}}
        <div class="w-full lg:w-1/2 bg-white/10 backdrop-blur-xl border border-white/20 p-6 sm:p-10 md:p-12 flex flex-col justify-center relative overflow-hidden animate-fade-in-up">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-400/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-60 h-60 bg-cyan-400/10 rounded-full blur-3xl animate-float animation-delay-1000"></div>
            
            {{-- Garis Gradient --}}
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
            
            {{-- Mobile header --}}
            <div class="text-center lg:hidden mb-6 relative z-10">
                <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="Logo ISI" class="h-12 w-12 mx-auto mb-3">
                <h1 class="text-2xl font-bold text-white">Daftar PRATAMA</h1>
                <p class="text-white/70 text-sm mt-1">Buat akun untuk mulai menggunakan platform</p>
            </div>

            {{-- Desktop header --}}
            <div class="hidden lg:block text-center mb-8 relative z-10">
                <h1 class="text-2xl font-bold text-white">Daftar Akun</h1>
                <p class="text-white/70 text-sm mt-1">Isi data diri Anda untuk mendaftar</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('register') }}" id="registerForm" x-data="{ loading: false }" x-on:submit="loading = true" class="relative z-10">
                @csrf

                {{-- ⚡ BARIS 1: NAMA & NIM --}}
                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-3 animate-slide-in-left animation-delay-100">
                    <div>
                        <label for="name" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <x-text-input id="name" class="block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-10 pr-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" type="text" name="name" :value="old('name')" required autofocus placeholder="Nama Lengkap" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-300 text-xs" />
                    </div>
                    <div>
                        <label for="nim" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">NIM</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                            </span>
                            <x-text-input id="nim" class="block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-10 pr-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" type="text" name="nim" :value="old('nim')" required placeholder="NIM" />
                        </div>
                        <x-input-error :messages="$errors->get('nim')" class="mt-1 text-red-300 text-xs" />
                    </div>
                </div>

                {{-- ⚡ BARIS 2: PRODI & ANGKATAN --}}
                @php
                    $programStudis = \App\Models\ProgramStudi::where('status', 'aktif')->orderBy('nama_prodi', 'asc')->get();
                @endphp
                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-3 animate-slide-in-right animation-delay-200">
                    {{-- Prodi --}}
                    <div>
                        <label class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Program Studi</label>
                        <select name="prodi" id="prodiInput" class="w-full rounded-xl bg-white/5 border border-white/10 text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" required>
                            <option value="" disabled selected class="text-slate-800">Pilih Prodi</option>
                            @foreach($programStudis as $prodi)
                                <option value="{{ $prodi->nama_prodi }}" {{ old('prodi') == $prodi->nama_prodi ? 'selected' : '' }} class="text-slate-800">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('prodi')" class="mt-1 text-red-300 text-xs" />
                    </div>
                    {{-- Angkatan --}}
                    <div>
                        <label for="angkatan" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Angkatan</label>
                        <select name="angkatan" id="angkatan" class="w-full rounded-xl bg-white/5 border border-white/10 text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" required>
                            <option value="" disabled selected class="text-slate-800">Pilih Angkatan</option>
                            @for($year = date('Y'); $year >= 2015; $year--)
                                <option value="{{ $year }}" {{ old('angkatan') == $year ? 'selected' : '' }} class="text-slate-800">{{ $year }}</option>
                            @endfor
                        </select>
                        <x-input-error :messages="$errors->get('angkatan')" class="mt-1 text-red-300 text-xs" />
                    </div>
                </div>

                {{-- ⚡ BARIS 3: SEMESTER & EMAIL --}}
                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-3 animate-slide-in-left animation-delay-300">
                    {{-- Semester --}}
                    <div>
                        <label for="semester" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Semester</label>
                        <select name="semester" id="semester" class="w-full rounded-xl bg-white/5 border border-white/10 text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" required>
                            <option value="" disabled selected class="text-slate-800">Pilih Semester</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }} class="text-slate-800">Semester {{ $i }}</option>
                            @endfor
                        </select>
                        <x-input-error :messages="$errors->get('semester')" class="mt-1 text-red-300 text-xs" />
                    </div>
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Email</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <x-text-input id="email" class="block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-10 pr-3 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" type="email" name="email" :value="old('email')" required placeholder="Email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300 text-xs" />
                    </div>
                </div>

                {{-- ⚡ BARIS 4: PASSWORD & KONFIRMASI --}}
                <div class="mb-5 grid grid-cols-1 sm:grid-cols-2 gap-3 animate-slide-in-right animation-delay-400">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <x-text-input id="password" class="block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-10 pr-10 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/50 hover:text-white/80 transition-all duration-300 hover:scale-110">
                                <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                <svg id="eye-off-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-300 text-xs" />
                    </div>
                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-white/60 mb-1 uppercase tracking-wider">Konfirmasi Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/50 group-focus-within:text-blue-300 transition-all duration-300 group-focus-within:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <x-text-input id="password_confirmation" class="block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-10 pr-10 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi" />
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/50 hover:text-white/80 transition-all duration-300 hover:scale-110">
                                <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                <svg id="eye-off-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-300 text-xs" />
                    </div>
                </div>

                {{-- Tombol Daftar dengan Efek Ripple --}}
                <div class="animate-fade-in-up animation-delay-500">
                    <button type="submit" :disabled="loading" class="ripple-btn w-full rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 text-base font-semibold focus:ring-2 focus:ring-blue-400 transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span x-show="!loading">{{ __('Daftar') }}</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Memproses...
                        </span>
                    </button>
                </div>

                {{-- Divider --}}
                <div class="relative mb-4 animate-fade-in animation-delay-600">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 text-white/50">Sudah punya akun?</span>
                    </div>
                </div>

                {{-- Tombol Masuk dengan Efek Ripple --}}
                <a href="{{ route('login') }}" class="ripple-btn w-full inline-flex justify-center rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 text-base font-semibold focus:ring-2 focus:ring-blue-400 transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5 animate-fade-in-up animation-delay-700">
                    {{ __('Masuk') }}
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
        .animation-delay-100 { animation-delay: 0.1s; animation-fill-mode: both; }
        .animation-delay-200 { animation-delay: 0.2s; animation-fill-mode: both; }
        .animation-delay-300 { animation-delay: 0.3s; animation-fill-mode: both; }
        .animation-delay-400 { animation-delay: 0.4s; animation-fill-mode: both; }
        .animation-delay-500 { animation-delay: 0.5s; animation-fill-mode: both; }
        .animation-delay-600 { animation-delay: 0.6s; animation-fill-mode: both; }
        .animation-delay-700 { animation-delay: 0.7s; animation-fill-mode: both; }
        .animation-delay-1000 { animation-delay: 1s; }
        .animation-delay-2000 { animation-delay: 2s; }
        
        /* Partikel */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 4s ease-in-out infinite;
        }
        
        .particle-1 { top: 80%; left: 20%; animation-delay: 0s; width: 3px; height: 3px; }
        .particle-2 { top: 60%; left: 80%; animation-delay: 1s; width: 2px; height: 2px; }
        .particle-3 { top: 90%; left: 50%; animation-delay: 2s; width: 3px; height: 3px; }
        .particle-4 { top: 70%; left: 10%; animation-delay: 3s; width: 2px; height: 2px; }
        .particle-5 { top: 85%; left: 90%; animation-delay: 2.5s; width: 3px; height: 3px; }
        
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

    @if(session('success_register'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil',
            html: `<div style="text-align:left"><p>Akun Anda berhasil didaftarkan.</p><br><p>Silakan cek email <b>{{ session('success_register') }}</b> untuk verifikasi.</p><br><p>Tidak menerima email? Periksa folder spam.</p></div>`,
            confirmButtonText: 'Baik',
            confirmButtonColor: '#2563eb',
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-gray-100 animate-fade-in-up'
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