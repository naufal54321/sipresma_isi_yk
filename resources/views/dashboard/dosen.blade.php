<x-app-layout>

<div class="py-6 overflow-x-hidden">
    <div class="max-w-8xl mx-auto py-6">

        <div class="relative bg-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-2xl shadow-slate-900/20 mb-8 overflow-hidden border border-slate-800">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-blue-600 to-purple-600 opacity-20 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-gradient-to-tr from-indigo-500 to-teal-400 opacity-20 rounded-full blur-[80px]"></div>
            
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <p class="text-blue-300 font-bold tracking-[0.2em] text-xs uppercase mb-2 drop-shadow-sm">Dashboard Dosen Pembimbing</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight truncate text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <p class="mt-3 text-slate-400 max-w-2xl text-sm sm:text-base leading-relaxed line-clamp-2 sm:line-clamp-none">
                        Pantau progres verifikasi dan perkembangan prestasi mahasiswa bimbingan Anda dengan mudah melalui ekosistem digital SIPRESMA.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold">
                        <span class="bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner hover:bg-white/10 transition-colors cursor-default">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            Monitoring Aktif
                        </span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center justify-center w-28 h-28 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-full border border-white/10 shadow-[0_0_40px_rgba(59,130,246,0.15)] shrink-0 group hover:scale-105 transition-transform duration-500">
                    <i class="fas fa-chalkboard-teacher text-5xl text-transparent bg-clip-text bg-gradient-to-br from-blue-200 to-indigo-400 group-hover:from-white group-hover:to-blue-200 transition-colors"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Mhs Bimbingan</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors mt-1">{{ $totalMahasiswa }}</h2>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-blue-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">RPK Menunggu</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-orange-500 transition-colors mt-1">{{ $rpkMenunggu }}</h2>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-orange-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">SPK Menunggu</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 group-hover:text-emerald-500 transition-colors mt-1">{{ $spkMenunggu }}</h2>
                </div>
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 w-14 h-14 rounded-2xl flex items-center justify-center text-emerald-500 text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-certificate"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-slate-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-slate-400 to-slate-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-xs font-bold mb-1 uppercase tracking-widest truncate">Total Verifikasi</p>
                    <h2 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $rpkMenunggu + $spkMenunggu }}</h2>
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
document.addEventListener('DOMContentLoaded', function() {
    
    // Konfigurasi Font Global Chart.js
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    // Pengecekan agar chart tidak di-render jika data kosong (mencegah error visual)
    @if($rpkMenunggu > 0 || $spkMenunggu > 0)
    // 1. Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut', 
        data: {
            labels: ['RPK Menunggu', 'SPK Menunggu'],
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
            cutout: '70%', // Diperbesar sedikit agar lebih elegan
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
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Mhs Bimbingan', 'RPK (Draft)', 'SPK (Draft)'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $totalMahasiswa }}, {{ $rpkMenunggu }}, {{ $spkMenunggu }}],
                backgroundColor: ['#3b82f6', '#f97316', '#10b981'],
                borderRadius: 6, // Ujung bar membulat
                barPercentage: 0.5 // Dikecilkan sedikit agar bar tidak terlalu gemuk
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

});
</script>

</x-app-layout>