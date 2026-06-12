<x-guest-layout>

    <div class="relative z-20 w-full max-w-md mx-auto p-6 rounded-3xl backdrop-blur-lg bg-white/10 border border-white/20 shadow-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-isi.png') }}"
                alt="Logo ISI Yogyakarta"
                class="w-21 h-20 mx-auto mb-3">

            <h1 class="text-2xl font-bold text-white mb-1">
                Daftar SIPRESMA
            </h1>

            <p class="text-white/80 text-sm">
                Sistem Informasi Prestasi Mahasiswa
            </p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                    </span>

                    <x-text-input
                        id="name"
                        class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        placeholder="Nama Lengkap" />
                </div>

                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-200 text-xs" />
            </div>

            {{-- NIM --}}
            <div class="mb-3">
                <x-input-label for="nim" :value="__('NIM')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 17v-2a4 4 0 014-4h4">
                            </path>
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7h4v4">
                            </path>
                        </svg>
                    </span>

                    <x-text-input
                        id="nim"
                        class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="text"
                        name="nim"
                        :value="old('nim')"
                        required
                        placeholder="NIM" />
                </div>

                <x-input-error :messages="$errors->get('nim')" class="mt-1 text-red-200 text-xs" />
            </div>

           {{-- Prodi --}}
            @php
                // Trik: Mengambil data langsung dari model tanpa butuh Controller
                $programStudis = \App\Models\ProgramStudi::where('status', 'aktif')
                                    ->orderBy('nama_prodi', 'asc')
                                    ->get();
            @endphp

            <div class="mb-3">
                <x-input-label for="prodi" :value="__('Program Studi')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </span>

                    <select id="prodi" 
                            name="prodi" 
                            class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 pr-10 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 appearance-none [&>option]:text-gray-900" 
                            required>
                        <option value="" class="text-gray-500">Pilih Program Studi</option>
                        @foreach($programStudis as $prodi)
                            <option value="{{ $prodi->nama_prodi }}" {{ old('prodi') == $prodi->nama_prodi ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-white/60">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('prodi')" class="mt-1 text-red-200 text-xs" />
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </span>

                    <x-text-input
                        id="email"
                        class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        placeholder="Email" />
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-200 text-xs" />
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>

                    <x-text-input
                        id="password"
                        class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Password" />
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-200 text-xs" />
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="sr-only" />

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>

                    <x-text-input
                        id="password_confirmation"
                        class="block w-full rounded-full backdrop-blur-sm bg-white/10 border border-white/20 text-white placeholder-white/60 py-2 pl-12 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Konfirmasi Password" />
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-200 text-xs" />
            </div>

            {{-- BUTTON --}}
            <div class="mb-3">
                <button
                    class="w-full rounded-full bg-blue-600 hover:bg-blue-500 text-white py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md">
                    {{ __('Daftar') }}
                </button>
            </div>

            <div class="text-center">
                <p class="text-white/70 text-xs mb-2">
                    Sudah punya akun?
                </p>

                <a href="{{ route('login') }}"
                    class="w-full inline-flex justify-center rounded-full bg-blue-600 hover:bg-blue-500 border border-white/20 text-white py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md">
                    {{ __('Masuk') }}
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