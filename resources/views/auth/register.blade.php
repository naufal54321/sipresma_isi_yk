<x-guest-layout>

    <div class="relative z-20 w-full max-w-md mx-auto p-6 sm:p-8 rounded-3xl backdrop-blur-xl bg-white/10 border border-white/20 shadow-2xl shadow-black/30 overflow-visible">

        {{-- Efek Glass Tambahan --}}
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-400/20 rounded-full blur-3xl"></div>
        
        {{-- Garis Gradient Atas & Bawah --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

        <div class="relative z-10">

            {{-- HEADER --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl">
                    <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="Logo ISI Yogyakarta" class="w-full h-full object-contain">
                </div>

                <h1 class="text-2xl font-bold text-white mb-1 drop-shadow-lg">
                    Daftar SIPRESMA
                </h1>

                <p class="text-white/70 text-sm">
                    Sistem Informasi Prestasi Mahasiswa
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="sr-only" />

                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>

                        <x-text-input id="name"
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            placeholder="Nama Lengkap" />
                    </div>

                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- NIM --}}
                <div class="mb-3">
                    <x-input-label for="nim" :value="__('NIM')" class="sr-only" />

                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M9.493 2.852a.75.75 0 0 0-1.486-.204L7.545 6H4.198a.75.75 0 0 0 0 1.5h3.14l-.69 5H3.302a.75.75 0 0 0 0 1.5h3.14l-.435 3.148a.75.75 0 0 0 1.486.204L7.955 14h2.986l-.434 3.148a.75.75 0 0 0 1.486.204L12.456 14h3.346a.75.75 0 0 0 0-1.5h-3.14l.69-5h3.346a.75.75 0 0 0 0-1.5h-3.14l.435-3.148a.75.75 0 0 0-1.486-.204L12.045 6H9.059l.434-3.148ZM8.852 7.5l-.69 5h2.986l.69-5H8.852Z" clip-rule="evenodd" />
                            </svg>
                        </span>

                        <x-text-input id="nim"
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all"
                            type="text"
                            name="nim"
                            :value="old('nim')"
                            required
                            placeholder="NIM" />
                    </div>

                    <x-input-error :messages="$errors->get('nim')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- 🔧 CUSTOM DROPDOWN PRODI --}}
                @php
                    $programStudis = \App\Models\ProgramStudi::where('status', 'aktif')
                                        ->orderBy('nama_prodi', 'asc')
                                        ->get();
                @endphp
                <div class="mb-3">
                    <x-input-label for="prodi" :value="__('Program Studi')" class="sr-only" />

                    <div class="relative" id="customDropdown">
                        {{-- Trigger Button --}}
                        <button type="button" 
                                id="dropdownTrigger"
                                class="w-full flex items-center rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white/40 py-2.5 pl-12 pr-10 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all cursor-pointer text-left">
                            <span id="dropdownText">Pilih Program Studi</span>
                        </button>

                        {{-- Icon Search --}}
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </span>

                        {{-- Chevron --}}
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-white/50 pointer-events-none">
                            <svg id="dropdownChevron" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>

                        {{-- Dropdown Menu --}}
                        <div id="dropdownMenu" 
                             class="absolute left-0 right-0 top-full mt-1 z-[9999] hidden bg-white rounded-xl shadow-2xl border border-gray-200 max-h-48 overflow-y-auto">
                            @foreach($programStudis as $prodi)
                                <div class="dropdown-item px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 cursor-pointer transition-colors first:rounded-t-xl last:rounded-b-xl"
                                     data-value="{{ $prodi->nama_prodi }}">
                                    {{ $prodi->nama_prodi }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hidden input untuk menyimpan nilai --}}
                    <input type="hidden" name="prodi" id="prodiInput" value="{{ old('prodi') }}" required>

                    <x-input-error :messages="$errors->get('prodi')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" class="sr-only" />

                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M5.404 14.596A6.5 6.5 0 1 1 16.5 10a1.25 1.25 0 0 1-2.5 0 4 4 0 1 0-.571 2.06A2.75 2.75 0 0 0 18 10a8 8 0 1 0-2.343 5.657.75.75 0 0 0-1.06-1.06 6.5 6.5 0 0 1-9.193 0ZM10 7.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd" />
                            </svg>
                        </span>

                        <x-text-input id="email"
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            placeholder="Email" />
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" class="sr-only" />

                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>

                        <x-text-input id="password"
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Password" />
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-5">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="sr-only" />

                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/50 group-focus-within:text-blue-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </span>

                        <x-text-input id="password_confirmation"
                            class="block w-full rounded-2xl backdrop-blur-md bg-white/5 border border-white/10 text-white placeholder-white/40 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-white/30 focus:border-white/30 focus:bg-white/10 transition-all"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Konfirmasi Password" />
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-300 text-xs" />
                </div>

                {{-- Tombol Daftar --}}
                <div class="mb-4">
                    <button type="submit"
                        class="w-full rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-base font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md hover:shadow-lg">
                        {{ __('Daftar') }}
                    </button>
                </div>

                {{-- Divider --}}
                <div class="relative mb-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 text-white/50">Sudah punya akun?</span>
                    </div>
                </div>

                {{-- Tombol Masuk --}}
                <a href="{{ route('login') }}"
                    class="w-full inline-flex justify-center rounded-full bg-blue-600 hover:bg-blue-500 text-white py-3 text-base font-semibold focus:ring-2 focus:ring-blue-400 transition shadow-md hover:shadow-lg">
                    {{ __('Masuk') }}
                </a>

            </form>

        </div>
    </div>

    {{-- 🔧 JAVASCRIPT CUSTOM DROPDOWN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.getElementById('dropdownTrigger');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownText = document.getElementById('dropdownText');
            const dropdownChevron = document.getElementById('dropdownChevron');
            const prodiInput = document.getElementById('prodiInput');
            const dropdownItems = document.querySelectorAll('.dropdown-item');

            // 🔧 Cek jika ada old value, set ke dropdown
            const oldProdi = prodiInput.value;
            if (oldProdi) {
                dropdownText.textContent = oldProdi;
                dropdownText.classList.remove('text-white/40');
                dropdownText.classList.add('text-white');
            }

            // 🔧 Toggle dropdown
            dropdownTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
                dropdownChevron.classList.toggle('rotate-180');
            });

            // 🔧 Pilih item
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    prodiInput.value = value;
                    dropdownText.textContent = value;
                    dropdownText.classList.remove('text-white/40');
                    dropdownText.classList.add('text-white');
                    dropdownMenu.classList.add('hidden');
                    dropdownChevron.classList.remove('rotate-180');
                });
            });

            // 🔧 Tutup dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                    dropdownChevron.classList.remove('rotate-180');
                }
            });
        });
    </script>

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