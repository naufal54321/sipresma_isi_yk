<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIPRESMA') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        /* Custom scrollbar yang lebih modern */
        .rekap-scroll::-webkit-scrollbar { width: 5px; }
        .rekap-scroll::-webkit-scrollbar-track { background: transparent; }
        .rekap-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .rekap-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Menghilangkan panah bawaan pada tag details */
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }

        /* Animasi modern */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden min-h-screen flex flex-col">

    <!-- Navbar Glassmorphism Modern -->
    <nav class="bg-white/80 backdrop-blur-xl shadow-sm border-b border-slate-200/60 px-6 py-3 flex justify-between items-center sticky top-0 z-50 transition-all">
        <div class="flex items-center gap-4">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <img src="{{ asset('images/logo_isi_welcome.png') }}" alt="Logo Instansi" class="h-9 w-auto object-contain">
            </div>
            <div>
                <h1 class="font-extrabold text-xl tracking-tight text-slate-900 leading-none">SIPRESMA</h1>
                <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase tracking-widest">Sistem Prestasi Mahasiswa</p>
            </div>
        </div>

        <div class="flex items-center gap-4 sm:gap-6">
            <details class="relative group">
                <summary class="cursor-pointer text-red-500 hover:text-red-600 text-sm font-semibold flex items-center gap-2 transition-colors bg-red-50 hover:bg-red-100 px-3 py-2 rounded-xl">
                    <i class="far fa-question-circle text-lg"></i>
                    <span class="hidden sm:inline">Bantuan & Panduan</span>
                    <i class="fas fa-chevron-down text-xs ml-1 opacity-50 group-open:rotate-180 transition-transform"></i>
                </summary>

                <div class="absolute right-0 mt-3 w-64 bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden z-50 transform opacity-100 scale-100 transition-all origin-top-right">
                    <a href="https://youtu.be/5k4llr0of_k?si=6tX4mNXnCR5YLOlQ" target="_blank" class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group/link">
                        <div class="bg-red-50 text-red-500 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover/link:scale-110 transition-transform"><i class="fab fa-youtube text-lg"></i></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Video Tutorial</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Tonton panduan penggunaan</p>
                        </div>
                    </a>
                    <a href="{{ asset('panduan/Panduan_SIPRESMA.pdf') }}" target="_blank" class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 transition-colors group/link">
                        <div class="bg-blue-50 text-blue-500 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 group-hover/link:scale-110 transition-transform"><i class="fas fa-file-pdf text-lg"></i></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Buku Panduan</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Unduh dokumen PDF</p>
                        </div>
                    </a>
                </div>
            </details>

            @auth
                <a href="{{ url('/dashboard') }}" class="bg-slate-900 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-md shadow-slate-200 hover:shadow-blue-200 transition-all duration-300">
                    <i class="fas fa-columns"></i> <span class="hidden sm:inline">Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-md shadow-blue-200 transition-all duration-300">
                    <i class="fas fa-sign-in-alt"></i> <span class="hidden sm:inline">Masuk</span>
                </a>
            @endauth
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">

        <!-- Header Teks Modern -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-2">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <p class="text-black font-extrabold tracking-[0.2em] text-xs uppercase">Portal Publik</p>
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900 truncate">
                    Dashboard SIPRESMA
                </h1>
                <p class="mt-3 text-slate-500 max-w-2xl text-sm sm:text-base leading-relaxed line-clamp-2 sm:line-clamp-none">
                    Ringkasan data, persebaran, dan statistik pencapaian prestasi mahasiswa terkini di lingkungan kampus.
                </p>
            </div>
            
            <div class="hidden md:flex items-center justify-center w-20 h-20 bg-white rounded-full border border-slate-200 shadow-sm shrink-0 animate-[floatSlow_6s_ease-in-out_infinite]">
                <i class="fas fa-globe-asia text-4xl text-blue-500"></i>
            </div>
        </div>

        <!-- Kartu Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-[11px] font-bold mb-1 uppercase tracking-widest truncate">Total Mahasiswa</p>
                    <p class="text-4xl font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors mt-1">{{ number_format($totalMahasiswa, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 w-16 h-16 rounded-2xl flex items-center justify-center text-blue-500 text-2xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-[11px] font-bold mb-1 uppercase tracking-widest truncate">SPK (Draft/Disetujui)</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <p class="text-4xl font-extrabold text-slate-800 group-hover:text-orange-500 transition-colors">{{ $spkDraft }}</p>
                        <span class="text-slate-300 text-2xl font-light">/</span>
                        <p class="text-3xl font-bold text-emerald-500">{{ $spkDisetujui }}</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 w-16 h-16 rounded-2xl flex items-center justify-center text-orange-500 text-2xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-medal"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-[11px] font-bold mb-1 uppercase tracking-widest truncate">Mahasiswa Berprestasi</p>
                    <p class="text-4xl font-extrabold text-slate-800 group-hover:text-purple-600 transition-colors mt-1">{{ number_format($mahasiswaBerprestasi, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 w-16 h-16 rounded-2xl flex items-center justify-center text-purple-500 text-2xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>

        {{-- Statistik Prestasi Prodi — Full Width --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col h-[500px] overflow-hidden group hover:shadow-md transition-shadow mb-8">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center"><i class="fas fa-chart-bar"></i></div>
                    Statistik Prestasi Prodi ({{ date('Y') }})
                </h3>
            </div>
            <div class="p-6 flex-1 w-full relative">
                <canvas id="prestasiChart"></canvas>
            </div>
        </div>

        <!-- Grid: Rekap Terbaru & Chart Tingkat -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
            
            <!-- Rekap Terbaru -->
            <div class="xl:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col h-[500px] overflow-hidden relative group hover:shadow-md transition-shadow">
                <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full opacity-50 z-0"></div>
                <div class="px-6 py-5 border-b border-slate-100 relative z-10">
                    <h3 class="font-extrabold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center"><i class="fas fa-history"></i></div>
                        Rekap Prestasi Terbaru
                    </h3>
                </div>
                <div class="flex-1 overflow-y-auto p-2 rekap-scroll relative z-10">
                    @forelse($rekapPrestasi as $spk)
                        <div class="p-4 hover:bg-slate-50/80 rounded-2xl transition-colors border-b border-slate-50 last:border-0 flex items-start gap-4">
                            <!-- Avatar Inisial -->
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-700 border border-blue-200 flex items-center justify-center text-sm font-extrabold shrink-0 shadow-sm">
                                {{ substr($spk->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-slate-800 font-bold text-sm truncate">{{ $spk->user->name ?? 'Anonim' }}</h4>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">
                                    {{ $spk->kegiatan->kegiatan ?? $spk->keterangan }} 
                                </p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                                    @if(isset($spk->kegiatan->tingkat)) 
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase border border-slate-200 px-2 py-0.5 rounded-md">{{ $spk->kegiatan->tingkat }}</span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-400 space-y-3">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center"><i class="fas fa-inbox text-2xl text-slate-300"></i></div>
                            <p class="text-sm font-medium">Belum ada data disetujui.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Prestasi Berdasarkan Tingkat — Warna Berbeda per Tingkat --}}
            <div class="xl:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col h-[500px] overflow-hidden group hover:shadow-md transition-shadow">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center"><i class="fas fa-layer-group"></i></div>
                        Prestasi Berdasarkan Tingkat
                    </h3>
                </div>
                <div class="p-6 flex-1 w-full relative">
                    <canvas id="tingkatChart"></canvas>
                </div>
            </div>

        </div>

        {{-- Distribusi Jenis Kegiatan — Full Width --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col h-[400px] overflow-hidden group hover:shadow-md transition-shadow mb-8">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-500 flex items-center justify-center"><i class="fas fa-shapes"></i></div>
                    Distribusi Jenis Kegiatan
                </h3>
            </div>
            <div class="p-6 flex-1 w-full relative flex items-center justify-center">
                <canvas id="jenisChart"></canvas>
            </div>
        </div>

    </main>

    {{-- 🆕 FOOTER --}}
   <footer class="w-full py-5 px-8 text-center sm:text-center text-sm text-slate-500 border-t border-slate-200 mt-auto bg-white/50 backdrop-blur-sm">
        &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Palet Warna
            const colorPalette = [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#0ea5e9', '#14b8a6', '#f43f5e'
            ];

            // Warna khusus untuk setiap tingkat
            const tingkatColorPalette = [
                '#3b82f6', // Biru - Internasional
                '#8b5cf6', // Ungu - Nasional
                '#f59e0b', // Oranye - Provinsi
                '#10b981', // Hijau - Kabupaten/Kota
                '#ef4444', // Merah - Kecamatan
                '#ec4899', // Pink - Desa
                '#0ea5e9', // Cyan
                '#14b8a6', // Teal
                '#f43f5e', // Rose
            ];

            // Konfigurasi Font Global Chart.js
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748b';
            
            const commonTooltip = {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                padding: 12,
                titleFont: { size: 13, family: 'Inter' },
                bodyFont: { size: 14, family: 'Inter', weight: 'bold' },
                cornerRadius: 8
            };

            // 1. Chart Prodi (Bar Chart) — Full Width
            const ctxProdi = document.getElementById('prestasiChart').getContext('2d');
            new Chart(ctxProdi, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: '#3b82f6',
                        hoverBackgroundColor: '#2563eb',
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: commonTooltip
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { family: 'Inter' } },
                            grid: { color: '#f1f5f9', drawBorder: false },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45, minRotation: 45,
                                autoSkip: false, font: { size: 11, family: 'Inter' }, color: '#64748b'
                            },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 2. Chart Tingkat (Bar Chart - Horizontal) — Warna Berbeda per Tingkat
            const ctxTingkat = document.getElementById('tingkatChart').getContext('2d');
            
            const tingkatLabels = {!! json_encode($tingkatLabels) !!};
            const tingkatData = {!! json_encode($tingkatData) !!};
            
            const tingkatColors = tingkatLabels.map((label, index) => {
                return tingkatColorPalette[index % tingkatColorPalette.length];
            });
            
            const tingkatHoverColors = tingkatLabels.map((label, index) => {
                const color = tingkatColorPalette[index % tingkatColorPalette.length];
                return color + 'CC';
            });
            
            new Chart(ctxTingkat, {
                type: 'bar',
                data: {
                    labels: tingkatLabels,
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: tingkatData,
                        backgroundColor: tingkatColors,
                        hoverBackgroundColor: tingkatHoverColors,
                        borderRadius: 6,
                        barPercentage: 0.5,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            ...commonTooltip,
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.raw} Prestasi`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { family: 'Inter' } },
                            grid: { color: '#f1f5f9' },
                            border: { display: false }
                        },
                        y: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { family: 'Inter', weight: '600' }, color: '#475569' }
                        }
                    }
                }
            });

            // 3. Chart Jenis (Doughnut Chart)
            const ctxJenis = document.getElementById('jenisChart').getContext('2d');
            new Chart(ctxJenis, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($jenisLabels) !!},
                    datasets: [{
                        data: {!! json_encode($jenisData) !!},
                        backgroundColor: colorPalette,
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 12, family: 'Inter' },
                                color: '#475569'
                            }
                        },
                        tooltip: commonTooltip
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>