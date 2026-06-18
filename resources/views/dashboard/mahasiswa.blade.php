<x-app-layout>

<div class="py-6 overflow-x-hidden">
    <div class="max-w-8xl mx-auto py-6">

        <div class="relative bg-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-2xl shadow-slate-900/20 mb-6 overflow-hidden border border-slate-800">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-blue-600 to-purple-600 opacity-20 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-gradient-to-tr from-indigo-500 to-teal-400 opacity-20 rounded-full blur-[80px]"></div>
            
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <p class="text-blue-300 font-bold tracking-[0.2em] text-xs uppercase mb-2 drop-shadow-sm">SIPRESMA ISI Yogyakarta</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight truncate text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-medium">
                        <span class="bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner">
                            <i class="fas fa-id-card text-blue-400"></i> NIM: {{ Auth::user()->nim }}
                        </span>
                        <span class="bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner">
                            <i class="fas fa-graduation-cap text-purple-400"></i> {{ Auth::user()->prodi }}
                        </span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center justify-center w-28 h-28 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-full border border-white/10 shadow-[0_0_40px_rgba(59,130,246,0.15)] shrink-0 group hover:scale-105 transition-transform duration-500">
                    <i class="fas fa-user-graduate text-5xl text-transparent bg-clip-text bg-gradient-to-br from-blue-200 to-purple-400 group-hover:from-white group-hover:to-blue-200 transition-colors"></i>
                </div>
            </div>
        </div>

        <div class="relative bg-gradient-to-r from-indigo-50 to-white rounded-2xl shadow-sm border border-indigo-100 p-6 mb-8 flex items-center gap-5 hover:shadow-md transition-all duration-300 overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-100/50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            
            <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shrink-0 border border-indigo-100 shadow-sm relative z-10 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-chalkboard-teacher text-2xl text-indigo-600"></i>
            </div>
            <div class="relative z-10 min-w-0">
                <h2 class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Dosen Pembimbing</h2>
                @if($dosenPembimbing)
                    <p class="text-xl font-extrabold text-slate-800 truncate">{{ $dosenPembimbing->name }}</p>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">Pendamping & Verifikator Prestasi</p>
                @else
                    <p class="text-lg font-bold text-red-500 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> Belum memiliki dosen pembimbing
                    </p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">RPK Draft</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-orange-500 transition-colors mt-1">{{ $rpkDraft }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-500 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-file-alt"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">RPK Disetujui</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-emerald-500 transition-colors mt-1">{{ $rpkDisetujui }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-check-square"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-amber-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">SPK Draft</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-amber-500 transition-colors mt-1">{{ $spkDraft }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-50 to-amber-100 text-amber-500 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-certificate"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-teal-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-400 to-teal-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">SPK Disetujui</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-teal-500 transition-colors mt-1">{{ $spkDisetujui }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-teal-50 to-teal-100 text-teal-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-stamp"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">Total Poin</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors mt-1">{{ $totalPoin }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-star"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">Total Kegiatan</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-purple-500 transition-colors mt-1">{{ $totalKegiatan }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-tasks"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-red-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">Ditolak</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-red-500 transition-colors mt-1">{{ $ditolak }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 text-red-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-times-circle"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-cyan-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">% Disetujui</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-cyan-500 transition-colors mt-1">{{ $persentase }}%</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-50 to-cyan-100 text-cyan-600 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-chart-line"></i></div>
            </div>

        </div>

        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-yellow-50 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row justify-between sm:items-end mb-4 gap-4">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-yellow-50 text-yellow-500"><i class="fas fa-trophy"></i></span> 
                        Progress Poin Prestasi
                    </h2>
                    <p class="text-sm text-slate-500 mt-1.5">Kumpulkan poin prestasi (minimal 100) untuk memenuhi syarat SKPI kelulusan.</p>
                </div>
                <div class="inline-flex items-center justify-center px-4 py-1.5 bg-slate-900 rounded-full shrink-0 shadow-md">
                    <span class="font-extrabold text-white text-sm">{{ $totalPoin }} / 100 Poin</span>
                </div>
            </div>
            
            <div class="relative z-10 w-full bg-slate-100/80 rounded-full h-4 overflow-hidden border border-slate-200/60 shadow-inner">
                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 h-4 rounded-full transition-all duration-1000 ease-out relative"
                     style="width: {{ min(($totalPoin/100)*100, 100) }}%">
                    <div class="absolute inset-0 overflow-hidden rounded-full">
                        <div class="w-full h-full opacity-30" style="background-image: repeating-linear-gradient(-45deg, rgba(255,255,255,0.25), rgba(255,255,255,0.25) 1rem, transparent 1rem, transparent 2rem); background-size: 200% 200%; animation: barberpole 20s linear infinite;"></div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes barberpole { 100% { background-position: 100% 100%; } }
        </style>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-blue-50 text-blue-500"><i class="fas fa-chart-pie"></i></span>
                    Status Kegiatan
                </h2>
                <div class="flex-1 relative w-full h-[280px]">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-orange-50 text-orange-500"><i class="fas fa-layer-group"></i></span>
                    Prestasi Berdasarkan Tingkat
                </h2>
                <div class="flex-1 relative w-full h-[280px]">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-purple-50 text-purple-500"><i class="fas fa-shapes"></i></span>
                    Distribusi Jenis Kegiatan
                </h2>
                <div class="flex-1 relative w-full h-[280px]">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[400px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6">
                    <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-500"><i class="fas fa-chart-area"></i></span>
                    Aktivitas Per Bulan
                </h2>
                <div class="flex-1 relative w-full h-[280px]">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Global Chart Config
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                padding: 12,
                cornerRadius: 8
            }
        }
    };

    // 1. Pie Chart (Status Kegiatan)
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Draft', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: @json([$draft, $disetujui, $ditolak]),
                backgroundColor: ['#f97316', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });

    // 2. Bar Chart (Tingkat)
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Universitas', 'Regional', 'Nasional', 'Internasional'],
            datasets: [{
                label: 'Jumlah Prestasi',
                data: {{ Js::from([$universitas, $regional, $nasional, $internasional]) }},
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                barPercentage: 0.5
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9', drawBorder: false }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    // 3. Donut Chart (Jenis Kegiatan)
    const modernPalette = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9', '#f43f5e', '#14b8a6'];
    
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: @json($jenisLabels),
            datasets: [{
                data: @json($jenisData),
                backgroundColor: modernPalette,
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            ...commonOptions,
            cutout: '65%',
            plugins: {
                ...commonOptions.plugins,
                legend: { position: 'right', labels: { usePointStyle: true, padding: 15, font: { size: 11 } } }
            }
        }
    });

    // 4. Line Chart (Aktivitas)
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Aktivitas',
                data: @json($bulanData),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                borderWidth: 3,
                tension: 0.4, // Membuat garis menjadi melengkung mulus (smooth)
                fill: true,   // Efek area di bawah garis
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9', drawBorder: false }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

});
</script>

</x-app-layout>