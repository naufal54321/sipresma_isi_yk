<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIPRESMA') }} · ISI Yogyakarta</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Space Grotesk', 'sans-serif'] },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'fade-in-down': 'fadeInDown 0.6s ease-out',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'float-slow': 'floatSlow 6s ease-in-out infinite',
                        'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                        'shimmer': 'shimmer 2s infinite',
                        'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
                        'gradient-move': 'gradientMove 8s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        fadeInDown: { '0%': { opacity: '0', transform: 'translateY(-20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideInLeft: { '0%': { opacity: '0', transform: 'translateX(-40px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        slideInRight: { '0%': { opacity: '0', transform: 'translateX(40px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        scaleIn: { '0%': { opacity: '0', transform: 'scale(0.9)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                        floatSlow: { '0%, 100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-10px)' } },
                        pulseSoft: { '0%, 100%': { opacity: '1' }, '50%': { opacity: '0.6' } },
                        shimmer: { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
                        bounceGentle: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-5px)' } },
                        gradientMove: { '0%, 100%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' } },
                        glow: { '0%, 100%': { boxShadow: '0 0 20px rgba(59,130,246,0.1)' }, '50%': { boxShadow: '0 0 40px rgba(59,130,246,0.3)' } },
                    }
                }
            }
        }
    </script>

    <style>
        .rekap-scroll::-webkit-scrollbar { width: 4px; }
        .rekap-scroll::-webkit-scrollbar-track { background: transparent; }
        .rekap-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        
        /* Glass Neo */
        .glass-neo { 
            background: rgba(255,255,255,0.6); 
            backdrop-filter: blur(24px); 
            -webkit-backdrop-filter: blur(24px); 
            border: 1px solid rgba(255,255,255,0.8); 
        }
        
        /* Grid Pattern */
        .bg-grid { 
            background-image: radial-gradient(circle, #e2e8f0 1px, transparent 1px); 
            background-size: 30px 30px; 
        }
        
        /* Gradient Text */
        .text-gradient { 
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            background-clip: text; 
        }
    </style>
</head>
<body class="bg-grid bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="glass-neo px-6 py-3 flex justify-between items-center sticky top-0 z-50 animate-fade-in-down shadow-sm">
        <div class="flex items-center gap-4">
            <div class="bg-white p-2 rounded-2xl shadow-lg shadow-blue-100 hover:shadow-xl transition-shadow animate-scale-in">
                <img src="{{ asset('images/logo_isi_welcome.png') }}" alt="Logo" class="h-9 w-auto object-contain">
            </div>
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-none">SIPRESMA</h1>
                <p class="text-[10px] text-blue-500 font-bold mt-1 uppercase tracking-[0.2em]">Sistem Prestasi Mahasiswa</p>
            </div>
        </div>

        <div class="flex items-center gap-4 sm:gap-6">
            <details class="relative group">
                <summary class="cursor-pointer text-rose-500 hover:text-rose-600 text-sm font-semibold flex items-center gap-2 bg-rose-50 hover:bg-rose-100 px-3 py-2 rounded-xl transition-colors border border-rose-100">
                    <i class="far fa-question-circle text-lg animate-pulse-soft"></i>
                    <span class="hidden sm:inline">Bantuan</span>
                    <i class="fas fa-chevron-down text-xs opacity-50 group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="absolute right-0 mt-3 w-64 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden z-50 animate-fade-in-up">
                    <a href="https://youtu.be/5k4llr0of_k" target="_blank" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 border-b border-gray-50 group/link">
                        <div class="bg-rose-50 text-rose-500 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover/link:scale-110 transition-transform"><i class="fab fa-youtube text-lg"></i></div>
                        <div><p class="text-sm font-bold text-slate-800">Video Tutorial</p><p class="text-[11px] text-slate-500 mt-0.5">Panduan penggunaan</p></div>
                    </a>
                    <a href="{{ asset('panduan/Panduan_SIPRESMA.pdf') }}" target="_blank" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 group/link">
                        <div class="bg-blue-50 text-blue-500 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover/link:scale-110 transition-transform"><i class="fas fa-file-pdf text-lg"></i></div>
                        <div><p class="text-sm font-bold text-slate-800">Buku Panduan</p><p class="text-[11px] text-slate-500 mt-0.5">Unduh dokumen PDF</p></div>
                    </a>
                </div>
            </details>

            @auth
                <a href="{{ url('/dashboard') }}" class="bg-slate-900 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-lg shadow-slate-200 hover:shadow-blue-200 transition-all duration-300">
                    <i class="fas fa-columns"></i> <span class="hidden sm:inline">Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all duration-300">
                    <i class="fas fa-sign-in-alt"></i> <span class="hidden sm:inline">Masuk</span>
                </a>
            @endauth
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">

        <!-- Hero White Modern -->
<div class="relative bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 mb-10 overflow-hidden animate-fade-in-up border border-slate-100">
    {{-- Subtle gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-white to-indigo-50/50"></div>
    
    {{-- Decorative circles --}}
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100/40 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-indigo-100/30 rounded-full blur-3xl"></div>
    
    {{-- Dot pattern --}}
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(circle,#3b82f6_1px,transparent_1px)] bg-[size:20px_20px]"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-3">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <p class="text-blue-500 font-semibold tracking-[0.2em] text-xs uppercase">Portal Publik</p>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">
                Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">SIPRESMA</span>
            </h1>
            <p class="mt-3 text-slate-500 max-w-2xl text-sm sm:text-base leading-relaxed">
                Ringkasan data, persebaran, dan statistik pencapaian prestasi mahasiswa terkini di lingkungan kampus.
            </p>
        </div>
        <div class="hidden md:flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 shadow-lg shadow-blue-100 shrink-0 animate-float-slow">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>
        </div>
    </div>
</div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 mb-8">
            @php $cards = [
                ['label' => 'Total Mahasiswa', 'value' => number_format($totalMahasiswa, 0, ',', '.'), 'color' => 'blue', 'icon' => 'fa-users', 'delay' => '0.1s'],
                ['label' => 'SPK (Draft / Disetujui)', 'value' => $spkDraft . ' / ' . $spkDisetujui, 'color' => 'orange', 'icon' => 'fa-medal', 'delay' => '0.2s'],
                ['label' => 'Mahasiswa Berprestasi', 'value' => number_format($mahasiswaBerprestasi, 0, ',', '.'), 'color' => 'purple', 'icon' => 'fa-trophy', 'delay' => '0.3s'],
            ]; @endphp
            @foreach($cards as $card)
            <div class="glass-neo rounded-2xl p-6 flex justify-between items-center group hover:-translate-y-2 hover:shadow-xl transition-all duration-300 relative overflow-hidden animate-fade-in-up" style="animation-delay: {{ $card['delay'] }}">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-{{ $card['color'] }}-400 to-{{ $card['color'] }}-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[11px] font-bold mb-1 uppercase tracking-widest">{{ $card['label'] }}</p><p class="text-4xl font-extrabold text-slate-800 group-hover:text-{{ $card['color'] }}-600 transition-colors mt-1">{{ $card['value'] }}</p></div>
                <div class="bg-gradient-to-br from-{{ $card['color'] }}-50 to-{{ $card['color'] }}-100/50 w-16 h-16 rounded-2xl flex items-center justify-center text-{{ $card['color'] }}-500 text-2xl shadow-inner shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-transform"><i class="fas {{ $card['icon'] }}"></i></div>
            </div>
            @endforeach
        </div>

        {{-- Chart Prodi --}}
        <div class="glass-neo rounded-3xl flex flex-col h-[500px] overflow-hidden hover:shadow-md transition-shadow mb-8 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="px-6 py-5 border-b border-gray-100"><h3 class="font-extrabold text-slate-800 flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center"><i class="fas fa-chart-bar"></i></div>Statistik Prestasi Prodi ({{ date('Y') }})</h3></div>
            <div class="p-6 flex-1 w-full relative"><canvas id="prestasiChart"></canvas></div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
            <div class="xl:col-span-4 glass-neo rounded-3xl flex flex-col h-[500px] overflow-hidden relative hover:shadow-md transition-shadow animate-slide-in-left" style="animation-delay: 0.5s">
                <div class="px-6 py-5 border-b border-gray-100"><h3 class="font-extrabold text-slate-800 flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center"><i class="fas fa-history"></i></div>Rekap Prestasi Terbaru</h3></div>
                <div class="flex-1 overflow-y-auto p-2 rekap-scroll">
                    @forelse($rekapPrestasi as $spk)
                        <div class="p-4 hover:bg-white/80 rounded-2xl transition-colors border-b border-gray-50 last:border-0 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-700 border border-blue-200 flex items-center justify-center text-sm font-extrabold shrink-0 shadow-sm">{{ substr($spk->user->name ?? 'A', 0, 1) }}</div>
                            <div class="flex-1 min-w-0"><h4 class="text-slate-800 font-bold text-sm truncate">{{ $spk->user->name ?? 'Anonim' }}</h4><p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $spk->kegiatan->kegiatan ?? $spk->keterangan }}</p><div class="mt-2 flex items-center gap-2"><span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase">Disetujui</span>@if($spk->tingkat)<span class="text-[10px] font-semibold text-slate-400 uppercase border border-gray-200 px-2 py-0.5 rounded-md">{{ $spk->tingkat }}</span>@endif</div></div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-400"><div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center"><i class="fas fa-inbox text-2xl text-gray-300"></i></div><p class="text-sm font-medium mt-3">Belum ada data disetujui.</p></div>
                    @endforelse
                </div>
            </div>
            <div class="xl:col-span-8 glass-neo rounded-3xl flex flex-col h-[500px] overflow-hidden hover:shadow-md transition-shadow animate-slide-in-right" style="animation-delay: 0.5s">
                <div class="px-6 py-5 border-b border-gray-100"><h3 class="font-extrabold text-slate-800 flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center"><i class="fas fa-layer-group"></i></div>Prestasi Berdasarkan Tingkat</h3></div>
                <div class="p-6 flex-1 w-full relative"><canvas id="tingkatChart"></canvas></div>
            </div>
        </div>

        {{-- Distribusi --}}
        <div class="glass-neo rounded-3xl flex flex-col h-[400px] overflow-hidden hover:shadow-md transition-shadow mb-8 animate-fade-in-up" style="animation-delay: 0.6s">
            <div class="px-6 py-5 border-b border-gray-100"><h3 class="font-extrabold text-slate-800 flex items-center gap-2"><div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center"><i class="fas fa-shapes"></i></div>Distribusi Jenis Kegiatan</h3></div>
            <div class="p-6 flex-1 w-full relative flex items-center justify-center"><canvas id="jenisChart"></canvas></div>
        </div>

    </main>

    <footer class="w-full py-5 px-8 text-center text-sm text-slate-400 border-t border-gray-100 mt-auto bg-white/30 backdrop-blur-sm animate-fade-in">
        &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cp = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#0ea5e9', '#14b8a6'];
            const tp = ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444', '#ec4899', '#0ea5e9', '#14b8a6'];
            Chart.defaults.font.family = "'Space Grotesk', sans-serif";
            Chart.defaults.color = '#64748b';
            const tt = { backgroundColor: 'rgba(15, 23, 42, 0.95)', padding: 14, titleFont: { size: 13 }, bodyFont: { size: 15, weight: 'bold' }, cornerRadius: 12 };

            new Chart(document.getElementById('prestasiChart'), {
                type: 'bar', data: { labels: {!! json_encode($chartLabels) !!}, datasets: [{ data: {!! json_encode($chartData) !!}, backgroundColor: '#3b82f6', borderRadius: 8, barPercentage: 0.6 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: tt }, animation: { duration: 1500, easing: 'easeOutQuart' }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false } }, x: { ticks: { maxRotation: 45, font: { size: 11 } }, grid: { display: false }, border: { display: false } } } }
            });

            const tl = {!! json_encode($tingkatLabels) !!}; const td = {!! json_encode($tingkatData) !!};
            new Chart(document.getElementById('tingkatChart'), {
                type: 'bar', data: { labels: tl, datasets: [{ data: td, backgroundColor: tl.map((_,i) => tp[i%8]), borderRadius: 8, barPercentage: 0.5 }] },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', animation: { duration: 1500, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { ...tt, callbacks: { label: c => ` ${c.raw} Prestasi` } } }, scales: { x: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false } }, y: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: '600' }, color: '#475569' } } } }
            });

            new Chart(document.getElementById('jenisChart'), {
                type: 'doughnut', data: { labels: {!! json_encode($jenisLabels) !!}, datasets: [{ data: {!! json_encode($jenisData) !!}, backgroundColor: cp, borderWidth: 0, hoverOffset: 10 }] },
                options: { responsive: true, maintainAspectRatio: false, animation: { animateScale: true, animateRotate: true, duration: 2000, easing: 'easeOutBounce' }, plugins: { legend: { position: 'right', labels: { padding: 20, usePointStyle: true, font: { size: 12 }, color: '#475569' } }, tooltip: tt }, cutout: '70%' }
            });
        });
    </script>
</body>
</html>