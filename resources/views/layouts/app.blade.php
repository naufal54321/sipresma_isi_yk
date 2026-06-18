<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Custom Font Configuration for Tailwind -->
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>

    </head>

    <body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-blue-200 selection:text-blue-900">

        <div class="min-h-screen flex">

            <!-- Sidebar Layout (Tetap Sama) -->
            @include('layouts.navigation')

            <!-- Main Wrapper -->
            <div class="flex-1 ml-64 flex flex-col min-h-screen">

                <!-- Topbar Glassmorphism -->
                <div class="bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 px-8 py-3 flex items-center justify-between sticky top-0 z-40 transition-all">

                    <div>
                        <!-- Ruang kosong (sama seperti aslinya), bisa diisi breadcrumb nanti -->
                        <h1 class="text-2xl font-bold text-transparent"></h1>
                        <p class="text-sm text-transparent"></p>
                    </div>

                    <!-- Profile Dropdown (Alpine.js) -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        
                        <button @click="open = !open" class="flex items-center gap-3 hover:bg-slate-50 p-2 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            
                            <div class="text-right hidden sm:block">
                                <h2 class="font-bold text-sm text-slate-800 leading-tight">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-[11px] text-slate-500 font-semibold tracking-wide uppercase mt-0.5">
                                    @foreach(auth()->user()->roles as $role)
                                        {{ $role->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>

                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eff6ff&color=2563eb&bold=true"
                                     alt="Profile"
                                     class="w-10 h-10 rounded-full ring-2 ring-slate-100 object-cover shadow-sm">
                                <!-- Indikator Status Online -->
                                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>

                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-300 ml-1" 
                               :class="{'rotate-180': open}"></i>

                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-50 origin-top-right"
                             style="display: none;">

                            <!-- Teks Header Profil Mobile (Opsional jika nama disembunyikan di layar kecil) -->
                            <div class="px-4 py-3 border-b border-slate-50 sm:hidden">
                                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-user-circle w-4 text-center text-slate-400"></i> Kelola Profil
                            </a>

                            <div class="border-t border-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

                <!-- Optional Header Slot -->
                @isset($header)
                    <header class="bg-white/50 backdrop-blur-sm border-b border-slate-200 shadow-sm">
                        <div class="px-8 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Main Content Slot -->
                <main class="p-8 flex-1">
                    {{ $slot }}
                </main>

            </div>

        </div>

        <!-- SweetAlert2 Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3b82f6',
                timer: 2500,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6'
                }
            });
        </script>
        @endif

    </body>
</html>