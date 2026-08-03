<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kontak — PRATAMA ISI Yogyakarta</title>

    <meta name="description" content="Hubungi Bagian Kemahasiswaan ISI Yogyakarta — informasi kontak resmi PRATAMA.">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="Kontak — PRATAMA ISI Yogyakarta">
    <meta property="og:description" content="Hubungi Bagian Kemahasiswaan ISI Yogyakarta untuk informasi lebih lanjut.">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Montserrat:wght@600;700;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.min.css') }}?v=1"/>
    <style>
        :root {
            --primary-navy: #0A1929;
            --primary-dongker: #1E3A8A;
            --accent-blue: #2563EB;
            --accent-light: #3B82F6;
            --surface-navy: #F0F4FF;
        }
        
        .btn-primary { background-color: var(--primary-dongker); color: #ffffff; transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,58,138,0.3); }
        .btn-outline { border: 1.5px solid var(--primary-dongker); color: var(--primary-dongker); transition: all 0.3s ease; }
        .btn-outline:hover { background-color: var(--primary-dongker); color: #ffffff; }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; height: 2px; background: var(--accent-blue); transition: width 0.3s ease; width: 0; border-radius: 2px; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.text-white::after { background: #ffffff; }
        .nav-link.text-white.font-bold.border-b-2::after { display: none; }
        .btn-primary:active { transform: scale(0.97) !important; }
        .modern-card { background: rgba(255,255,255,0.78); backdrop-filter: blur(16px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.5); box-shadow: 0px 4px 20px rgba(10,25,41,0.06); transition: all 0.3s ease; }
        .modern-card:hover { transform: translateY(-3px); box-shadow: 0px 8px 30px rgba(10,25,41,0.12); border-color: var(--accent-blue); }
        .text-gradient { background: linear-gradient(135deg, var(--primary-dongker), var(--primary-navy)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        html { scroll-behavior: smooth; }
        .bg-subtle-pattern { background-image: radial-gradient(circle at 1px 1px, rgba(10,25,41,0.04) 1px, transparent 0); background-size: 40px 40px; }
        .badge-tag { background-color: rgba(37, 99, 235, 0.3) !important; color: var(--primary-dongker) !important; }
        .text-secondary-fixed { color: var(--accent-blue) !important; }
        .hover\:text-secondary-fixed:hover { color: var(--accent-blue) !important; }
        .hover\:bg-secondary-fixed\/20:hover { background-color: rgba(37, 99, 235, 0.2) !important; }
    </style>
</head>
<body class="bg-background bg-subtle-pattern text-on-surface font-body-md min-h-screen flex flex-col antialiased selection:bg-secondary selection:text-white">

<div x-data="{ mobileOpen: false }">
<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-white/90 shadow-sm transition-all duration-300" id="navbar" aria-label="Navigasi Utama">
    <div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_isi_dashboard.png') }}" alt="PRATAMA Logo" class="h-12 w-12 object-contain rounded-md">
            <div class="navbar-logo-text hidden sm:block text-primary">
                <span class="font-title-lg text-title-lg font-bold leading-tight block">PRATAMA</span>
                <span class="text-[10px] tracking-[0.2em] font-semibold mt-0.5 block opacity-60">Institut Seni Indonesia Yogyakarta</span>
            </div>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a class="nav-link text-primary/80 hover:text-primary transition-colors" href="{{ url('/') }}">Beranda</a>
            <a class="nav-link text-primary/80 hover:text-primary transition-colors" href="{{ url('/') }}#tentang">Tentang</a>
            <a class="nav-link text-primary/80 hover:text-primary transition-colors" href="{{ url('/') }}#fitur">Fitur</a>
            <a class="nav-link text-primary/80 hover:text-primary transition-colors" href="{{ url('/') }}#alur">Alur</a>
            <a class="nav-link text-primary/80 hover:text-primary transition-colors" href="{{ url('/statistik') }}">Statistik</a>
            <a class="nav-link text-primary font-bold border-b-2 border-primary pb-1 transition-colors hover:opacity-80" href="{{ url('/kontak') }}">Kontak</a>
        </div>
        <div class="flex gap-3" id="navButtons">
    @auth
        <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md flex items-center gap-2 shadow-lg shadow-black/10">
            <span class="material-symbols-outlined text-[18px]">dashboard</span> Dashboard
        </a>
    @else
        <a id="loginBtn" href="{{ route('login') }}" class="px-6 py-2 rounded-full font-label-md text-label-md hidden md:block border border-primary/70 text-primary hover:bg-primary/10 transition-all">Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-full font-label-md text-label-md hidden md:block">Daftar</a>
    @endauth
</div>
        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-primary p-2 ml-2" aria-label="Toggle menu">
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
        <a @click="mobileOpen = false" href="{{ url('/') }}" class="text-white/80 hover:text-white transition-colors">Beranda</a>
        <a @click="mobileOpen = false" href="{{ url('/') }}#tentang" class="text-white/80 hover:text-white transition-colors">Tentang</a>
        <a @click="mobileOpen = false" href="{{ url('/') }}#fitur" class="text-white/80 hover:text-white transition-colors">Fitur</a>
        <a @click="mobileOpen = false" href="{{ url('/') }}#alur" class="text-white/80 hover:text-white transition-colors">Alur</a>
        <a @click="mobileOpen = false" href="{{ url('/statistik') }}" class="text-white/80 hover:text-white transition-colors">Statistik</a>
        <a @click="mobileOpen = false" href="{{ url('/kontak') }}" class="font-bold border-b-2 border-white pb-1">Kontak</a>
        <div class="mt-4 flex gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary px-8 py-3 rounded-full font-label-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-full font-label-md">Masuk</a>
                <a href="{{ route('register') }}" class="px-8 py-3 rounded-full font-label-md border-2 border-white/40 text-white hover:bg-white/10">Daftar</a>
            @endauth
        </div>
    </div>
</div>
</div>

   <!-- Konten Kontak -->
<section class="max-w-5xl mx-auto px-margin-mobile md:px-margin-desktop pb-10 flex-1 w-full" style="padding-top: 100px">

    <div class="text-center mb-8">
        <span class="inline-block py-1 px-3 rounded-full badge-tag font-semibold text-xs mb-3">Kontak</span>
        <h1 class="font-heading text-4xl font-bold text-primary">Hubungi <span class="text-gradient">Kami</span></h1>
        <p class="text-on-surface-variant mt-2">Informasi kontak resmi Bagian Kemahasiswaan ISI Yogyakarta</p>
    </div>

    <!-- Kartu Kontak - 1 Kolom -->
    <div class="modern-card p-8 md:p-12 mb-6">
        <div class="flex flex-col gap-8">
            
            <!-- Bagian Kemahasiswaan -->
            <div class="text-center pb-6 border-b border-outline-variant/30">
                <h2 class="font-heading text-2xl font-bold text-primary mb-1">Bagian Kemahasiswaan</h2>
            </div>

            <!-- Detail Kontak -->
            <div class="flex flex-col gap-6">
                
                <!-- Alamat -->
                <div class="flex items-start gap-4 group">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110"
                         style="background: linear-gradient(135deg, rgba(10, 25, 41, 0.10), rgba(30, 58, 138, 0.05)); color: var(--primary-dongker);">
                        <span class="material-symbols-outlined text-[28px]">location_on</span>
                    </div>
                    <div class="flex flex-col pt-1">
                        <span class="text-primary font-semibold text-base mb-1">Alamat</span>
                        <span class="text-on-surface-variant leading-relaxed">
                            Gedung Rektorat Lantai 1 ISI Yogyakarta<br>
                            Jl. Parangtritis Km. 6.5 Sewon, Bantul<br>
                            Yogyakarta 55188, Indonesia
                        </span>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4 group">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110"
                         style="background: linear-gradient(135deg, rgba(10, 25, 41, 0.10), rgba(30, 58, 138, 0.05)); color: var(--primary-dongker);">
                        <span class="material-symbols-outlined text-[28px]">mail</span>
                    </div>
                    <div class="flex flex-col pt-1">
                        <span class="text-primary font-semibold text-base mb-1">Email</span>
                        <a href="mailto:kemahasiswaan@isi.ac.id" class="text-on-surface-variant hover:text-[#2563EB] transition-colors duration-300">
                            kemahasiswaan@isi.ac.id
                        </a>
                    </div>
                </div>

                <!-- Telepon -->
                <div class="flex items-start gap-4 group">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110"
                         style="background: linear-gradient(135deg, rgba(10, 25, 41, 0.10), rgba(30, 58, 138, 0.05)); color: var(--primary-dongker);">
                        <span class="material-symbols-outlined text-[28px]">call</span>
                    </div>
                    <div class="flex flex-col pt-1">
                        <span class="text-primary font-semibold text-base mb-1">Telepon</span>
                        <a href="tel:+62274379133" class="text-on-surface-variant hover:text-[#2563EB] transition-colors duration-300">
                            0274-379133, 373659
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-outline-variant/30 text-center">
                <p class="text-sm text-on-surface-variant">
                    Layanan informasi dan bantuan terkait prestasi dan talenta mahasiswa ISI Yogyakarta.
                </p>
            </div>
        </div>
    </div>

    <!-- Google Maps - Full Width di Bawah -->
    <div class="modern-card overflow-hidden p-0">
        <div id="map" style="height: 450px; width: 100%;" aria-label="Peta lokasi ISI Yogyakarta"></div>
        <div class="flex justify-center py-4 bg-white border-t border-outline-variant/30">
            <a href="https://maps.app.goo.gl/aPDfgTubL1VdWzJg6" target="_blank" rel="noopener" 
               class="inline-flex items-center gap-2 btn-primary px-6 py-2.5 rounded-full font-label-md text-label-md shadow-md shadow-black/10">
                <span class="material-symbols-outlined text-[18px]">map</span> Buka di Google Maps
            </a>
        </div>
    </div>

</section>

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

<script src="{{ asset('vendor/leaflet/leaflet.min.js') }}?v=1" onerror="window.__leafletLoadFailed = true"></script>
<script>window.__pratamaLeaflet = window.L || null;</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('shadow-sm', window.scrollY > 10);
    });

    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    const L = window.__pratamaLeaflet;

    if (window.__leafletLoadFailed || !L || typeof L.map !== 'function') {
        console.warn('Leaflet gagal dimuat. typeof __pratamaLeaflet =', typeof L, '| loadFailed =', window.__leafletLoadFailed || false);
        showMapFallback(mapEl);
        return;
    }

    const map = L.map('map').setView([-7.851621, 110.353959], 16);

    const tiles = [
        {
            name: 'OpenStreetMap',
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            opts: { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors', maxZoom: 19 }
        },
        {
            name: 'Esri World Street Map',
            url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
            opts: { attribution: '&copy; Esri, HERE, Garmin, OpenStreetMap contributors', maxZoom: 19 }
        }
    ];

    let tileIndex = 0;
    function addTiles() {
        const t = tiles[tileIndex];
        const layer = L.tileLayer(t.url, t.opts);
        let errorCount = 0;
        layer.on('tileerror', () => {
            errorCount++;
            if (errorCount >= 3 && tileIndex < tiles.length - 1) {
                console.warn('Tile ' + t.name + ' gagal dimuat — beralih ke provider lain.');
                map.removeLayer(layer);
                tileIndex++;
                addTiles();
            }
        });
        layer.addTo(map);
        return layer;
    }
    addTiles();

    L.marker([-7.851621, 110.353959]).addTo(map)
        .bindPopup('<b>ISI Yogyakarta</b><br>Jl. Parangtritis Km. 6.5 Sewon, Bantul, Yogyakarta 55188')
        .openPopup();
});

function showMapFallback(mapEl) {
    mapEl.innerHTML = `
        <div class="w-full h-full flex flex-col items-center justify-center gap-3 p-6 text-center">
            <span class="material-symbols-outlined text-[40px] text-on-surface-variant/40">map</span>
            <span class="text-on-surface-variant text-sm">Peta tidak dapat dimuat.</span>
            <a href="https://maps.app.goo.gl/aPDfgTubL1VdWzJg6" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 btn-primary px-6 py-2.5 rounded-full font-label-md text-label-md shadow-md shadow-black/10">
                <span class="material-symbols-outlined text-[18px]">map</span> Buka di Google Maps
            </a>
        </div>`;
}
</script>
</body>
</html>