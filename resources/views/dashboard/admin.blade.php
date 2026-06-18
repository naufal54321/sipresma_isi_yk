<x-app-layout>

<div class="py-6 overflow-x-hidden">
    <div class="max-w-8xl mx-auto py-6">

        <div class="relative bg-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-2xl shadow-slate-900/20 mb-8 overflow-hidden border border-slate-800">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-blue-600 to-purple-600 opacity-20 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-gradient-to-tr from-indigo-500 to-teal-400 opacity-20 rounded-full blur-[80px]"></div>
            
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <p class="text-blue-300 font-bold tracking-[0.2em] text-xs uppercase mb-2 drop-shadow-sm">Administrator Workspace</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight truncate text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">
                        Dashboard SIPRESMA
                    </h1>
                    <p class="mt-3 text-slate-400 max-w-2xl text-sm sm:text-base leading-relaxed line-clamp-2 sm:line-clamp-none">
                        Sistem Informasi Prestasi Mahasiswa (SIPRESMA). Pantau seluruh aktivitas, data master, dan rekapitulasi sistem secara real-time.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold">
                        <span class="bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner">
                            <i class="fas fa-users text-blue-400"></i> {{ $totalMahasiswa }} Mahasiswa
                        </span>
                        <span class="bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 shadow-inner">
                            <i class="fas fa-chalkboard-teacher text-purple-400"></i> {{ $totalDosen }} Dosen
                        </span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center justify-center w-28 h-28 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-full border border-white/10 shadow-[0_0_40px_rgba(59,130,246,0.15)] shrink-0 group hover:scale-105 transition-transform duration-500">
                    <i class="fas fa-shield-alt text-5xl text-transparent bg-clip-text bg-gradient-to-br from-blue-200 to-purple-400 group-hover:from-white group-hover:to-blue-200 transition-colors"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate mb-1">Total Mahasiswa</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors mt-1">{{ $totalMahasiswa }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100/50 text-blue-500 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300"><i class="fas fa-users"></i></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate mb-1">Total Dosen</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-purple-500 transition-colors mt-1">{{ $totalDosen }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100/50 text-purple-500 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300"><i class="fas fa-chalkboard-teacher"></i></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate mb-1">Total Dokumen RPK</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-orange-500 transition-colors mt-1">{{ $totalRpk }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100/50 text-orange-500 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300"><i class="fas fa-file-alt"></i></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate mb-1">Total Dok. SPK</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-emerald-500 transition-colors mt-1">{{ $totalSpk }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100/50 text-emerald-500 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0 group-hover:rotate-12 transition-transform duration-300"><i class="fas fa-certificate"></i></div>
            </div>
        </div>

        <h2 class="text-lg font-bold text-slate-800 mb-4 px-1 flex items-center gap-2"><i class="fas fa-tasks text-blue-500"></i> Rincian Status Pengajuan</h2>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 relative overflow-hidden group hover:border-orange-200 transition-colors">
                <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-bl from-orange-50 to-transparent rounded-bl-full opacity-50"></div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-3 relative z-10">Status RPK</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 relative z-10">
                    <div class="text-center p-3 bg-orange-50/50 rounded-xl border border-orange-100/50 hover:bg-orange-50 transition-colors">
                        <p class="text-xs font-semibold text-orange-600 mb-1">Draft</p><h4 class="text-xl sm:text-2xl font-bold text-orange-500">{{ $rpkDraft }}</h4>
                    </div>
                    <div class="text-center p-3 bg-emerald-50/50 rounded-xl border border-emerald-100/50 hover:bg-emerald-50 transition-colors">
                        <p class="text-xs font-semibold text-emerald-600 mb-1">Disetujui</p><h4 class="text-xl sm:text-2xl font-bold text-emerald-500">{{ $rpkDisetujui }}</h4>
                    </div>
                    <div class="text-center p-3 bg-red-50/50 rounded-xl border border-red-100/50 hover:bg-red-50 transition-colors">
                        <p class="text-xs font-semibold text-red-600 mb-1">Ditolak</p><h4 class="text-xl sm:text-2xl font-bold text-red-500">{{ $rpkDitolak }}</h4>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 relative overflow-hidden group hover:border-emerald-200 transition-colors">
                <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full opacity-50"></div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-3 relative z-10">Status SPK</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 relative z-10">
                    <div class="text-center p-3 bg-orange-50/50 rounded-xl border border-orange-100/50 hover:bg-orange-50 transition-colors">
                        <p class="text-xs font-semibold text-orange-600 mb-1">Draft</p><h4 class="text-xl sm:text-2xl font-bold text-orange-500">{{ $spkDraft }}</h4>
                    </div>
                    <div class="text-center p-3 bg-emerald-50/50 rounded-xl border border-emerald-100/50 hover:bg-emerald-50 transition-colors">
                        <p class="text-xs font-semibold text-emerald-600 mb-1">Disetujui</p><h4 class="text-xl sm:text-2xl font-bold text-emerald-500">{{ $spkDisetujui }}</h4>
                    </div>
                    <div class="text-center p-3 bg-red-50/50 rounded-xl border border-red-100/50 hover:bg-red-50 transition-colors">
                        <p class="text-xs font-semibold text-red-600 mb-1">Ditolak</p><h4 class="text-xl sm:text-2xl font-bold text-red-500">{{ $spkDitolak }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[350px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4"><span class="p-1.5 rounded-lg bg-orange-50 text-orange-500"><i class="fas fa-chart-pie"></i></span> Status Dokumen RPK</h2>
                <div class="flex-1 relative w-full h-[250px]"><canvas id="rpkChart"></canvas></div>
            </div>
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[350px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4"><span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-500"><i class="fas fa-chart-pie"></i></span> Status Dokumen SPK</h2>
                <div class="flex-1 relative w-full h-[250px]"><canvas id="spkChart"></canvas></div>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 mb-6 flex flex-col min-h-[400px]">
            <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4"><span class="p-1.5 rounded-lg bg-blue-50 text-blue-500"><i class="fas fa-chart-bar"></i></span> Perbandingan Keseluruhan Data Sistem</h2>
            <div class="flex-1 relative w-full h-[300px]"><canvas id="summaryChart"></canvas></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[350px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4"><span class="p-1.5 rounded-lg bg-blue-50 text-blue-500"><i class="fas fa-layer-group"></i></span> Prestasi Berdasarkan Tingkat</h2>
                <div class="flex-1 relative w-full h-[250px]"><canvas id="tingkatChart"></canvas></div>
            </div>
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[350px]">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4"><span class="p-1.5 rounded-lg bg-purple-50 text-purple-500"><i class="fas fa-shapes"></i></span> Distribusi Jenis Kegiatan</h2>
                <div class="flex-1 relative w-full h-[250px]"><canvas id="jenisChart"></canvas></div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="bg-gradient-to-b from-white to-slate-50 border border-slate-100 rounded-2xl shadow-sm p-5 sm:p-6 xl:col-span-1 h-fit">
                <h2 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-yellow-50 text-yellow-500"><i class="fas fa-trophy"></i></span> Top 5 Mahasiswa
                </h2>
                <div class="space-y-3">
                    @forelse($topMahasiswa as $mhs)
                    <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-100 hover:shadow-md transition-shadow group gap-3">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 
                                {{ $loop->index == 0 ? 'bg-gradient-to-br from-yellow-100 to-amber-200 text-yellow-700' : ($loop->index == 1 ? 'bg-gradient-to-br from-slate-100 to-slate-300 text-slate-700' : ($loop->index == 2 ? 'bg-gradient-to-br from-orange-100 to-orange-300 text-orange-800' : 'bg-slate-50 text-blue-600')) }}">
                                #{{ $loop->iteration }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-slate-800 text-sm truncate group-hover:text-blue-600 transition-colors">{{ $mhs->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ $mhs->nim }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 font-bold text-xs rounded-lg whitespace-nowrap">{{ $mhs->total_poin ?? 0 }} Poin</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6 text-slate-400">
                        <i class="fas fa-medal text-3xl mb-2 text-slate-200"></i>
                        <p class="text-sm">Belum ada data prestasi</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden xl:col-span-2 flex flex-col">
                <div class="px-5 sm:px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-blue-50 text-blue-500"><i class="fas fa-history"></i></span> Log Aktivitas Sistem
                    </h2>
                </div>
                
                <div class="overflow-x-auto flex-1 w-full">
                    <table class="min-w-full text-sm text-left text-slate-600">
                        <thead class="bg-white uppercase text-[11px] font-bold tracking-wider text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 whitespace-nowrap">Aktor / Pengguna</th>
                                <th class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">Aktivitas</th>
                                <th class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">Waktu</th>
                                <th class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($aktivitasTerbaru as $item)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-4 sm:px-6 py-4 min-w-[150px]">
                                    <div class="font-bold text-slate-800 truncate">{{ $item['aktor'] }}</div>
                                    <div class="mt-1">
                                        @if($item['role'] == 'Dosen')
                                            <span class="inline-flex bg-purple-50 text-purple-600 border border-purple-100 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider">Dosen</span>
                                        @else
                                            <span class="inline-flex bg-blue-50 text-blue-600 border border-blue-100 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider">Mahasiswa</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-center text-slate-700 font-medium min-w-[150px]">
                                    {{ $item['aktivitas'] }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-center min-w-[140px]">
                                    <div class="text-slate-800 font-medium whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('DD MMMM YYYY') }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 font-semibold mt-0.5 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-center min-w-[100px]">
                                    @if($item['status'] == 'draft')
                                        <span class="inline-flex items-center justify-center min-w-[70px] bg-orange-500 text-white px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider">Draft</span>
                                    @elseif($item['status'] == 'disetujui')
                                        <span class="inline-flex items-center justify-center min-w-[70px] bg-green-500 text-white px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider">Disetujui</span>
                                    @else
                                        <span class="inline-flex items-center justify-center min-w-[70px] bg-red-500 text-white px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-slate-400">
                                    <i class="fas fa-inbox text-3xl mb-2 text-slate-200"></i>
                                    <p class="text-sm">Belum ada aktivitas terekam.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', padding: 12, cornerRadius: 8 }
        }
    };

    new Chart(document.getElementById('rpkChart'), {
        type: 'doughnut',
        data: {
            labels: ['Draft', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $rpkDraft }}, {{ $rpkDisetujui }}, {{ $rpkDitolak }}],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0, hoverOffset: 4
            }]
        },
        options: { ...commonOptions, cutout: '65%', plugins: { ...commonOptions.plugins, legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } } }
    });

    new Chart(document.getElementById('spkChart'), {
        type: 'doughnut',
        data: {
            labels: ['Draft', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $spkDraft }}, {{ $spkDisetujui }}, {{ $spkDitolak }}],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0, hoverOffset: 4
            }]
        },
        options: { ...commonOptions, cutout: '65%', plugins: { ...commonOptions.plugins, legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } } }
    });

    new Chart(document.getElementById('summaryChart'), {
        type: 'bar',
        data: {
            labels: ['Mahasiswa', 'Dosen', 'RPK', 'SPK'],
            datasets: [{
                label: 'Jumlah Data',
                data: [{{ $totalMahasiswa }}, {{ $totalDosen }}, {{ $totalRpk }}, {{ $totalSpk }}],
                backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981'],
                borderRadius: 6,
                barPercentage: 0.5
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('tingkatChart'), {
        type: 'bar',
        data: {
            labels: ['Universitas', 'Regional', 'Nasional', 'Internasional'],
            datasets: [{
                label: 'Jumlah Prestasi',
                data: [{{ $universitas }}, {{ $regional }}, {{ $nasional }}, {{ $internasional }}],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
                borderRadius: 6,
                barPercentage: 0.5
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    const modernPalette = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9', '#f43f5e', '#14b8a6'];
    new Chart(document.getElementById('jenisChart'), {
        type: 'doughnut',
        data: {
            labels: @json($jenisLabels),
            datasets: [{
                data: @json($jenisData),
                backgroundColor: modernPalette,
                borderWidth: 0, hoverOffset: 4
            }]
        },
        options: {
            ...commonOptions,
            cutout: '65%',
            plugins: { ...commonOptions.plugins, legend: { position: 'right', labels: { usePointStyle: true, padding: 15, font: { size: 11 } } } }
        }
    });

});
</script>

</x-app-layout>