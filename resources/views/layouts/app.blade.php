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
    </head>

    <body id="main-body" 
          class="preload font-sans antialiased bg-slate-50 text-slate-800 selection:bg-blue-200 selection:text-blue-900"
          x-data="{ sidebarKecil: localStorage.getItem('sidebarState') === 'true', siapAnimasi: false }" 
          x-init="setTimeout(() => { document.body.classList.remove('preload'); siapAnimasi = true; }, 100)"
          @sidebar-toggle.window="sidebarKecil = $event.detail">

        <div class="min-h-screen flex">

            @include('layouts.navigation')

            <div class="flex flex-col flex-1 min-w-0"
                 :class="{
                     'ml-20': sidebarKecil,
                     'ml-64': !sidebarKecil,
                     'transition-[margin] duration-300 ease-in-out': siapAnimasi
                 }">

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

                <div class="flex flex-col flex-1 relative">
                    
                    <div id="content-wrapper" class="flex-1 w-full transition-all duration-300 ease-out flex flex-col" style="opacity: 1; transform: translateY(0);">
                        
                        @isset($header)
                            <header class="bg-white/50 backdrop-blur-sm border-b border-slate-200 shadow-sm w-full shrink-0">
                                <div class="px-8 py-6">{{ $header }}</div>
                            </header>
                        @endisset

                        <main class="p-8 w-full flex-1">
                            {{ $slot }}
                        </main>

                        @if(session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: '{{ session('success') }}',
                                confirmButtonColor: '#3b82f6',
                                timer: 2500,
                                showConfirmButton: false,
                                customClass: { popup: 'rounded-2xl' }
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
                                customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-6' }
                            });
                        </script>
                        @endif
                    </div>
                    <footer class="w-full py-5 text-center text-sm text-slate-500 border-t border-slate-200 bg-white/50 backdrop-blur-sm shrink-0">
                        &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
                    </footer>

                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.body.addEventListener('click', async function(e) {

                const link = e.target.closest('a');
                if (!link) return;

                if (
                    link.target === '_blank' ||
                    link.hasAttribute('download') ||
                    link.classList.contains('no-spa') ||
                    !link.href.startsWith(window.location.origin) ||
                    link.href.includes('#') ||
                    link.href.includes('/export') ||
                    link.href.includes('/export-pdf') ||
                    link.href.includes('/download') ||
                    link.href.includes('/logout')
                ) {
                    return;
                }

                e.preventDefault();

                const wrapper = document.getElementById('content-wrapper');

                if (!wrapper) {
                    window.location.href = link.href;
                    return;
                }

                wrapper.style.transition = 'all .25s ease';
                wrapper.style.opacity = '.3';
                wrapper.style.transform = 'translateY(10px)';

                try {

                    const response = await fetch(link.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const type = response.headers.get('content-type');

                    if (!type || !type.includes('text/html')) {
                        window.location.href = link.href;
                        return;
                    }

                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newWrapper = doc.getElementById('content-wrapper');

                    if (!newWrapper) {
                        window.location.href = link.href;
                        return;
                    }

                    wrapper.innerHTML = newWrapper.innerHTML;

                    const currentNavLinks = document.querySelectorAll('nav a, nav button, aside a');
                    const newNavLinks = doc.querySelectorAll('nav a, nav button, aside a');

                    if (currentNavLinks.length === newNavLinks.length) {
                       const stateClasses = [
                            'bg-blue-500/15', 'bg-blue-500/10', 'bg-slate-800/50', 
                            'text-blue-400', 'text-white', 'font-semibold', 'shadow-sm',
                            'text-slate-400', 'text-slate-500', 
                            'hover:bg-slate-800/60', 'hover:bg-slate-800/50', 
                            'hover:text-slate-200', 'hover:text-slate-300'
                        ];

                        currentNavLinks.forEach((el, index) => {
                            stateClasses.forEach(cls => {
                                if (newNavLinks[index] && newNavLinks[index].classList.contains(cls)) {
                                    el.classList.add(cls);
                                } else {
                                    el.classList.remove(cls);
                                }
                            });
                        });
                    }

                    document.title = doc.title;
                    history.pushState({}, '', link.href);

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    wrapper.querySelectorAll("script").forEach(oldScript => {
                        const newScript = document.createElement("script");

                        if (oldScript.src) {
                            newScript.src = oldScript.src;
                        } else {
                            newScript.textContent = oldScript.textContent;
                        }

                        document.body.appendChild(newScript);
                        document.body.removeChild(newScript);
                    });

                    wrapper.style.opacity = '1';
                    wrapper.style.transform = 'translateY(0)';

                } catch (err) {
                    wrapper.style.opacity = '1';
                    wrapper.style.transform = 'translateY(0)';
                    window.location.href = link.href;
                }

            });

            window.addEventListener('popstate', () => {
                location.reload();
            });

        });
        </script>
    </body>
</html>