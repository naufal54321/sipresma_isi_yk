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
    <script>
    // ═══ HERO CAROUSEL — harus sebelum Alpine CDN ═══
    @php
        $dashUrl = url('/dashboard');
        $loginUrl = route('login');
        $registerUrl = route('register');
        $isAuth = auth()->check();
    @endphp
    window.heroCarousel = function() {
        return {
            active: 0, timer: null,
            init() { this.startTimer(); },
            startTimer() { this.timer = setInterval(() => { this.next(); }, 5000); },
            stopTimer() { clearInterval(this.timer); },
            next() { this.active = (this.active + 1) % 3; this.stopTimer(); this.startTimer(); },
            prev() { this.active = (this.active - 1 + 3) % 3; this.stopTimer(); this.startTimer(); },
            goTo(i) { this.active = i; this.stopTimer(); this.startTimer(); },
        };
    };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        .text-gradient-gold { background: linear-gradient(135deg, #D4AF37, #FED65B); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
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
        .carousel-container { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; }
        .carousel-container > div { scroll-snap-align: start; }
        .carousel-dot { transition: all 0.3s ease; }
        .carousel-btn { transition: all 0.3s ease; opacity: 0; }
        .carousel-wrapper:hover .carousel-btn { opacity: 1; }
        .feature-icon { transition: all 0.3s ease; }
        .feature-card:hover .feature-icon { transform: scale(1.1) rotate(5deg); }
        .step-connector { height: 2px; flex: 1; background: linear-gradient(90deg, #D4AF37, #1A2B4C); }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col antialiased selection:bg-secondary selection:text-white">

<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-transparent backdrop-blur-xl border-b border-white/20 transition-all duration-300" id="navbar">
    <div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="PRATAMA Logo" class="h-10 w-10 object-contain rounded-md">
            <span class="navbar-logo-text font-title-lg text-title-lg font-bold text-white hidden sm:block">PRATAMA</span>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a class="nav-link text-white font-bold border-b-2 border-white pb-1 transition-colors hover:opacity-80" href="#" data-target="hero">Beranda</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#tentang" data-target="tentang">Tentang</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#fitur" data-target="fitur">Fitur</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#alur" data-target="alur">Alur</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#prestasi" data-target="prestasi">Prestasi</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#statistik" data-target="statistik">Statistik</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#kontak" data-target="kontak">Kontak</a>
        </div>
        <div class="flex gap-3" id="navButtons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md flex items-center gap-2 shadow-lg shadow-black/10">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span> Dashboard
                </a>
            @else
                <a id="loginBtn" href="{{ route('login') }}" class="px-6 py-2 rounded-full font-label-md text-label-md hidden md:block border border-white/70 text-white hover:bg-white/10 transition-all">Login</a>
                <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Carousel -->
@php
    $dashUrl = url('/dashboard');
    $loginUrl = route('login');
    $registerUrl = route('register');
    $isAuth = auth()->check();
@endphp
<div x-data="heroCarousel()" x-init="init()" 
     class="relative h-screen min-h-[600px] max-h-[900px] overflow-hidden bg-primary group" id="heroCarousel">
    
    {{-- Slide 1 --}}
<div class="absolute inset-0 transition-all duration-700 ease-in-out"
     :class="active === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
    <img src="{{ asset('images/slide1.jpg') }}" alt="PRATAMA" class="w-full h-full object-cover" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/85 via-primary/60 to-primary/30"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white max-w-4xl mx-auto px-4 md:px-8 -mt-16">
            <span class="inline-block py-1 px-4 rounded-full bg-white/15 text-white font-label-md text-label-md mb-6 border border-white/20 backdrop-blur-sm">Institut Seni Indonesia Yogyakarta</span>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-white max-w-4xl mx-auto mb-6 leading-tight">
                Prestasi dan <span class="text-gradient-gold">Talenta Mahasiswa</span>
            </h1>
            <p class="font-body-lg text-body-lg text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform digital resmi Institut Seni Indonesia Yogyakarta untuk mendokumentasikan, mengelola, dan mengembangkan prestasi serta talenta mahasiswa secara profesional.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if($isAuth)
                    <a href="{{ $dashUrl }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                        Dashboard <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                @else
                    <a href="{{ $loginUrl }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                        Jelajahi Prestasi <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                    <a href="{{ $registerUrl }}" class="px-8 py-3.5 rounded-full font-label-md text-label-md w-full sm:w-auto justify-center text-center border-2 border-white/40 text-white hover:bg-white/10 transition-all">
                        Daftar Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

    {{-- Slide 2 --}}
    <div class="absolute inset-0 transition-all duration-700 ease-in-out"
         :class="active === 1 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
        <img src="{{ asset('images/slide2.jpg') }}" alt="Mahasiswa" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/85 via-primary/60 to-primary/30"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white max-w-4xl mx-auto px-4 md:px-8 -mt-16">
                <span class="inline-block py-1 px-4 rounded-full bg-white/15 text-white font-label-md text-label-md mb-6 border border-white/20 backdrop-blur-sm">Dokumentasi Prestasi</span>
                <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-white max-w-4xl mx-auto mb-6 leading-tight">
                    Catat Setiap <span class="text-gradient-gold">Pencapaian</span>
                </h1>
                <p class="font-body-lg text-body-lg text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Dari lomba seni, pameran karya, hingga penelitian — semua prestasi terdokumentasi rapi dalam satu platform.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ $isAuth ? $dashUrl : $registerUrl }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                        {{ $isAuth ? "Dashboard" : "Mulai Sekarang" }} <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 3 --}}
    <div class="absolute inset-0 transition-all duration-700 ease-in-out"
         :class="active === 2 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
        <img src="{{ asset('images/slide3.jpg') }}" alt="Kegiatan Akademik" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/85 via-primary/60 to-primary/30"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white max-w-4xl mx-auto px-4 md:px-8 -mt-16">
                <span class="inline-block py-1 px-4 rounded-full bg-white/15 text-white font-label-md text-label-md mb-6 border border-white/20 backdrop-blur-sm">Validasi Terpadu</span>
                <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-white max-w-4xl mx-auto mb-6 leading-tight">
                    Verifikasi oleh <span class="text-gradient-gold">Dosen & Admin</span>
                </h1>
                <p class="font-body-lg text-body-lg text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Sistem validasi berjenjang memastikan setiap data prestasi yang diajukan telah diperiksa dan disahkan dengan benar.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ $isAuth ? $dashUrl : '#tentang' }}" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                        {{ $isAuth ? "Dashboard" : "Pelajari Lebih Lanjut" }} <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
        <button @click="goTo(0)" :class="active === 0 ? 'w-10 bg-white' : 'w-3 bg-white/50 hover:bg-white/70'" class="h-3 rounded-full transition-all duration-500 cursor-pointer"></button>
        <button @click="goTo(1)" :class="active === 1 ? 'w-10 bg-white' : 'w-3 bg-white/50 hover:bg-white/70'" class="h-3 rounded-full transition-all duration-500 cursor-pointer"></button>
        <button @click="goTo(2)" :class="active === 2 ? 'w-10 bg-white' : 'w-3 bg-white/50 hover:bg-white/70'" class="h-3 rounded-full transition-all duration-500 cursor-pointer"></button>
    </div>

    {{-- Arrow buttons --}}
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-all cursor-pointer opacity-0 group-hover:opacity-100">
        <span class="material-symbols-outlined text-[28px]">chevron_left</span>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-all cursor-pointer opacity-0 group-hover:opacity-100">
        <span class="material-symbols-outlined text-[28px]">chevron_right</span>
    </button>
</div>

<!-- Content Area -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 flex-1 w-full">

    {{-- ═══ 1. TENTANG PRATAMA ═══ --}}
    <section id="tentang" class="scroll-mt-20 mb-12 animate-on-scroll">
        <div class="modern-card p-8 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-secondary-fixed/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary-fixed/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <span class="inline-block py-1 px-3 rounded-full bg-secondary-fixed/30 text-on-secondary-container font-label-md text-label-md mb-4">Tentang Platform</span>
                <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary mb-6">Apa itu <span class="text-gradient">PRATAMA</span>?</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl mb-8 leading-relaxed">
                    <strong class="text-primary">PRATAMA</strong> (Prestasi dan Talenta Mahasiswa) adalah platform digital resmi 
                    <strong class="text-primary">Institut Seni Indonesia Yogyakarta</strong> yang digunakan untuk mendokumentasikan, 
                    mengelola, dan mengembangkan prestasi serta talenta mahasiswa secara profesional dan terstruktur.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-surface-container-low/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed/30 text-secondary flex items-center justify-center shrink-0 feature-icon">
                            <span class="material-symbols-outlined text-[28px]">emoji_events</span>
                        </div>
                        <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Catat Prestasi</h3><p class="text-body-md text-body-md text-on-surface-variant mt-1">Dokumentasikan setiap pencapaian akademik dan non-akademik.</p></div>
                    </div>
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-surface-container-low/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed/30 text-secondary flex items-center justify-center shrink-0 feature-icon">
                            <span class="material-symbols-outlined text-[28px]">verified</span>
                        </div>
                        <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Validasi Terpadu</h3><p class="text-body-md text-body-md text-on-surface-variant mt-1">Verifikasi oleh dosen pembimbing dan admin secara berjenjang.</p></div>
                    </div>
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-surface-container-low/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed/30 text-secondary flex items-center justify-center shrink-0 feature-icon">
                            <span class="material-symbols-outlined text-[28px]">bar_chart</span>
                        </div>
                        <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Analisis Data</h3><p class="text-body-md text-body-md text-on-surface-variant mt-1">Lihat statistik dan laporan prestasi secara real-time.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ 2. FITUR UTAMA ═══ --}}
    <section id="fitur" class="scroll-mt-20 mb-12 animate-on-scroll" style="transition-delay: 0.1s">
        <div class="text-center mb-8">
            <span class="inline-block py-1 px-3 rounded-full bg-secondary-fixed/30 text-on-secondary-container font-label-md text-label-md mb-4">Fitur Platform</span>
            <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Fitur <span class="text-gradient">Utama</span></h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $fitur = [
                ['icon' => 'description', 'title' => 'RPK', 'desc' => 'Rencana Prestasi Kemahasiswaan — catat rencana kegiatan semester'],
                ['icon' => 'verified', 'title' => 'SPK', 'desc' => 'Satuan Prestasi Kemahasiswan — upload bukti prestasi dan sertifikat'],
                ['icon' => 'upload_file', 'title' => 'Upload Dokumen', 'desc' => 'Upload PDF, JPG, PNG — surat tugas, sertifikat, foto, laporan'],
                ['icon' => 'groups', 'title' => 'Kolaborasi Tim', 'desc' => 'Tambah anggota kelompok untuk kegiatan kategori kelompok'],
                ['icon' => 'shield', 'title' => 'Validasi Berjenjang', 'desc' => 'Verifikasi oleh dosen pembimbing dan admin'],
                ['icon' => 'bar_chart', 'title' => 'Laporan & Export', 'desc' => 'Export data ke CSV, Excel multi-sheet, dan PDF'],
            ];
            @endphp
            @foreach($fitur as $f)
            <div class="modern-card p-6 feature-card hover:-translate-y-2 cursor-default">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-secondary-fixed/40 to-secondary/10 text-secondary flex items-center justify-center mb-4 feature-icon">
                    <span class="material-symbols-outlined text-[32px]">{{ $f['icon'] }}</span>
                </div>
                <h3 class="font-title-lg text-title-lg font-bold text-primary mb-2">{{ $f['title'] }}</h3>
                <p class="text-body-md text-body-md text-on-surface-variant">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══ 3. ALUR ═══ --}}
<section id="alur" class="scroll-mt-20 mb-12 animate-on-scroll" style="transition-delay: 0.2s">
    <div class="text-center mb-8">
        <span class="inline-block py-1 px-3 rounded-full bg-secondary-fixed/30 text-on-secondary-container font-label-md text-label-md mb-4">Bagaimana Alurnya</span>
        <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Alur <span class="text-gradient">Penggunaan</span></h2>
    </div>
    <div class="modern-card p-8 md:p-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 md:gap-4">
            <div class="text-center flex-1">
                <div class="w-20 h-20 rounded-2xl bg-primary text-on-primary flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-[40px]">person</span>
                </div>
                <span class="inline-block py-0.5 px-2 rounded-full bg-secondary-fixed/40 text-on-secondary-container font-label-md text-[11px] mb-2">Langkah 1</span>
                <h3 class="font-title-lg text-title-lg font-bold text-primary">Mahasiswa</h3>
                <p class="text-body-md text-body-md text-on-surface-variant mt-1">Buat RPK & SPK, upload dokumen prestasi</p>
            </div>
            <div class="hidden md:block">
                <span class="material-symbols-outlined text-4xl text-secondary">arrow_forward</span>
            </div>
            <div class="md:hidden">
                <span class="material-symbols-outlined text-3xl text-secondary rotate-90 block">arrow_forward</span>
            </div>
            <div class="text-center flex-1">
                <div class="w-20 h-20 rounded-2xl bg-primary text-on-primary flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-[40px]">school</span>
                </div>
                <span class="inline-block py-0.5 px-2 rounded-full bg-secondary-fixed/40 text-on-secondary-container font-label-md text-[11px] mb-2">Langkah 2</span>
                <h3 class="font-title-lg text-title-lg font-bold text-primary">Dosen</h3>
                <p class="text-body-md text-body-md text-on-surface-variant mt-1">Verifikasi dan validasi RPK & SPK mahasiswa bimbingan</p>
            </div>
            <div class="hidden md:block">
                <span class="material-symbols-outlined text-4xl text-secondary">arrow_forward</span>
            </div>
            <div class="md:hidden">
                <span class="material-symbols-outlined text-3xl text-secondary rotate-90 block">arrow_forward</span>
            </div>
            <div class="text-center flex-1">
                <div class="w-20 h-20 rounded-2xl bg-primary text-on-primary flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-[40px]">admin_panel_settings</span>
                </div>
                <span class="inline-block py-0.5 px-2 rounded-full bg-secondary-fixed/40 text-on-secondary-container font-label-md text-[11px] mb-2">Langkah 3</span>
                <h3 class="font-title-lg text-title-lg font-bold text-primary">Admin</h3>
                <p class="text-body-md text-body-md text-on-surface-variant mt-1">Kelola master data, poin, dan laporan prestasi</p>
            </div>
        </div>
    </div>
</section>

    

    {{-- ═══ 4. STATS + CHARTS (PALING BAWAH) ═══ --}}
    <div id="statistik"></div>

    {{-- Stats Cards --}}
    <div class="w-screen relative left-1/2 -translate-x-1/2 px-margin-mobile md:px-margin-desktop bg-surface-container-low/50 py-8 mb-8 border-y border-outline-variant/30">
        <div class="max-w-container-max mx-auto">
            <div class="text-center mb-6">
                <span class="inline-block py-1 px-3 rounded-full bg-secondary-fixed/30 text-on-secondary-container font-label-md text-label-md mb-2">Statistik</span>
                <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Data <span class="text-gradient">Prestasi</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
                @php
                $cards = [
                    ['label' => 'Total Mahasiswa', 'value' => number_format($totalMahasiswa, 0, ',', '.'), 'raw' => $totalMahasiswa, 'color' => 'blue', 'icon' => 'group', 'delay' => '0.1s'],
                    ['label' => 'SPK (Draft / Disetujui)', 'value' => $spkDraft . ' / ' . $spkDisetujui, 'raw' => null, 'color' => 'orange', 'icon' => 'emoji_events', 'delay' => '0.2s'],
                    ['label' => 'Mahasiswa Berprestasi', 'value' => number_format($mahasiswaBerprestasi, 0, ',', '.'), 'raw' => $mahasiswaBerprestasi, 'color' => 'purple', 'icon' => 'workspace_premium', 'delay' => '0.3s'],
                ];
                @endphp
                @foreach($cards as $card)
                <div class="modern-card p-6 flex justify-between items-center group animate-on-scroll" style="transition-delay: {{ $card['delay'] }}">
                    <div class="min-w-0">
                        <p class="text-on-surface-variant text-[11px] font-bold mb-1 uppercase tracking-widest">{{ $card['label'] }}</p>
                        <p class="text-4xl font-extrabold text-primary transition-colors mt-1 counter-value" @if($card['raw']) data-value="{{ $card['raw'] }}" @endif>{{ $card['value'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-primary-fixed/30 to-secondary-fixed/20 text-primary w-16 h-16 rounded-2xl flex items-center justify-center shadow-inner shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">{{ $card['icon'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <section id="prestasi" class="scroll-mt-20">
        <div class="text-center mb-6">
            <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Visualisasi <span class="text-gradient">Data</span></h2>
        </div>

        <div class="modern-card flex flex-col h-[500px] overflow-hidden mb-8 animate-on-scroll">
            <div class="px-6 py-5 border-b border-outline-variant/30"><h3 class="font-title-lg text-title-lg font-bold text-primary flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-primary-fixed/20 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">bar_chart</span></div>Statistik Prestasi Prodi ({{ date('Y') }})</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="prestasiChart"></canvas></div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
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
    </section>

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
    // ═══ ALPINE CAROUSEL COMPONENT ═══
    window.carousel = function() {
        return {
            activeDot: 0,
            init() { this.updateDot(); },
            scrollTo(track, dir) {
                const amount = track.clientWidth;
                const target = dir === 'next' ? track.scrollLeft + amount : track.scrollLeft - amount;
                track.scrollTo({ left: target, behavior: 'smooth' });
                setTimeout(() => this.updateDot(), 400);
            },
            goTo(track, index) {
                track.scrollTo({ left: index * track.clientWidth, behavior: 'smooth' });
                this.activeDot = index;
            },
            updateDot() {
                const track = document.getElementById('carouselTrack');
                if (!track) return;
                const index = Math.round(track.scrollLeft / track.clientWidth);
                this.activeDot = index;
            }
        };
    };

    // ═══ NAVBAR SCROLL EFFECT ═══
    const navbar = document.getElementById('navbar');
    const logoText = document.querySelector('.navbar-logo-text');
    const loginBtn = document.getElementById('loginBtn');
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section[id], main [id]');
    const ACTIVE_CLASS = 'nav-link text-secondary font-bold border-b-2 border-secondary pb-1 transition-colors hover:opacity-80';
    const INACTIVE_CLASS = 'nav-link text-primary hover:text-secondary transition-colors';
    const ACTIVE_CLASS_HERO = 'nav-link text-white font-bold border-b-2 border-white pb-1 transition-colors hover:opacity-80';
    const INACTIVE_CLASS_HERO = 'nav-link text-white/80 hover:text-white transition-colors';

    function setNavbarStyle(mode) {
        const isHero = mode === 'hero';
        
        if (!isHero) {
            navbar.classList.add('bg-white/90', 'shadow-sm');
            navbar.classList.remove('bg-transparent');
            logoText?.classList.remove('text-white');
            logoText?.classList.add('text-primary');
            if (loginBtn) {
                loginBtn.className = 'px-6 py-2 rounded-full font-label-md text-label-md hidden md:block btn-outline';
            }
        } else {
            navbar.classList.remove('bg-white/90', 'shadow-sm');
            navbar.classList.add('bg-transparent');
            logoText?.classList.add('text-white');
            logoText?.classList.remove('text-primary');
            if (loginBtn) {
                loginBtn.className = 'px-6 py-2 rounded-full font-label-md text-label-md hidden md:block border border-white/70 text-white hover:bg-white/10 transition-all';
            }
        }
    }

    function updateNavbarActive() {
        const isHero = window.scrollY < window.innerHeight * 0.6;
        setNavbarStyle(isHero ? 'hero' : 'content');

        let current = 'hero';
        sections.forEach(section => {
            const top = section.getBoundingClientRect().top;
            if (top <= 250) current = section.id;
        });

        navLinks.forEach(link => {
            const target = link.dataset.target;
            if (isHero) {
                link.className = target === current ? ACTIVE_CLASS_HERO : INACTIVE_CLASS_HERO;
            } else {
                link.className = target === current ? ACTIVE_CLASS : INACTIVE_CLASS;
            }
        });
    }

    window.addEventListener('scroll', updateNavbarActive);
    updateNavbarActive();

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

    // ═══ CAROUSEL AUTO-SLIDE ═══
    const track = document.getElementById('carouselTrack');
    if (track) {
        let autoSlide = setInterval(() => {
            const maxScroll = track.scrollWidth - track.clientWidth;
            const next = track.scrollLeft + track.clientWidth;
            track.scrollTo({ left: next > maxScroll ? 0 : next, behavior: 'smooth' });
        }, 4000);
        track.addEventListener('mouseenter', () => clearInterval(autoSlide));
        track.addEventListener('mouseleave', () => {
            autoSlide = setInterval(() => {
                const maxScroll = track.scrollWidth - track.clientWidth;
                const next = track.scrollLeft + track.clientWidth;
                track.scrollTo({ left: next > maxScroll ? 0 : next, behavior: 'smooth' });
            }, 4000);
        });
    }

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
