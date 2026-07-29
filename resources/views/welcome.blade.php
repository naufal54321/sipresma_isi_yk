<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name', 'PRATAMA') }} — Prestasi & Talenta Mahasiswa ISI Yogyakarta</title>

    <meta name="description" content="PRATAMA — Platform digital resmi Institut Seni Indonesia Yogyakarta untuk mendokumentasikan, mengelola, dan mengembangkan prestasi serta talenta mahasiswa.">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="PRATAMA — Prestasi & Talenta Mahasiswa ISI Yogyakarta">
    <meta property="og:description" content="Platform digital resmi ISI Yogyakarta untuk prestasi dan talenta mahasiswa.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo_isi_dashboard.png') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">

    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $cssFile = $manifest['resources/css/app.css']['file'] ?? '';
        $jsFile = $manifest['resources/js/app.js']['file'] ?? '';
    @endphp
    <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    <script defer src="{{ asset('build/' . $jsFile) }}"></script>
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
        const btnLogin = '{{ $loginUrl }}';
        const btnReg = '{{ $registerUrl }}';
        const btnDash = '{{ $dashUrl }}';
        const isAuth = {{ $isAuth ? 'true' : 'false' }};
        const badge = 'Institut Seni Indonesia Yogyakarta';
        const title = 'Prestasi dan Talenta Mahasiswa';
        const desc = 'Sistem informasi resmi ISI Yogyakarta untuk pengelolaan prestasi dan talenta mahasiswa.';
        const slides = [
            { image: '{{ asset("images/slide4.webp") }}', alt: 'PRATAMA' },
            { image: '{{ asset("images/slide5.webp") }}', alt: 'Mahasiswa' },
            { image: '{{ asset("images/slide6.webp") }}', alt: 'Kegiatan Akademik' },
        ];
        return {
            active: 0, slides: slides, badge: badge, title: title, desc: desc,
            btnLogin: btnLogin, btnReg: btnReg, btnDash: btnDash, isAuth: isAuth,
            init() { this.int = setInterval(() => { this.next() }, 10000); }, destroy() { clearInterval(this.int); },
            next() { this.active = (this.active + 1) % this.slides.length; },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length; },
            goTo(i) { this.active = i; },
        };
    };
    </script>
    <style>
        /* ═══ WARNA BIRU DONGKER & AKSEN BIRU NAVY ═══ */
        :root {
            --primary-navy: #0A1929;      /* Navy sangat gelap */
            --primary-dongker: #1E3A8A;   /* Dongker */
            --accent-blue: #2563EB;       /* Biru aksen */
            --accent-light: #3B82F6;      /* Biru terang */
            --surface-navy: #F0F4FF;      /* Latar belakang navy muda */
        }
        
        .btn-primary { background-color: var(--primary-dongker); color: #ffffff; transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,58,138,0.3); }
        .btn-outline { border: 1.5px solid var(--primary-dongker); color: var(--primary-dongker); transition: all 0.3s ease; }
        .btn-outline:hover { background-color: var(--primary-dongker); color: #ffffff; }
        .modern-card { background: rgba(255,255,255,0.78); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.5); box-shadow: 0px 4px 20px rgba(10,25,41,0.06); transition: all 0.3s ease; transform: perspective(800px) rotateX(0deg); }
        .modern-card:hover { transform: perspective(800px) rotateX(1.5deg) translateY(-4px); box-shadow: 0px 8px 30px rgba(10,25,41,0.12); border-color: var(--accent-blue); background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); }
        .text-gradient { background: linear-gradient(135deg, var(--primary-dongker), var(--primary-navy)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .text-gradient-blue { background: linear-gradient(135deg, var(--accent-blue), var(--accent-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .bg-subtle-pattern { background-image: radial-gradient(circle at 1px 1px, rgba(10,25,41,0.04) 1px, transparent 0); background-size: 40px 40px; }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
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
        .feature-icon { transition: all 0.3s ease; }
        .feature-card:hover .feature-icon { transform: scale(1.1) rotate(5deg); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; height: 2px; background: var(--accent-blue); transition: width 0.3s ease; width: 0; border-radius: 2px; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.text-white::after { background: #ffffff; }
        .nav-link.text-white.font-bold.border-b-2::after { display: none; }
        .btn-primary:active { transform: scale(0.97) !important; }
        @keyframes heroZoom { 0% { transform: scale(1); } 100% { transform: scale(1.08); } }
        .animate-hero-zoom { animation: heroZoom 15s ease-out forwards; }

        /* ═══ KUSTOMISASI TEMA BIRU NAVY ═══ */
        .bg-secondary { background-color: var(--accent-blue) !important; }
        .text-secondary { color: var(--accent-blue) !important; }
        .bg-secondary-fixed\/30 { background-color: rgba(37, 99, 235, 0.3) !important; }
        .bg-secondary-fixed\/40 { background-color: rgba(37, 99, 235, 0.4) !important; }
        .bg-secondary\/10 { background-color: rgba(37, 99, 235, 0.1) !important; }
        .bg-secondary\/20 { background-color: rgba(37, 99, 235, 0.2) !important; }
        .bg-secondary\/5 { background-color: rgba(37, 99, 235, 0.05) !important; }
        .text-on-secondary-container { color: var(--primary-dongker) !important; }
        .text-on-secondary { color: #ffffff !important; }
        .bg-secondary-container-high { background-color: var(--surface-navy) !important; }
        .shadow-secondary\/20 { box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2) !important; }
        .hover\:text-secondary:hover { color: var(--accent-blue) !important; }
        .hover\:text-secondary-fixed:hover { color: var(--accent-blue) !important; }
        .hover\:bg-secondary-fixed\/20:hover { background-color: rgba(37, 99, 235, 0.2) !important; }
        .text-secondary-fixed { color: var(--accent-blue) !important; }
        
        /* ═══ PERBAIKAN KHUSUS UNTUK IKON FITUR ═══ */
        .feature-card .feature-icon {
            color: var(--primary-dongker) !important;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.15), rgba(37, 99, 235, 0.05)) !important;
        }
        
        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.25), rgba(37, 99, 235, 0.15)) !important;
            color: var(--primary-navy) !important;
        }
        
        /* ═══ PERBAIKAN UNTUK BADGE DAN TAG ═══ */
        .badge-tag {
            background-color: rgba(37, 99, 235, 0.3) !important;
            color: var(--primary-dongker) !important;
        }
    </style>
</head>
<body class="bg-background bg-subtle-pattern text-on-surface font-body-md min-h-screen flex flex-col antialiased selection:bg-secondary selection:text-white">

<div x-data="{ mobileOpen: false }">
<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-transparent transition-all duration-300" id="navbar" aria-label="Navigasi Utama">
    <div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="PRATAMA Logo" class="h-12 w-12 object-contain rounded-md">
            <div class="navbar-logo-text hidden sm:block text-white">
                <span class="font-title-lg text-title-lg font-bold leading-tight block">PRATAMA</span>
                <span class="text-[10px] tracking-[0.2em] font-semibold mt-0.5 block opacity-60">Institut Seni Indonesia Yogyakarta</span>
            </div>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a class="nav-link text-white font-bold border-b-2 border-white pb-1 transition-colors hover:opacity-80" href="#" data-target="hero">Beranda</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#tentang" data-target="tentang">Tentang</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#fitur" data-target="fitur">Fitur</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="#alur" data-target="alur">Alur</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="{{ url('/statistik') }}" data-target="statistik">Statistik</a>
            <a class="nav-link text-white/80 hover:text-white transition-colors" href="{{ url('/kontak') }}">Kontak</a>
        </div>
        <div class="hidden md:flex gap-3" id="navButtons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md flex items-center gap-2 shadow-lg shadow-black/10">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span> Dashboard
                </a>
            @else
                <a id="loginBtn" href="{{ route('login') }}" class="px-6 py-2 rounded-full font-label-md text-label-md hidden md:block border border-white/70 text-white hover:bg-white/10 transition-all">Login</a>
                <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md">Register</a>
            @endauth
        </div>
        {{-- Hamburger button --}}
        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white p-2 ml-2" aria-label="Toggle menu">
            <span x-show="!mobileOpen" class="material-symbols-outlined text-[28px] block">menu</span>
            <span x-show="mobileOpen" class="material-symbols-outlined text-[28px] block" style="display:none">close</span>
        </button>
    </div>
</nav>

{{-- Mobile menu drawer --}}
<div x-show="mobileOpen" class="fixed inset-0 z-40 bg-primary backdrop-blur-xl md:hidden flex flex-col items-center justify-center"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-4">
    <div class="flex flex-col items-center gap-8 text-white text-xl">
        <a @click="mobileOpen = false" href="#" class="font-bold border-b-2 border-white pb-1">Beranda</a>
        <a @click="mobileOpen = false" href="#tentang" class="text-white/80 hover:text-white transition-colors">Tentang</a>
        <a @click="mobileOpen = false" href="#fitur" class="text-white/80 hover:text-white transition-colors">Fitur</a>
        <a @click="mobileOpen = false" href="#alur" class="text-white/80 hover:text-white transition-colors">Alur</a>
        <a @click="mobileOpen = false" href="{{ url('/statistik') }}" class="text-white/80 hover:text-white transition-colors">Statistik</a>
        <a @click="mobileOpen = false" href="{{ url('/kontak') }}" class="text-white/80 hover:text-white transition-colors">Kontak</a>
        <div class="mt-4 flex gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-8 py-3 rounded-full font-label-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-full font-label-md">Login</a>
                <a href="{{ route('register') }}" class="px-8 py-3 rounded-full font-label-md border-2 border-white/40 text-white hover:bg-white/10">Daftar</a>
            @endauth
        </div>
    </div>
</div>

<!-- Hero Carousel -->
<div x-data="heroCarousel()" x-init="init()" 
     class="relative h-screen min-h-[400px] sm:min-h-[600px] max-h-[900px] overflow-hidden bg-primary group" id="heroCarousel"
     role="region" aria-roledescription="carousel" aria-label="Hero Slideshow">
    
    {{-- Hero decorative shapes — menggunakan biru navy transparan --}}
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-secondary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary-fixed-dim/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.04)_0%,transparent_70%)] pointer-events-none"></div>

    {{-- Slides (Alpine x-for) --}}
    <template x-for="(s, i) in slides" :key="i">
        <div class="absolute inset-0 transition-[opacity,transform] duration-[2000ms] ease-out"
             :class="active === i ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0 scale-100'">
            <img :src="s.image" :alt="s.alt" class="w-full h-full object-cover" :class="active === i ? 'animate-hero-zoom' : ''" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/85 via-primary/60 to-primary/30"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white max-w-4xl mx-auto px-4 md:px-8 -mt-16">
                    <span class="inline-block py-1 px-4 rounded-full bg-white/15 text-white font-label-md text-label-md mb-6 border border-white/20 backdrop-blur-sm" x-text="badge"></span>
                    <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-white max-w-4xl mx-auto mb-6 leading-tight" x-html="title"></h1>
                    <p class="font-body-lg text-body-lg text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed" x-text="desc"></p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <template x-if="isAuth">
                            <a :href="btnDash" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                                Dashboard <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </a>
                        </template>
                        <template x-if="!isAuth">
                            <a :href="btnLogin" class="btn-primary px-8 py-3.5 rounded-full font-label-md text-label-md flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg shadow-black/10">
                                Jelajahi Prestasi <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </a>
                            <a :href="btnReg" class="px-8 py-3.5 rounded-full font-label-md text-label-md w-full sm:w-auto justify-center text-center border-2 border-white/40 text-white hover:bg-white/10 transition-all">
                                Daftar Sekarang
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- Navigation dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
        <template x-for="(s, i) in slides" :key="i">
            <button @click="goTo(i)" :class="active === i ? 'w-10 bg-white' : 'w-3 bg-white/50 hover:bg-white/70'" class="h-3 rounded-full transition-all duration-500 cursor-pointer"></button>
        </template>
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
<div class="flex-1 w-full">

    {{-- ═══ 1. TENTANG PRATAMA ═══ --}}
    <section id="tentang" class="scroll-mt-20 animate-on-scroll bg-white border-b border-outline-variant/40"><div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="modern-card p-0 overflow-hidden">
            <div class="flex flex-col md:flex-row">
                {{-- Left: Image --}}
                <div class="md:w-1/2 min-h-[300px] md:min-h-full relative overflow-hidden">
                    <img src="{{ asset('images/tentang.jpg') }}" alt="Kegiatan Mahasiswa ISI Yogyakarta" class="w-full h-full object-cover absolute inset-0" loading="lazy" onerror="this.src='{{ asset('images/tentang.jpg') }}'">
                    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-primary/50 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 z-10">
                        <span class="text-white/80 text-xs font-semibold tracking-wider"></span>
                    </div>
                </div>
                {{-- Right: Content --}}
                <div class="md:w-1/2 p-8 md:p-12">
                    <span class="inline-block py-1 px-3 rounded-full badge-tag font-label-md text-label-md mb-4">Tentang Platform</span>
                    <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary mb-6">Apa itu <span class="text-gradient">PRATAMA</span>?</h2>
                    <p class="text-body-md text-on-surface-variant leading-relaxed mb-8">
                        <strong class="text-primary">PRATAMA</strong> (Prestasi dan Talenta Mahasiswa) adalah platform digital resmi 
                        <strong class="text-primary">Institut Seni Indonesia Yogyakarta</strong> yang digunakan untuk mendokumentasikan, 
                        mengelola, dan mengembangkan prestasi serta talenta mahasiswa secara transparan dan akuntabel.
                    </p>
                    <div class="space-y-1">
                        <div class="flex items-start gap-1.5 p-1.5 rounded-xl hover:bg-surface-container-low/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg feature-icon flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.15), rgba(37, 99, 235, 0.05)); color: var(--primary-dongker);">
                                <span class="material-symbols-outlined text-[18px]">emoji_events</span>
                            </div>
                            <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Kelola Data Prestasi</h3><p class="text-body-md text-on-surface-variant">Dokumentasikan setiap pencapaian akademik dan non-akademik.</p></div>
                        </div>
                        <div class="flex items-start gap-1.5 p-1.5 rounded-xl hover:bg-surface-container-low/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg feature-icon flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.15), rgba(37, 99, 235, 0.05)); color: var(--primary-dongker);">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                            </div>
                            <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Verifikasi Terpadu</h3><p class="text-body-md text-on-surface-variant">Verifikasi oleh dosen pembimbing dan admin secara berjenjang.</p></div>
                        </div>
                        <div class="flex items-start gap-1.5 p-1.5 rounded-xl hover:bg-surface-container-low/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg feature-icon flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.15), rgba(37, 99, 235, 0.05)); color: var(--primary-dongker);">
                                <span class="material-symbols-outlined text-[18px]">bar_chart</span>
                            </div>
                            <div><h3 class="font-title-lg text-title-lg font-bold text-primary">Akses Data</h3><p class="text-body-md text-on-surface-variant">Lihat statistik dan laporan prestasi secara real-time.</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    {{-- ═══ 2. FITUR UTAMA ═══ --}}
    <section id="fitur" class="scroll-mt-20 animate-on-scroll bg-secondary-container-high border-b border-outline-variant/40" style="transition-delay: 0.1s"><div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="text-center mb-8">
            <span class="inline-block py-1 px-3 rounded-full badge-tag font-label-md text-label-md mb-4">Fitur Platform</span>
            <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Fitur <span class="text-gradient">Utama</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
            $fitur = [
                ['icon' => 'description', 'title' => 'RPK', 'desc' => 'Rencana Prestasi Kemahasiswaan — Input rencana kegiatan semester'],
                ['icon' => 'verified', 'title' => 'SPK', 'desc' => 'Unggah bukti prestasi dan sertifikat kegiatan'],
                ['icon' => 'upload_file', 'title' => 'Unggah Dokumen', 'desc' => 'Unggah PDF, JPG, PNG — surat tugas, sertifikat, foto, laporan'],
                ['icon' => 'groups', 'title' => 'Kolaborasi Tim', 'desc' => 'Tambah anggota kelompok untuk kegiatan kategori kelompok'],
                ['icon' => 'shield', 'title' => 'Verifikasi Berjenjang', 'desc' => 'Verifikasi oleh dosen pembimbing dan admin'],
                ['icon' => 'bar_chart', 'title' => 'Laporan Prestasi', 'desc' => 'Ekspor laporan prestasi dalam Excel dan PDF'],
            ];
            @endphp
            @foreach($fitur as $i => $f)
            <div class="modern-card p-5 feature-card hover:-translate-y-1.5 cursor-default flex flex-col items-center text-center gap-3">
                <!-- IKON DENGAN WARNA BIRU NAVY YANG SUDAH DIPERBAIKI -->
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 feature-icon mx-auto" 
                     style="background: linear-gradient(135deg, rgba(10, 25, 41, 0.15), rgba(30, 58, 138, 0.08)); color: #0A1929;">
                    <span class="material-symbols-outlined text-[32px]">{{ $f['icon'] }}</span>
                </div>
                <div>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary mb-1">{{ $f['title'] }}</h3>
                    <p class="text-body-md text-on-surface-variant">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

    {{-- ═══ 3. ALUR ═══ --}}
<section id="alur" class="scroll-mt-20 animate-on-scroll bg-white border-b border-outline-variant/40" style="transition-delay: 0.2s"><div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
    <div class="text-center mb-8">
        <span class="inline-block py-1 px-3 rounded-full badge-tag font-label-md text-label-md mb-4">Bagaimana Alurnya?</span>
        <h2 class="font-display-lg-mobile md:font-headline-md text-headline-md text-primary">Alur <span class="text-gradient">Penggunaan</span></h2>
    </div>
    <div class="modern-card p-8 md:p-10">
        <div class="relative ml-2 md:ml-6 space-y-10">
            {{-- Step 1 --}}
            <div class="relative pl-12 md:pl-16">
                <div class="absolute left-0 top-1 w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 z-10">
                    <span class="material-symbols-outlined text-lg">description</span>
                </div>
                <div class="absolute left-[17px] top-10 bottom-[-40px] w-0.5 bg-primary/20"></div>
                <div>
                    <span class="inline-block py-0.5 px-2 rounded-full badge-tag font-label-md text-[11px] mb-1">Tahap 1</span>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary">Buat RPK</h3>
                    <p class="text-body-md text-on-surface-variant mt-1">Mahasiswa membuat RPK (Rencana Prestasi Kemahasiswaan) dan mengisi kegiatan yang direncanakan.</p>
                </div>
            </div>
            {{-- Step 2 --}}
            <div class="relative pl-12 md:pl-16">
                <div class="absolute left-0 top-1 w-9 h-9 rounded-full bg-secondary text-on-secondary flex items-center justify-center shadow-lg shadow-secondary/20 z-10">
                    <span class="material-symbols-outlined text-lg">fact_check</span>
                </div>
                <div class="absolute left-[17px] top-10 bottom-[-40px] w-0.5 bg-secondary/20"></div>
                <div>
                    <span class="inline-block py-0.5 px-2 rounded-full badge-tag font-label-md text-[11px] mb-1">Tahap 2</span>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary">Verifikasi RPK oleh Dosen</h3>
                    <p class="text-body-md text-on-surface-variant mt-1">Dosen pembimbing melakukan peninjauan dan verifikasi terhadap RPK yang diajukan mahasiswa.</p>
                </div>
            </div>
            {{-- Step 3 --}}
            <div class="relative pl-12 md:pl-16">
                <div class="absolute left-0 top-1 w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 z-10">
                    <span class="material-symbols-outlined text-lg">verified</span>
                </div>
                <div class="absolute left-[17px] top-10 bottom-[-40px] w-0.5 bg-primary/20"></div>
                <div>
                    <span class="inline-block py-0.5 px-2 rounded-full badge-tag font-label-md text-[11px] mb-1">Tahap 3</span>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary">Buat SPK</h3>
                    <p class="text-body-md text-on-surface-variant mt-1">Setelah RPK memperoleh persetujuan, mahasiswa mengajukan SPK (Satuan Prestasi Kemahasiswaan) dengan melengkapi seluruh dokumen pendukung.</p>
                </div>
            </div>
            {{-- Step 4 --}}
            <div class="relative pl-12 md:pl-16">
                <div class="absolute left-0 top-1 w-9 h-9 rounded-full bg-secondary text-on-secondary flex items-center justify-center shadow-lg shadow-secondary/20 z-10">
                    <span class="material-symbols-outlined text-lg">approval</span>
                </div>
                <div class="absolute left-[17px] top-10 bottom-[-40px] w-0.5 bg-secondary/20"></div>
                <div>
                    <span class="inline-block py-0.5 px-2 rounded-full badge-tag font-label-md text-[11px] mb-1">Tahap 4</span>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary">Verifikasi SPK oleh Dosen</h3>
                    <p class="text-body-md text-on-surface-variant mt-1">Dosen pembimbing melakukan verifikasi terhadap pengajuan SPK beserta dokumen pendukung yang telah diunggah mahasiswa.</p>
                </div>
            </div>
            {{-- Step 5 --}}
            <div class="relative pl-12 md:pl-16">
                <div class="absolute left-0 top-1 w-9 h-9 rounded-full bg-primary-container text-on-secondary flex items-center justify-center shadow-lg shadow-primary/20 z-10">
                    <span class="material-symbols-outlined text-lg">workspace_premium</span>
                </div>
                <div>
                    <span class="inline-block py-0.5 px-2 rounded-full badge-tag font-label-md text-[11px] mb-1">Tahap 5</span>
                    <h3 class="font-title-lg text-title-lg font-bold text-primary">Poin & Laporan oleh Admin</h3>
                    <p class="text-body-md text-on-surface-variant mt-1">Setelah SPK disetujui, Admin menetapkan poin prestasi sesuai ketentuan, serta mengelola rekapitulasi dan laporan prestasi mahasiswa.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

    

    {{-- ═══ 4. LINK STATISTIK ═══ --}}
    <section class="text-center animate-on-scroll bg-secondary-container-high border-b border-outline-variant/40"><div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="modern-card p-10 inline-block mx-auto">
            <span class="material-symbols-outlined text-5xl mb-4" style="color: #0A1929;">bar_chart</span>
            <h2 class="font-headline-md text-headline-md font-bold text-primary mb-2">Lihat Statistik Lengkap</h2>
            <p class="text-body-md text-on-surface-variant mb-6">Data prestasi, chart, dan rekap terbaru dalam satu halaman.</p>
            <a href="{{ url('/statistik') }}" class="btn-primary px-8 py-3 rounded-full font-label-md text-label-md inline-flex items-center gap-2">
                Buka Halaman Statistik <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

</div>

<!-- Footer -->
<footer class="bg-primary text-on-primary w-full mt-auto relative overflow-hidden border-t border-white/10" id="kontak">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-24 bg-secondary-fixed/10 blur-[80px] rounded-full pointer-events-none z-0"></div>

    <div class="relative z-10 px-margin-mobile md:px-margin-desktop py-16 md:py-24 max-w-container-max mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            
            <!-- Kolom 1: Brand -->
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="PRATAMA Logo" class="h-14 w-14 object-contain rounded-md">
                    <div>
                        <span class="font-title-lg text-title-lg font-bold leading-tight block">PRATAMA</span>
                        <span class="text-[11px] tracking-[0.15em] font-semibold mt-1 block text-on-primary/60">Institut Seni Indonesia Yogyakarta</span>
                    </div>
                </div>
                <p class="font-body-md text-body-md text-on-primary/70 leading-relaxed">
                    Platform digital resmi yang mendukung proses pencatatan, pengelolaan, verifikasi, dan pelaporan prestasi serta talenta mahasiswa ISI Yogyakarta secara terintegrasi.
                </p>
            </div>

            <!-- Kolom 2: Direktori -->
            <div class="flex flex-col gap-6">
                <h4 class="font-title-lg text-title-lg font-bold text-secondary-fixed tracking-wide">Direktori</h4>
                <div class="grid grid-cols-2 gap-x-4 gap-y-3 font-body-md text-body-md">
                    <div class="flex flex-col gap-3">
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 group" href="https://akademik.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>Akademik
                        </a>
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 group" href="https://kemahasiswaan.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>Kemahasiswaan
                        </a>
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 group" href="https://lppm.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>LPPM
                        </a>
                        <div class="relative" x-data="{ uptOpen: false }">
                            <button @click="uptOpen = !uptOpen" @click.away="uptOpen = false" class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 w-full text-left group">
                                <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>UPT
                                <span class="material-symbols-outlined text-[16px] transition-transform duration-300" :class="uptOpen ? 'rotate-180' : ''">expand_more</span>
                            </button>
                            <div x-show="uptOpen" x-transition class="absolute z-50 mt-2 ml-4 space-y-2 bg-primary/95 backdrop-blur-md rounded-lg p-3 border border-white/20 shadow-xl min-w-[180px]">
                                <a href="https://lib.isi.ac.id/" class="text-on-primary/60 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 text-sm">Perpustakaan</a>
                                <a href="https://galerirjkatamsi.isi.ac.id/" class="text-on-primary/60 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 text-sm">Galeri R.J. Katamsi</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-start gap-2 group leading-tight" href="https://www.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300 mt-0.5">arrow_right_alt</span>
                            <span>Web ISI</span>
                        </a>
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-start gap-2 group leading-tight" href="https://lsp.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300 mt-0.5">arrow_right_alt</span>
                            <span>Lembaga Sertifikasi Profesi</span>
                        </a>
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 group" href="https://vartasarasvati.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>Varta Sarasvati
                        </a>
                        <a class="text-on-primary/70 hover:text-secondary-fixed transition-all duration-300 flex items-center gap-2 group" href="https://slc.isi.ac.id/">
                            <span class="material-symbols-outlined text-[16px] opacity-0 -ml-4 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300">arrow_right_alt</span>Sanggar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom 3: Kontak -->
            <div class="flex flex-col gap-6">
                <h4 class="font-title-lg text-title-lg font-bold text-secondary-fixed tracking-wide">Hubungi Kami</h4>
                <div class="flex flex-col gap-5 font-body-md text-body-md text-on-primary/70">
                    <div class="flex items-start gap-3 group cursor-default">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-[#1E3A8A] group-hover:text-white group-hover:scale-110">
                            <span class="material-symbols-outlined text-[20px]">location_on</span>
                        </div>
                        <div>
                            <span class="text-white font-semibold text-sm block mb-1">Alamat</span>
                            <span class="group-hover:text-[#93C5FD] transition-colors duration-300 leading-relaxed text-sm">Jl. Parangtritis Km. 6,5 Sewon, Bantul, Yogyakarta 55188</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 group">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-[#1E3A8A] group-hover:text-white group-hover:scale-110">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <div>
                            <span class="text-white font-semibold text-sm block mb-1">Email</span>
                            <a href="mailto:kemahasiswaan@isi.ac.id" class="hover:text-[#93C5FD] transition-colors duration-300 text-sm">kemahasiswaan@isi.ac.id</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 group">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-[#1E3A8A] group-hover:text-white group-hover:scale-110">
                            <span class="material-symbols-outlined text-[20px]">call</span>
                        </div>
                        <div>
                            <span class="text-white font-semibold text-sm block mb-1">Telepon</span>
                            <a href="tel:+62274374485" class="hover:text-[#93C5FD] transition-colors duration-300 text-sm">(0274) 374485</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="flex flex-col items-center gap-5 pt-8 pb-2 border-t border-white/10">
            <span class="text-white font-semibold text-sm tracking-wider uppercase">Ikuti Kami</span>
            <div class="flex gap-4 flex-wrap justify-center items-center">
                <a href="https://twitter.com/isiyk_official" target="_blank" rel="noopener noreferrer" class="group w-14 h-14 rounded-full bg-white/5 flex items-center justify-center transition-all duration-300 hover:bg-[#1DA1F2] hover:scale-110 hover:shadow-lg hover:shadow-[#1DA1F2]/25" title="Twitter"><svg class="w-7 h-7 text-white/70 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                <a href="https://instagram.com/isiyogyakarta_official" target="_blank" rel="noopener noreferrer" class="group w-14 h-14 rounded-full bg-white/5 flex items-center justify-center transition-all duration-300 hover:bg-gradient-to-br hover:from-[#833AB4] hover:via-[#FD1D1D] hover:to-[#F77737] hover:scale-110 hover:shadow-lg hover:shadow-[#E4405F]/25" title="Instagram"><svg class="w-7 h-7 text-white/70 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                <a href="https://www.facebook.com/ISIJOGJA/" target="_blank" rel="noopener noreferrer" class="group w-14 h-14 rounded-full bg-white/5 flex items-center justify-center transition-all duration-300 hover:bg-[#1877F2] hover:scale-110 hover:shadow-lg hover:shadow-[#1877F2]/25" title="Facebook"><svg class="w-7 h-7 text-white/70 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                <a href="https://www.youtube.com/@ISIYogyakartaOfficial" target="_blank" rel="noopener noreferrer" class="group w-14 h-14 rounded-full bg-white/5 flex items-center justify-center transition-all duration-300 hover:bg-[#FF0000] hover:scale-110 hover:shadow-lg hover:shadow-[#FF0000]/25" title="YouTube"><svg class="w-7 h-7 text-white/70 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                <a href="https://www.tiktok.com/@isiyogyakarta_official" target="_blank" rel="noopener noreferrer" class="group w-14 h-14 rounded-full bg-white/5 flex items-center justify-center transition-all duration-300 hover:bg-white hover:scale-110 hover:shadow-lg hover:shadow-white/25" title="TikTok"><svg class="w-7 h-7 text-white/70 group-hover:text-[#000000] transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg></a>
            </div>
        </div>
    </div>

    <div class="relative z-10 border-t border-white/10 bg-black/10">
        <div class="px-margin-mobile md:px-margin-desktop py-6 max-w-container-max mx-auto flex justify-center items-center">
            <p class="font-body-md text-sm text-on-primary/60 text-center">&copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta</p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
        
        navbar.classList.remove('bg-transparent', 'bg-white/90', 'shadow-sm');
        logoText?.classList.remove('text-white', 'text-primary');
        
        if (!isHero) {
            navbar.classList.add('bg-white/90', 'shadow-sm');
            logoText?.classList.add('text-primary');
            if (loginBtn) {
                loginBtn.className = 'px-6 py-2 rounded-full font-label-md text-label-md hidden md:block btn-outline';
            }
        } else {
            navbar.classList.add('bg-transparent');
            logoText?.classList.add('text-white');
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
            const isCurrent = target === current;
            if (isHero) {
                link.className = isCurrent ? ACTIVE_CLASS_HERO : INACTIVE_CLASS_HERO;
            } else {
                link.className = isCurrent ? ACTIVE_CLASS : INACTIVE_CLASS;
            }
            if (isCurrent) link.setAttribute('aria-current', 'page');
            else link.removeAttribute('aria-current');
        });
    }

    window.addEventListener('scroll', updateNavbarActive);
    updateNavbarActive();

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