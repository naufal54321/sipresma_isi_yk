@php
    $sidebarCollapsed = false;
    if (isset($_COOKIE['sidebar_collapsed'])) {
        $sidebarCollapsed = $_COOKIE['sidebar_collapsed'] === '1';
    }
    
    // ⚡ NOTIFIKASI UNTUK ADMIN & DOSEN
    $notifRpk = 0;
    $notifSpk = 0;
    
    if (auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Dosen'))) {
        if (auth()->user()->hasRole('Admin')) {
            $notifRpk = \App\Models\Rpk::where('status', 'draft')->count();
            $notifSpk = \App\Models\Spk::where('status', 'draft')->count();
        } elseif (auth()->user()->hasRole('Dosen')) {
            $dosenId = auth()->id();
            $notifRpk = \App\Models\Rpk::where('dosen_pembimbing_id', $dosenId)->where('status', 'draft')->count();
            $notifSpk = \App\Models\Spk::whereHas('rpk', fn($q) => $q->where('dosen_pembimbing_id', $dosenId))->where('status', 'draft')->count();
        }
    }
@endphp

<nav id="sidebar-nav"
     x-data="{ 
         collapsed: {{ $sidebarCollapsed ? 'true' : 'false' }}, 
         siapAnimasi: false,
         mobileOpen: false
     }" 
     x-init="
         $watch('collapsed', val => {
             localStorage.setItem('sidebarState', val);
             document.cookie = 'sidebar_collapsed=' + (val ? '1' : '0') + ';path=/;max-age=31536000;SameSite=Lax';
             window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: val }));
         });
         window.addEventListener('sidebar-ready', () => {
             siapAnimasi = true;
             window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: collapsed }));
         });
         window.addEventListener('sidebar-mobile-toggle', () => { collapsed = false; mobileOpen = true; });
         window.addEventListener('sidebar-mobile-close', () => { mobileOpen = false; });
     "
     x-cloak
     class="fixed top-0 left-0 z-50 bottom-0 bg-slate-900 text-slate-300 shadow-2xl flex flex-col font-sans w-64 transition-[width,transform] duration-300 ease-in-out -translate-x-full lg:translate-x-0"
     :class="{
         'w-20': collapsed,
         'w-64': !collapsed,
         'translate-x-0': mobileOpen,
         'transition-none': !siapAnimasi
     }">

    {{-- Logo & Toggle --}}
    <div class="relative flex items-center py-5 border-b border-slate-800 bg-slate-900/50"
         :class="{
             'px-0 justify-center': collapsed,
             'px-6 gap-3': !collapsed,
             'transition-all duration-300': siapAnimasi
         }">
        
        <img src="{{ asset('images/logo_isi_dashboard.png') }}" class="w-11 h-11 object-contain shrink-0" alt="Logo" loading="lazy">
        
        <div x-show="!collapsed" class="whitespace-nowrap overflow-hidden">
            <h1 class="text-lg font-bold text-white tracking-tight leading-tight">PRATAMA</h1>
            <p class="text-[8.9px] text-slate-400 tracking-widest font-semibold mt-0.5">Prestasi dan Talenta Mahasiswa</p>
        </div>

        <button @click="
            collapsed = !collapsed; 
            $dispatch('sidebar-toggle', collapsed);
            window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: collapsed }));
        " 
                class="absolute -right-3.5 top-6 bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-500 text-slate-400 rounded-full p-1 z-50 transition-all duration-300 shadow-lg cursor-pointer hidden lg:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform transition-transform duration-300" :class="collapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- User Info --}}
    <div class="py-5 border-b border-slate-800 bg-slate-800/30 overflow-hidden"
         :class="{
             'px-2 flex justify-center': collapsed,
             'px-6': !collapsed,
             'transition-all duration-300': siapAnimasi
         }">
        
        <div x-show="!collapsed" class="overflow-hidden">
            <h2 class="font-semibold text-sm text-white break-words">{{ auth()->user()->name }}</h2>
            <p class="text-xs mt-1 font-medium flex flex-wrap gap-1">
                @foreach(auth()->user()->roles as $role)
                    @if($role->name == 'Admin')
                        <span class="text-red-400 bg-red-500/10 border border-red-500/20 px-2 py-0.5 rounded-md">{{ $role->name }}</span>
                    @elseif($role->name == 'Dosen')
                        <span class="text-purple-400 bg-purple-500/10 border border-purple-500/20 px-2 py-0.5 rounded-md">{{ $role->name }}</span>
                    @else
                        <span class="text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded-md">{{ $role->name }}</span>
                    @endif
                @endforeach
            </p>
        </div>

        <div x-show="collapsed" title="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold shadow-inner">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>

    {{-- Menu --}}
    <div class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden py-5 px-3 space-y-1.5 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

        <p x-show="!collapsed" class="px-3 mb-3 text-[11px] text-slate-400 uppercase tracking-wider font-bold whitespace-nowrap">Menu Utama</p>
        <p x-show="collapsed" class="text-center mb-3 text-[10px] text-slate-600 font-bold hidden md:block"><i class="fas fa-ellipsis-h"></i></p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" title="Home"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('dashboard') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Beranda</span>
        </a>

        {{-- ========== ADMIN MENU ========== --}}
        @role('Admin')

        {{-- RPK Admin --}}
        <a href="{{ route('admin.rpk.index') }}" title="Rencana Prestasi Kemahasiswaan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.rpk.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <div class="relative shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                </svg>
                @if($notifRpk > 0)
                    <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-lg shadow-red-500/30">
                        {{ $notifRpk > 99 ? '99+' : $notifRpk }}
                    </span>
                @endif
            </div>
            <div x-show="!collapsed" class="min-w-0 overflow-hidden">
                <span class="font-semibold text-sm block">RPK & Plotting Dosen</span>
                <span class="text-[11px] text-slate-400 block whitespace-nowrap">Rencana Prestasi Kemahasiswaan</span>
            </div>
        </a>

        {{-- SPK Admin --}}
        <a href="{{ route('admin.spk.index') }}" title="Satuan Prestasi Kemahasiswaan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.spk.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <div class="relative shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
                @if($notifSpk > 0)
                    <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-lg shadow-red-500/30">
                        {{ $notifSpk > 99 ? '99+' : $notifSpk }}
                    </span>
                @endif
            </div>
            <div x-show="!collapsed" class="min-w-0">
                <span class="font-semibold text-sm block">SPK</span>
                <span class="text-[11px] text-slate-400 block whitespace-nowrap">Satuan Prestasi Kemahasiswaan</span>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" title="Daftar Pengguna"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.users.index') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Daftar Pengguna</span>
        </a>

        <a href="{{ route('admin.kkm-rules.index') }}" title="Poin Kegiatan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.kkm-rules.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Poin Kegiatan</span>
        </a>

        <a href="{{ route('admin.prodi.index') }}" title="Master Prodi"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.prodi.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Master Prodi</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}" title="Laporan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Laporan</span>
        </a>
        @endrole

        {{-- ========== DOSEN MENU ========== --}}
        @role('Dosen')
        <a href="{{ route('dosen.mahasiswa.index') }}" title="Mahasiswa Bimbingan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('dosen.mahasiswa.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Mahasiswa Bimbingan</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('dosen.rpk.*', 'dosen.spk.*') ? 'true' : 'false' }} }">
            <button @click="
                if(collapsed) { 
                    collapsed = false; 
                    open = true; 
                    $dispatch('sidebar-toggle', false); 
                    window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: false }));
                } else { 
                    open = !open; 
                }
            " title="Verifikasi"
                    class="flex items-center w-full rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('dosen.rpk.*', 'dosen.spk.*') ? 'bg-slate-800/50 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
                    :class="{
                        'justify-center p-3': collapsed,
                        'justify-between px-3 py-2.5 hover:translate-x-1.5': !collapsed,
                        'transition-all duration-300': siapAnimasi
                    }">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                        @if($notifRpk + $notifSpk > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-lg shadow-red-500/30">
                                {{ $notifRpk + $notifSpk > 99 ? '99+' : $notifRpk + $notifSpk }}
                            </span>
                        @endif
                    </div>
                    <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Verifikasi</span>
                </div>
                <svg x-show="!collapsed" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform transition-transform duration-300" :class="open ? 'rotate-180 text-blue-400' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open && !collapsed" 
                 x-transition:enter="transition ease-out duration-300 transform origin-top"
                 x-transition:enter-start="opacity-0 scale-y-75 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-y-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform origin-top"
                 x-transition:leave-start="opacity-100 scale-y-100"
                 x-transition:leave-end="opacity-0 scale-y-75 -translate-y-2"
                 class="mt-1 space-y-1 pl-10 pr-2">
                
                {{-- RPK Dosen --}}
                <a href="{{ route('dosen.rpk.index') }}" title="Rencana Prestasi Kemahasiswaan" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transform transition-all duration-300 -mx-3 {{ request()->routeIs('dosen.rpk.*') ? 'text-blue-400 font-semibold bg-blue-500/10' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-800/50' }}">
                    <div class="relative shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                        </svg>
                        @if($notifRpk > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">
                                {{ $notifRpk > 99 ? '99+' : $notifRpk }}
                            </span>
                        @endif
                    </div>
                    <div x-show="!collapsed" class="min-w-0">
                        <span class="font-semibold text-sm block">RPK</span>
                        <span class="text-[10.5px] text-slate-400 block whitespace-nowrap">Rencana Prestasi Kemahasiswaan</span>
                    </div>
                </a>

                {{-- SPK Dosen --}}
                <a href="{{ route('dosen.spk.index') }}" title="Satuan Prestasi Kemahasiswaan" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transform transition-all duration-300 -mx-3 {{ request()->routeIs('dosen.spk.*') ? 'text-blue-400 font-semibold bg-blue-500/10' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-800/50' }}">
                    <div class="relative shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                        @if($notifSpk > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">
                                {{ $notifSpk > 99 ? '99+' : $notifSpk }}
                            </span>
                        @endif
                    </div>
                    <div x-show="!collapsed" class="min-w-0">
                        <span class="font-semibold text-sm block">SPK</span>
                        <span class="text-[10.5px] text-slate-400 block whitespace-nowrap">Satuan Prestasi Kemahasiswaan</span>
                    </div>
                </a>
            </div>
        </div>

        <a href="{{ route('dosen.laporan.index') }}" title="Laporan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('dosen.laporan.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            <span x-show="!collapsed" class="font-medium text-sm whitespace-nowrap">Laporan</span>
        </a>
        @endrole

        {{-- ========== MAHASISWA MENU ========== --}}
        @role('Mahasiswa')
        <a href="{{ route('rpks.index') }}" title="Rencana Prestasi Kemahasiswaan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('rpks.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
            </svg>
            <div x-show="!collapsed" class="min-w-0">
                <span class="font-medium text-sm whitespace-nowrap block">RPK</span>
                <span class="text-[10px] text-slate-500 block leading-tight">Rencana Prestasi Kemahasiswaan</span>
            </div>
        </a>

        <a href="{{ route('spks.index') }}" title="Satuan Prestasi Kemahasiswaan"
           class="flex items-center rounded-xl transform ease-out active:scale-95 {{ request()->routeIs('spks.*') ? 'bg-blue-500/15 text-blue-400 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
           :class="{
               'justify-center p-3': collapsed,
               'gap-3 px-3 py-2.5 hover:translate-x-1.5': !collapsed,
               'transition-all duration-300': siapAnimasi
           }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
            </svg>
            <div x-show="!collapsed" class="min-w-0">
                <span class="font-medium text-sm whitespace-nowrap block">SPK</span>
                <span class="text-[10px] text-slate-500 block leading-tight">Satuan Prestasi Kemahasiswaan</span>
            </div>
        </a>
        @endrole

        {{-- Logout --}}
        <div class="mt-6 pt-4 border-t border-slate-800 overflow-hidden"
             :class="{
                 'px-0': collapsed,
                 'px-1': !collapsed,
                 'transition-all duration-300': siapAnimasi
             }">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button title="Keluar" 
                        class="w-full flex items-center bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-xl text-sm font-semibold transform ease-out hover:-translate-y-1 active:scale-95 border border-red-500/20"
                        :class="{
                            'justify-center py-3': collapsed,
                            'justify-center gap-2 py-2.5': !collapsed,
                            'transition-all duration-300': siapAnimasi
                        }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Keluar</span>
                </button>
            </form>
        </div>

    </div>

    {{-- Backdrop mobile --}}
    <div x-show="mobileOpen" @click="window.dispatchEvent(new Event('sidebar-mobile-close'))"
         class="fixed inset-0 -z-10 bg-black/50 lg:hidden">
    </div>
</nav>