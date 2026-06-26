<x-app-layout>

<div class="py-6 overflow-x-hidden">
    <div class="max-w-8xl mx-auto py-6">

         {{-- 🎭 HERO: Gapura ISI Yogyakarta --}}
        <div class="relative bg-gradient-to-br from-[#1C110A] via-[#2D1B0E] to-[#3D2917] rounded-3xl p-8 sm:p-10 text-white shadow-2xl shadow-amber-900/20 mb-8 overflow-hidden border border-amber-800/30">
            
            {{-- Ornamen Parang Batik --}}
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml,<svg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M0 30 L15 15 L30 30 L15 45 Z\' fill=\'none\' stroke=\'white\' stroke-width=\'0.5\'/><path d=\'M30 0 L45 15 L30 30 L15 15 Z\' fill=\'none\' stroke=\'white\' stroke-width=\'0.5\'/><path d=\'M30 60 L45 45 L60 60 L45 75 Z\' fill=\'none\' stroke=\'white\' stroke-width=\'0.5\'/><path d=\'M60 30 L75 15 L60 0 L45 15 Z\' fill=\'none\' stroke=\'white\' stroke-width=\'0.5\'/><circle cx=\'30\' cy=\'30\' r=\'5\' fill=\'none\' stroke=\'white\' stroke-width=\'0.3\'/></svg>')"></div>
            
            {{-- Cahaya Kehangatan (Earth Tone Glow) --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-amber-500 to-orange-600 opacity-20 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-gradient-to-tr from-yellow-600 to-amber-400 opacity-20 rounded-full blur-[80px]"></div>
            
            {{-- Motif Ceplok Kawung Samara --}}
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iOCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjAuNSIvPjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjMiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <p class="text-amber-400/80 font-bold tracking-[0.2em] text-xs uppercase mb-2 drop-shadow-sm">Dashboard Dosen Pembimbing</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight truncate text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-yellow-100 to-amber-200">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <p class="mt-3 text-stone-300 max-w-2xl text-sm sm:text-base leading-relaxed line-clamp-2 sm:line-clamp-none">
                        Pantau progres verifikasi dan perkembangan prestasi mahasiswa bimbingan Anda dengan mudah melalui ekosistem digital <span class="text-amber-300 font-semibold">SIPRESMA</span>.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold">
                        <span class="bg-amber-900/20 backdrop-blur-md border border-amber-700/30 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner hover:bg-amber-900/30 transition-colors cursor-default text-amber-200">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
                            </span>
                            Pemantauan Aktif
                        </span>
                        <span class="bg-amber-900/10 backdrop-blur-md border border-amber-700/20 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner hover:bg-amber-900/20 transition-colors cursor-default text-amber-300/70 text-[0.6rem] tracking-[0.15em]">
                            <i class="fas fa-map-pin text-amber-400/60"></i>
                            ISI YOGYAKARTA
                        </span>
                    </div>
                </div>
                
                {{-- Gunungan Wayang Stilasi --}}
                <div class="hidden md:flex items-center justify-center w-28 h-28 bg-gradient-to-br from-amber-900/30 to-amber-800/20 backdrop-blur-xl rounded-full border border-amber-700/30 shadow-[0_0_40px_rgba(245,158,11,0.15)] shrink-0 group hover:scale-105 transition-transform duration-500">
                    <div class="text-center leading-none">
                        <svg class="w-16 h-16 mx-auto" viewBox="0 0 60 80" fill="none">
                            <path d="M30 5 L50 20 L45 40 L35 35 L30 50 L25 35 L15 40 L10 20 Z" fill="url(#gunungan-gold)" opacity="0.9"/>
                            <circle cx="30" cy="25" r="4" fill="#fbbf24" opacity="0.8"/>
                            <path d="M20 50 Q30 65 40 50" stroke="url(#gunungan-gold)" stroke-width="1.5" fill="none" opacity="0.6"/>
                            <defs>
                                <linearGradient id="gunungan-gold" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fbbf24"/>
                                    <stop offset="100%" stop-color="#d97706"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Mahasiswa Bimbingan</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors mt-1">{{ $totalMahasiswa }}</h2>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-blue-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Draft RPK</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-orange-500 transition-colors mt-1">{{ $rpkMenunggu }}</h2>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-orange-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M17.663 3.118c.225.015.45.032.673.05C19.876 3.298 21 4.604 21 6.109v9.642a3 3 0 0 1-3 3V16.5c0-5.922-4.576-10.775-10.384-11.217.324-1.132 1.3-2.01 2.548-2.114.224-.019.448-.036.673-.051A3 3 0 0 1 13.5 1.5H15a3 3 0 0 1 2.663 1.618ZM12 4.5A1.5 1.5 0 0 1 13.5 3H15a1.5 1.5 0 0 1 1.5 1.5H12Z" clip-rule="evenodd" />
                    <path d="M3 8.625c0-1.036.84-1.875 1.875-1.875h.375A3.75 3.75 0 0 1 9 10.5v1.875c0 1.036.84 1.875 1.875 1.875h1.875A3.75 3.75 0 0 1 16.5 18v2.625c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625v-12Z" />
                    <path d="M10.5 10.5a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963 5.23 5.23 0 0 0-3.434-1.279h-1.875a.375.375 0 0 1-.375-.375V10.5Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Draft SPK</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-emerald-500 transition-colors mt-1">{{ $spkMenunggu }}</h2>
                </div>
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-emerald-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-slate-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-slate-400 to-slate-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Total Verifikasi</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $rpkDisetujui + $spkDisetujui }}</h2>
                </div>
                <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-slate-600 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>

        </div>

        @php
            $totalAntrean = $rpkMenunggu + $spkMenunggu;
            $progressText = $totalAntrean == 0 ? 'Semua tugas telah diselesaikan dengan sangat baik!' : 'Terdapat ' . $totalAntrean . ' data antrean yang membutuhkan tinjauan Anda.';
            $progressValue = min((($totalAntrean)/100)*100, 100); 
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 mb-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row sm:justify-between sm:items-end mb-4 gap-4">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-indigo-50 text-indigo-500"><i class="fas fa-chart-line"></i></span>
                        Beban Kerja Validasi
                    </h2>
                    <p class="text-sm text-slate-500 mt-1.5">{{ $progressText }}</p>
                </div>
                <div class="inline-flex items-center justify-center px-4 py-1.5 bg-slate-900 rounded-full shrink-0 shadow-md">
                    <span class="font-extrabold text-white text-sm">{{ $totalAntrean }} Antrean</span>
                </div>
            </div>
            
            <div class="relative z-10 w-full bg-slate-100/80 rounded-full h-4 overflow-hidden border border-slate-200/60 shadow-inner">
                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 h-4 rounded-full transition-all duration-1000 ease-out relative"
                     style="width: {{ $progressValue == 0 ? 0 : max($progressValue, 2) }}%">
                    <div class="absolute inset-0 overflow-hidden rounded-full">
                        <div class="w-full h-full opacity-30" style="background-image: repeating-linear-gradient(-45deg, rgba(255,255,255,0.25), rgba(255,255,255,0.25) 1rem, transparent 1rem, transparent 2rem); background-size: 200% 200%; animation: barberpole 20s linear infinite;"></div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes barberpole { 100% { background-position: 100% 100%; } }
        </style>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-orange-50 text-orange-500"><i class="fas fa-chart-pie"></i></span>
                    Komposisi Antrean
                </h2>
                <div class="flex-1 relative flex items-center justify-center w-full">
                    @if($totalAntrean == 0)
                        <div class="text-center text-slate-400 flex flex-col items-center">
                            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-check text-3xl text-emerald-400"></i>
                            </div>
                            <p class="font-medium text-slate-500">Tidak ada data yang menunggu.</p>
                        </div>
                    @else
                        <div class="w-full h-[280px]">
                            <canvas id="pieChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-blue-50 text-blue-500"><i class="fas fa-chart-bar"></i></span>
                    Perbandingan Data
                </h2>
                <div class="flex-1 relative w-full h-[280px]">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

        </div>

        <h2 class="text-xl font-extrabold text-slate-800 mb-5 px-1 flex items-center gap-2">
            <i class="fas fa-bolt text-amber-400"></i> Akses Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <a href="{{ route('dosen.rpk.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 hover:border-orange-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-orange-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="bg-orange-50 text-orange-500 w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 border border-orange-100 group-hover:bg-gradient-to-br group-hover:from-orange-400 group-hover:to-orange-600 group-hover:text-white group-hover:border-transparent transition-all duration-300">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-800 text-lg group-hover:text-orange-600 transition-colors">Verifikasi RPK</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">Tinjau Rencana Prestasi Kegiatan (RPK) mahasiswa.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('dosen.spk.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="bg-emerald-50 text-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 border border-emerald-100 group-hover:bg-gradient-to-br group-hover:from-emerald-400 group-hover:to-emerald-600 group-hover:text-white group-hover:border-transparent transition-all duration-300">
                        <i class="fas fa-stamp"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-800 text-lg group-hover:text-emerald-600 transition-colors">Verifikasi SPK</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">Sahkan Sertifikat Prestasi Kegiatan (SPK) diajukan.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('dosen.mahasiswa.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-indigo-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="bg-indigo-50 text-indigo-500 w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 border border-indigo-100 group-hover:bg-gradient-to-br group-hover:from-indigo-400 group-hover:to-indigo-600 group-hover:text-white group-hover:border-transparent transition-all duration-300">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">Data Mahasiswa</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">Lihat profil dan rekap prestasi seluruh bimbingan.</p>
                    </div>
                </div>
            </a>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function jalankanGrafikDosen() {
    
    // FUNGSI PENUNGGU: Jangan eksekusi apapun sebelum Canvas dan Chart.js 100% siap
    function inisialisasiSaatSiap() {
        if (typeof Chart === 'undefined') {
            setTimeout(inisialisasiSaatSiap, 50);
            return;
        }

        const barCanvas = document.getElementById('barChart');
        if (!barCanvas) {
            setTimeout(inisialisasiSaatSiap, 50);
            return;
        }

        // --- JIKA KEDUANYA SUDAH MUNCUL DI LAYAR, BARU NGEBUT ---

        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';

        function createSafeChart(id, config) {
            const canvas = document.getElementById(id);
            if (!canvas) return;

            const existingChart = Chart.getChart(id);
            if (existingChart) {
                existingChart.destroy();
            }

            return new Chart(canvas, config);
        }

        @if($rpkMenunggu > 0 || $spkMenunggu > 0)
        // 1. Pie Chart
        createSafeChart('pieChart', {
            type: 'doughnut', 
            data: {
                labels: ['Draft RPK', 'Draft SPK'],
                datasets: [{
                    data: [{{ $rpkMenunggu }}, {{ $spkMenunggu }}],
                    backgroundColor: ['#f97316', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', 
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
        @endif

        // 2. Bar Chart
        createSafeChart('barChart', {
            type: 'bar',
            data: {
                labels: ['Mahasiswa Bimbingan', 'RPK (Draft)', 'SPK (Draft)'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $totalMahasiswa }}, {{ $rpkMenunggu }}, {{ $spkMenunggu }}],
                    backgroundColor: ['#3b82f6', '#f97316', '#10b981'],
                    borderRadius: 6,
                    barPercentage: 0.5 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, 
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#f1f5f9', drawBorder: false },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    }

    // Perintahkan satpam penunggu mulai berjaga
    inisialisasiSaatSiap();

})();
</script>

</x-app-layout>