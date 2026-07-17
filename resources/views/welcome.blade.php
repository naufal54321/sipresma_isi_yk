<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name', 'PRATAMA') }} — Prestasi & Talenta Mahasiswa ISI Yogyakarta</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Montserrat:wght@600;700;900&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "error": "#ba1a1a", "on-tertiary": "#ffffff", "error-container": "#ffdad6",
                        "surface-dim": "#cfdaf1", "on-error-container": "#93000a", "surface-bright": "#f9f9ff",
                        "surface-container-high": "#dee8ff", "primary": "#031636", "on-secondary-container": "#745c00",
                        "outline-variant": "#c5c6cf", "surface": "#f9f9ff", "on-tertiary-fixed-variant": "#454748",
                        "inverse-surface": "#263142", "on-surface-variant": "#44474e", "secondary": "#735c00",
                        "tertiary-container": "#292c2d", "secondary-fixed": "#ffe088", "surface-container": "#e7eeff",
                        "on-surface": "#111c2c", "on-primary": "#ffffff", "on-primary-container": "#8293ba",
                        "primary-fixed-dim": "#b6c6f0", "primary-container": "#1a2b4c", "tertiary-fixed": "#e1e3e4",
                        "secondary-container": "#fed65b", "on-error": "#ffffff", "on-secondary-fixed-variant": "#574500",
                        "primary-fixed": "#d8e2ff", "tertiary-fixed-dim": "#c5c7c8", "surface-variant": "#d8e3fa",
                        "surface-container-lowest": "#ffffff", "on-background": "#111c2c", "surface-tint": "#4e5e82",
                        "tertiary": "#151819", "on-secondary": "#ffffff", "on-primary-fixed-variant": "#364669",
                        "on-tertiary-fixed": "#191c1d", "inverse-primary": "#b6c6f0", "surface-container-low": "#f0f3ff",
                        "on-primary-fixed": "#071b3b", "secondary-fixed-dim": "#e9c349", "on-secondary-fixed": "#241a00",
                        "outline": "#75777f", "inverse-on-surface": "#ebf1ff", "background": "#f9f9ff",
                        "surface-container-highest": "#d8e3fa", "on-tertiary-container": "#919394"
                    },
                    borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
                    spacing: { gutter: "24px", unit: "8px", "container-max": "1280px", "margin-mobile": "16px", "margin-desktop": "40px" },
                    fontFamily: { "body-lg": ["Inter"], "label-md": ["Inter"], "headline-md": ["Montserrat"], "title-lg": ["Montserrat"], "body-md": ["Inter"], "display-lg": ["Montserrat"], "display-lg-mobile": ["Montserrat"] },
                    fontSize: {
                        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "label-md": ["14px", { lineHeight: "1", letterSpacing: "0.05em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "600" }],
                        "title-lg": ["20px", { lineHeight: "1.4", fontWeight: "600" }],
                        "body-md": ["16px", { lineHeight: "1.6", fontWeight: "400" }],
                        "display-lg": ["48px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "display-lg-mobile": ["32px", { lineHeight: "1.2", fontWeight: "700" }]
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
                        'float-slow': 'floatSlow 6s ease-in-out infinite',
                        'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                        'gradient-move': 'gradientMove 8s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideInLeft: { '0%': { opacity: '0', transform: 'translateX(-40px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        slideInRight: { '0%': { opacity: '0', transform: 'translateX(40px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        floatSlow: { '0%, 100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-10px)' } },
                        bounceGentle: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-5px)' } },
                        pulseSoft: { '0%, 100%': { opacity: '1' }, '50%': { opacity: '0.6' } },
                        gradientMove: { '0%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' }, '100%': { backgroundPosition: '0% 50%' } },
                    }
                }
            }
        }
    </script>

    <style>
        .glass-panel { background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0px 4px 20px rgba(26,43,76,0.06); }
        .btn-primary { background-color: #D4AF37; color: #ffffff; transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(212,175,55,0.3); }
        .btn-outline { border: 1.5px solid #1A2B4C; color: #1A2B4C; transition: all 0.3s ease; }
        .btn-outline:hover { background-color: #1A2B4C; color: #ffffff; }
        .modern-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0px 4px 20px rgba(26,43,76,0.06); transition: all 0.3s ease; }
        .modern-card:hover { transform: translateY(-4px); box-shadow: 0px 8px 30px rgba(26,43,76,0.12); border-color: #D4AF37; }
        .text-gradient { background: linear-gradient(135deg, #1A2B4C, #031636); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .animate-on-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .animate-on-scroll.animate-visible { opacity: 1; transform: translateY(0); }
        .animate-on-scroll-left { opacity: 0; transform: translateX(-40px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .animate-on-scroll-left.animate-visible { opacity: 1; transform: translateX(0); }
        .animate-on-scroll-right { opacity: 0; transform: translateX(40px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .animate-on-scroll-right.animate-visible { opacity: 1; transform: translateX(0); }
        .counter-value { display: inline-block; transition: all 0.3s ease; }
        html { scroll-behavior: smooth; }
        .rekap-scroll::-webkit-scrollbar { width: 4px; }
        .rekap-scroll::-webkit-scrollbar-track { background: transparent; }
        .rekap-scroll::-webkit-scrollbar-thumb { background: #c5c6cf; border-radius: 10px; }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col antialiased selection:bg-secondary selection:text-white">

<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-transparent backdrop-blur-xl border-b border-white/20 transition-all duration-300" id="navbar">
    <div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_isi_welcome.png') }}" alt="PRATAMA Logo" class="h-10 w-10 object-contain rounded-md">
            <span class="font-title-lg text-title-lg font-bold text-primary dark:text-primary-fixed hidden sm:block">PRATAMA</span>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a class="text-secondary font-bold border-b-2 border-secondary pb-1 transition-colors hover:opacity-80" href="#">Beranda</a>
            <a class="text-primary dark:text-primary-fixed-dim hover:text-secondary transition-colors hover:opacity-80" href="#prestasi">Prestasi</a>
            <a class="text-primary dark:text-primary-fixed-dim hover:text-secondary transition-colors hover:opacity-80" href="#statistik">Statistik</a>
            <a class="text-primary dark:text-primary-fixed-dim hover:text-secondary transition-colors hover:opacity-80" href="#kontak">Kontak</a>
        </div>
        <div class="flex gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline px-6 py-2 rounded-full font-label-md text-label-md hidden md:block">Login</a>
                <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Section -->
<header class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden flex flex-col items-center justify-center min-h-[90vh]" id="heroParallax">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-b from-surface-bright/80 via-surface-bright/90 to-background"></div>
    </div>
    <div class="relative z-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center animate-fade-in">
        <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high text-primary font-label-md text-label-md mb-6 border border-primary/10">Institut Seni Indonesia Yogyakarta</span>
        <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary max-w-4xl mx-auto mb-6">
            Prestasi dan <span class="text-gradient">Talenta Mahasiswa</span>
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-10">
            Platform digital resmi Institut Seni Indonesia Yogyakarta untuk mendokumentasikan, mengelola, dan mengembangkan prestasi serta talenta mahasiswa secara profesional.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center">
                    Dashboard <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center">
                    Jelajahi Prestasi <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
                <a href="{{ route('register') }}" class="btn-outline px-8 py-3.5 rounded-full font-label-md text-label-md w-full sm:w-auto justify-center text-center">
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</header>

<!-- Content Area -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 flex-1 w-full">

    <!-- Stats Cards - Full Width -->
    <div class="w-screen relative left-1/2 -translate-x-1/2 px-margin-mobile md:px-margin-desktop bg-surface-container-low/50 py-8 mb-8 border-y border-outline-variant/30">
        <div class="max-w-container-max mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
                @php
                $cards = [
                    ['label' => 'Total Mahasiswa', 'value' => number_format($totalMahasiswa, 0, ',', '.'), 'raw' => $totalMahasiswa, 'color' => 'blue', 'icon' => 'fa-users', 'delay' => '0.1s'],
                    ['label' => 'SPK (Draft / Disetujui)', 'value' => $spkDraft . ' / ' . $spkDisetujui, 'raw' => null, 'color' => 'orange', 'icon' => 'fa-medal', 'delay' => '0.2s'],
                    ['label' => 'Mahasiswa Berprestasi', 'value' => number_format($mahasiswaBerprestasi, 0, ',', '.'), 'raw' => $mahasiswaBerprestasi, 'color' => 'purple', 'icon' => 'fa-trophy', 'delay' => '0.3s'],
                ];
                $welcomeGradientBar = ['blue' => 'from-blue-400 to-blue-600', 'orange' => 'from-orange-400 to-orange-600', 'purple' => 'from-purple-400 to-purple-600'];
                $welcomeHoverText = ['blue' => 'group-hover:text-blue-600', 'orange' => 'group-hover:text-orange-600', 'purple' => 'group-hover:text-purple-600'];
                $welcomeIconBg = ['blue' => 'from-blue-50 to-blue-100/50', 'orange' => 'from-orange-50 to-orange-100/50', 'purple' => 'from-purple-50 to-purple-100/50'];
                $welcomeIconColor = ['blue' => 'text-blue-500', 'orange' => 'text-orange-500', 'purple' => 'text-purple-500'];
                @endphp
                @foreach($cards as $card)
                <div class="modern-card p-6 flex justify-between items-center group animate-on-scroll" style="transition-delay: {{ $card['delay'] }}">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r {{ $welcomeGradientBar[$card['color']] }} transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500" style="position:absolute;top:0;left:0;"></div>
                    <div class="min-w-0">
                        <p class="text-on-surface-variant text-[11px] font-bold mb-1 uppercase tracking-widest">{{ $card['label'] }}</p>
                        <p class="text-4xl font-extrabold text-primary {{ $welcomeHoverText[$card['color']] }} transition-colors mt-1 counter-value" @if($card['raw']) data-value="{{ $card['raw'] }}" @endif>{{ $card['value'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br {{ $welcomeIconBg[$card['color']] }} {{ $welcomeIconColor[$card['color']] }} w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-inner shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-transform">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Section: Prestasi --}}
    <div id="prestasi" class="scroll-mt-20">
        <div class="modern-card flex flex-col h-[500px] overflow-hidden mb-8 animate-on-scroll hover-enhanced">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">bar_chart</span></div>Statistik Prestasi Prodi ({{ date('Y') }})</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="prestasiChart"></canvas></div>
        </div>
    </div>

    <div id="statistik" class="scroll-mt-20 grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
        <div class="xl:col-span-4 modern-card flex flex-col h-[500px] overflow-hidden relative animate-on-scroll-left">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">history</span></div>Rekap Prestasi Terbaru</h3></div>
            <div class="flex-1 overflow-y-auto p-2 rekap-scroll">
                @forelse($rekapPrestasi as $i => $spk)
                    <div class="p-4 hover:bg-surface-container-low/80 rounded-2xl transition-colors border-b border-outline-variant/20 last:border-0 flex items-start gap-4 rekap-item" style="transition-delay: {{ $i * 0.05 }}s">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-fixed/30 to-primary-container/30 text-primary flex items-center justify-center text-sm font-extrabold shrink-0">{{ substr($spk->user->name ?? 'A', 0, 1) }}</div>
                        <div class="flex-1 min-w-0"><h4 class="text-primary font-bold text-sm truncate">{{ $spk->user->name ?? 'Anonim' }}</h4><p class="text-xs text-on-surface-variant mt-1 line-clamp-2">{{ $spk->kegiatan->kegiatan ?? $spk->keterangan }}</p><div class="mt-2 flex items-center gap-2"><span class="bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-md text-[10px] font-bold uppercase">Disetujui</span>@if($spk->tingkat)<span class="text-[10px] font-semibold text-on-surface-variant uppercase border border-outline-variant/50 px-2 py-0.5 rounded-md">{{ $spk->tingkat }}</span>@endif</div></div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-on-surface-variant"><div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-3xl text-outline">inbox</span></div><p class="text-sm font-medium mt-3">Belum ada data disetujui.</p></div>
                @endforelse
            </div>
        </div>
        <div class="xl:col-span-8 modern-card flex flex-col h-[500px] overflow-hidden animate-on-scroll-right" style="transition-delay: 0.15s">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">layers</span></div>Prestasi Berdasarkan Tingkat</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="tingkatChart"></canvas></div>
        </div>
    </div>

    <div class="modern-card flex flex-col h-[400px] overflow-hidden mb-8 animate-on-scroll" style="transition-delay: 0.25s">
        <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">category</span></div>Distribusi Jenis Kegiatan</h3></div>
        <div class="p-6 flex-1 w-full relative flex items-center justify-center"><canvas id="jenisChart"></canvas></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
        <div class="xl:col-span-6 modern-card flex flex-col h-[400px] overflow-hidden animate-on-scroll-left" style="transition-delay: 0.35s">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">trending_up</span></div>Tren Prestasi Bulanan ({{ date('Y') }})</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="trenChart"></canvas></div>
        </div>
        <div class="xl:col-span-6 modern-card flex flex-col h-[400px] overflow-hidden animate-on-scroll-right" style="transition-delay: 0.45s">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">business</span></div>Top Penyelenggara Kegiatan</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="penyelenggaraChart"></canvas></div>
        </div>
    </div>

</main>

<!-- Footer -->
<footer class="bg-primary text-on-primary w-full mt-auto" id="kontak">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop py-20 max-w-container-max mx-auto">
        <div class="col-span-1 md:col-span-1 flex flex-col gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="PRATAMA Logo" class="h-12 w-12 object-contain rounded-md bg-white p-1">
                <span class="font-title-lg text-title-lg font-black text-on-primary">PRATAMA</span>
            </div>
            <p class="font-body-md text-body-md text-on-primary/80">
                Sistem Informasi Prestasi dan Talenta Mahasiswa.<br/>
                Institut Seni Indonesia Yogyakarta.
            </p>
        </div>
        <div class="col-span-1">
            <h4 class="font-title-lg text-title-lg font-bold mb-6 text-secondary-fixed">Tautan Cepat</h4>
            <ul class="flex flex-col gap-3 font-body-md text-body-md">
                <li><a class="text-on-primary/70 hover:text-secondary-fixed transition-colors" href="#">Beranda</a></li>
                <li><a class="text-on-primary/70 hover:text-secondary-fixed transition-colors" href="#prestasi">Prestasi</a></li>
                <li><a class="text-on-primary/70 hover:text-secondary-fixed transition-colors" href="#statistik">Statistik</a></li>
            </ul>
        </div>
        <div class="col-span-1">
            <h4 class="font-title-lg text-title-lg font-bold mb-6 text-secondary-fixed">Informasi</h4>
            <ul class="flex flex-col gap-3 font-body-md text-body-md">
                <li><a class="text-on-primary/70 hover:text-secondary-fixed transition-colors" href="{{ route('login') }}">Masuk</a></li>
                <li><a class="text-on-primary/70 hover:text-secondary-fixed transition-colors" href="{{ route('register') }}">Daftar</a></li>
            </ul>
        </div>
        <div class="col-span-1">
            <h4 class="font-title-lg text-title-lg font-bold mb-6 text-secondary-fixed">Kontak</h4>
            <ul class="flex flex-col gap-3 font-body-md text-body-md text-on-primary/70">
                <li class="flex items-start gap-3"><span class="material-symbols-outlined text-[20px]">location_on</span><span>Jl. Parangtritis Km. 6,5 Sewon, Bantul, Yogyakarta 55188</span></li>
                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">mail</span><span>pratama@isi.ac.id</span></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10 py-6 px-margin-mobile md:px-margin-desktop text-center">
        <p class="font-body-md text-body-md text-on-primary/60">&copy; {{ date('Y') }} Institut Seni Indonesia Yogyakarta. PRATAMA — Prestasi &amp; Talenta Mahasiswa.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ═══ NAVBAR SCROLL EFFECT ═══
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 20) {
            navbar.classList.add('bg-white/90', 'shadow-sm');
            navbar.classList.remove('bg-transparent');
        } else {
            navbar.classList.remove('bg-white/90', 'shadow-sm');
            navbar.classList.add('bg-transparent');
        }
    });

    // ═══ CHART.JS ═══
    const cp = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#0ea5e9', '#14b8a6'];
    const tp = ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444', '#ec4899', '#0ea5e9', '#14b8a6'];
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#44474e';
    const tt = { backgroundColor: 'rgba(3, 22, 54, 0.95)', padding: 14, titleFont: { size: 13 }, bodyFont: { size: 15, weight: 'bold' }, cornerRadius: 12 };

    new Chart(document.getElementById('prestasiChart'), {
        type: 'bar', data: { labels: {!! json_encode($chartLabels) !!}, datasets: [{ data: {!! json_encode($chartData) !!}, backgroundColor: '#1a2b4c', borderRadius: 8, barPercentage: 0.6 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: tt }, animation: { duration: 1500, easing: 'easeOutQuart' }, scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' }, border: { display: false } }, x: { ticks: { maxRotation: 45, font: { size: 11 } }, grid: { display: false }, border: { display: false } } } }
    });

    const tl = {!! json_encode($tingkatLabels) !!}; const td = {!! json_encode($tingkatData) !!};
    new Chart(document.getElementById('tingkatChart'), {
        type: 'bar', data: { labels: tl, datasets: [{ data: td, backgroundColor: tl.map((_,i) => tp[i%8]), borderRadius: 8, barPercentage: 0.5 }] },
        options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', animation: { duration: 1500, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { ...tt, callbacks: { label: c => ` ${c.raw} Prestasi` } } }, scales: { x: { beginAtZero: true, grid: { color: '#e2e8f0' }, border: { display: false } }, y: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: '600' }, color: '#1a2b4c' } } } }
    });

    new Chart(document.getElementById('jenisChart'), {
        type: 'doughnut', data: { labels: {!! json_encode($jenisLabels) !!}, datasets: [{ data: {!! json_encode($jenisData) !!}, backgroundColor: cp, borderWidth: 0, hoverOffset: 10 }] },
        options: { responsive: true, maintainAspectRatio: false, animation: { animateScale: true, animateRotate: true, duration: 2000, easing: 'easeOutBounce' }, plugins: { legend: { position: 'right', labels: { padding: 20, usePointStyle: true, font: { size: 12 }, color: '#44474e' } }, tooltip: tt }, cutout: '70%' }
    });

    const tbl = {!! json_encode($trenBulanLabels) !!}; const tbd = {!! json_encode($trenBulanData) !!};
    new Chart(document.getElementById('trenChart'), {
        type: 'line', data: { labels: tbl, datasets: [{ label: 'Prestasi', data: tbd, borderColor: '#D4AF37', backgroundColor: 'rgba(212,175,55,0.08)', borderWidth: 3, tension: 0.4, fill: true, pointBackgroundColor: '#fff', pointBorderColor: '#D4AF37', pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6 }] },
        options: { responsive: true, maintainAspectRatio: false, animation: { duration: 1500, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: tt }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#e2e8f0' }, border: { display: false } }, x: { grid: { display: false }, border: { display: false } } } }
    });

    const pyl = {!! json_encode($penyelenggaraLabels) !!}; const pyd = {!! json_encode($penyelenggaraData) !!};
    new Chart(document.getElementById('penyelenggaraChart'), {
        type: 'bar', data: { labels: pyl, datasets: [{ data: pyd, backgroundColor: ['#1a2b4c','#D4AF37','#475569','#94a3b8','#cbd5e1'], borderRadius: 6, barPercentage: 0.5 }] },
        options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', animation: { duration: 1500, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { ...tt, callbacks: { label: c => ` ${c.raw} Kegiatan` } } }, scales: { x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#e2e8f0' }, border: { display: false } }, y: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: '600' }, color: '#1a2b4c' } } } }
    });

    // ═══ SCROLL-TRIGGERED ANIMATIONS ═══
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('animate-visible'); observer.unobserve(entry.target); } });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.animate-on-scroll, .animate-on-scroll-left, .animate-on-scroll-right, .rekap-item').forEach(el => observer.observe(el));

    // ═══ COUNTER ═══
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target; const target = parseInt(el.dataset.value);
                if (isNaN(target)) return;
                el.textContent = '0'; const duration = 1500; const startTime = performance.now();
                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime; const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3); const current = Math.floor(eased * target);
                    el.textContent = current.toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(updateCounter); else el.textContent = target.toLocaleString('id-ID');
                }
                requestAnimationFrame(updateCounter); counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    document.querySelectorAll('.counter-value[data-value]').forEach(el => counterObserver.observe(el));

    // ═══ SMOOTH SCROLL ═══
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const targetEl = document.querySelector(targetId);
            if (targetEl) { e.preventDefault(); targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });
});
</script>
</body>
</html>
