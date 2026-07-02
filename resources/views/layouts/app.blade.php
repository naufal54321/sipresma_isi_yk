<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPRESMA') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            /* ⚡ SEMBUNYIKAN ELEMEN DENGAN x-cloak */
            [x-cloak] { 
                display: none !important; 
            }

            /* ⚡ MATIKAN SEMUA ANIMASI & TRANSISI SAAT PRELOAD */
            body.preload *,
            body.preload *::before,
            body.preload *::after {
                animation-duration: 0s !important;
                animation-delay: 0s !important;
                transition-duration: 0s !important;
                transition-delay: 0s !important;
            }
            
            /* Loading bar */
            #page-loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 3px;
                z-index: 99999;
                pointer-events: none;
                opacity: 0;
            }
            
            #page-loader.active {
                opacity: 1;
            }
            
            #page-loader .bar {
                height: 100%;
                width: 0;
                background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
                box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
            }
            
            #page-loader .bar.animating {
                animation: loadingProgress 1.2s ease-out forwards;
            }
            
            @keyframes loadingProgress {
                0% { width: 0; }
                40% { width: 50%; }
                100% { width: 90%; }
            }

            /* Fade in konten */
            body.preload #content-wrapper {
                opacity: 0;
            }
            
            body:not(.preload) #content-wrapper {
                opacity: 1;
                transition: opacity 0.4s ease-out;
            }
        </style>
    </head>

    <body id="main-body" 
          class="preload font-sans antialiased bg-slate-50 text-slate-800 selection:bg-blue-200 selection:text-blue-900"
          x-data="{ sidebarKecil: localStorage.getItem('sidebarState') === 'true', siapAnimasi: false }" 
          x-init="
              setTimeout(() => { 
                  document.body.classList.remove('preload'); 
                  siapAnimasi = true; 
              }, 500);
              window.addEventListener('sidebar-toggle', (e) => {
                  sidebarKecil = e.detail;
              });
          "
          @sidebar-toggle.window="sidebarKecil = $event.detail">

        {{-- Loading bar --}}
        <div id="page-loader"><div class="bar"></div></div>

        <div class="min-h-screen flex">

            @include('layouts.navigation')

            <div class="flex flex-col flex-1 min-w-0"
                 :class="{
                     'ml-20': sidebarKecil,
                     'ml-64': !sidebarKecil,
                     'transition-[margin] duration-300 ease-in-out': siapAnimasi
                 }">

                {{-- Header --}}
                <div class="w-full bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 px-8 py-3 flex items-center justify-between sticky top-0 z-40">
                    <div class="flex-1"></div>

                    <div class="relative ml-auto" x-data="{ open: false }" @click.outside="open = false">
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eff6ff&color=2563eb&bold=true" class="w-10 h-10 rounded-full ring-2 ring-slate-100 object-cover shadow-sm">
                                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-300 ml-1" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-50 origin-top-right" style="display: none;">

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

                {{-- Konten Utama --}}
                <div class="flex flex-col flex-1 relative">
                    
                    <div id="content-wrapper" class="flex-1 w-full flex flex-col">
                        
                        @isset($header)
                            <header class="bg-white/50 backdrop-blur-sm border-b border-slate-200 shadow-sm w-full shrink-0">
                                <div class="px-8 py-6">{{ $header }}</div>
                            </header>
                        @endisset

                        <main class="p-8 w-full flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                    
                    <footer class="w-full py-5 text-center text-sm text-slate-500 border-t border-slate-200 bg-white/50 backdrop-blur-sm shrink-0">
                        &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
                    </footer>

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Navigasi Script --}}
        <script>
document.addEventListener('DOMContentLoaded', () => {

    const wrapper = document.getElementById('content-wrapper');

    // ⚡ LOADING BAR SELESAI
    window.addEventListener('load', function() {
        const bar = document.querySelector('#page-loader .bar');
        const loader = document.getElementById('page-loader');
        if (bar && loader) {
            bar.style.width = '100%';
            bar.classList.remove('animating');
            setTimeout(() => {
                loader.classList.remove('active');
                bar.style.width = '0';
            }, 300);
        }
    });

    // ⚡ FUNGSI NAVIGASI DENGAN ANIMASI
    function navigateTo(url) {
        const loader = document.getElementById('page-loader');
        const bar = document.querySelector('#page-loader .bar');
        
        if (loader && bar) {
            bar.classList.remove('animating');
            bar.style.width = '0';
            bar.offsetHeight;
            bar.classList.add('animating');
            loader.classList.add('active');
        }
        
        if (wrapper) {
            wrapper.style.opacity = '0.3';
            wrapper.style.transition = 'opacity 0.15s ease-in';
        }
        
        setTimeout(() => {
            window.location.href = url;
        }, 180);
    }

    // ⚡ TANGKAP SEMUA KLIK LINK
    document.body.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        // Abaikan link khusus
        if (
            link.target === '_blank' ||
            link.hasAttribute('download') ||
            link.href === '#' ||
            link.href === '' ||
            !link.href ||
            link.hasAttribute('onclick') ||
            link.getAttribute('onclick') ||
            (link.href && link.href.startsWith('javascript:')) ||
            !link.href.startsWith(window.location.origin) ||
            link.href.includes('#') ||
            link.href.includes('/logout')
        ) {
            return;
        }

        e.preventDefault();
        navigateTo(link.href);
    });

    window.addEventListener('popstate', () => {
        location.reload();
    });

});
</script>
    </body>
</html>