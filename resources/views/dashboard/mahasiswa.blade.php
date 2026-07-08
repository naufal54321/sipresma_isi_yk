<x-app-layout>

<div class="py-6 overflow-x-hidden">
    <div class="max-w-8xl mx-auto py-6">

        {{-- HERO --}}
        <div class="relative bg-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-2xl shadow-slate-900/20 mb-6 overflow-hidden border border-slate-800">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-gradient-to-br from-blue-600 to-purple-600 opacity-20 rounded-full blur-[80px] animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-gradient-to-tr from-indigo-500 to-teal-400 opacity-20 rounded-full blur-[80px] animate-pulse" style="animation-delay: 1s"></div>
            
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <p class="text-blue-300 font-semibold tracking-[0.15em] text-xs uppercase mb-2">SIPRESMA ISI Yogyakarta</p>
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-normal text-white">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <div class="mt-6 flex flex-wrap gap-3 text-sm font-medium">
                        <span class="bg-white/10 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-id-card text-blue-400"></i> NIM: {{ Auth::user()->nim }}
                        </span>
                        <span class="bg-white/10 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2 hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-graduation-cap text-purple-400"></i> {{ Auth::user()->prodi }}
                        </span>
                    </div>
                </div>
                
                {{-- Gunungan Siluet --}}
                <div class="hidden md:flex items-center justify-center w-28 h-28 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-full border border-white/10 shadow-[0_0_40px_rgba(59,130,246,0.15)] shrink-0 group hover:scale-105 transition-transform duration-500 animate-float-slow">
                    <svg class="w-14 h-14" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L20 9L18 18L12 22L6 18L4 9L12 2Z" fill="url(#grad-g4)" opacity="0.3"/>
                        <path d="M12 5L17 10L15.5 16L12 18.5L8.5 16L7 10L12 5Z" fill="url(#grad-g4)" opacity="0.6"/>
                        <circle cx="12" cy="9" r="2" fill="white" opacity="0.5"/>
                        <defs>
                            <linearGradient id="grad-g4" x1="4" y1="2" x2="20" y2="22">
                                <stop offset="0%" stop-color="#60a5fa"/>
                                <stop offset="50%" stop-color="#a78bfa"/>
                                <stop offset="100%" stop-color="#c084fc"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Dosen Pembimbing --}}
        <div class="relative bg-gradient-to-r from-indigo-50 to-white rounded-2xl shadow-sm border border-indigo-100 p-6 mb-8 flex items-center gap-5 hover:shadow-md transition-all duration-300 overflow-hidden group animate-fade-in-up">
            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-100/50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            
            <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shrink-0 border border-indigo-100 shadow-sm relative z-10 group-hover:rotate-12 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                    <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                    <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                </svg>
            </div>
            <div class="relative z-10 min-w-0">
                <h2 class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Dosen Pembimbing</h2>
                @if($dosenPembimbing)
                    <p class="text-xl font-extrabold text-slate-800 truncate">{{ $dosenPembimbing->name }}</p>
                @else
                    <p class="text-lg font-bold text-red-500 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle animate-pulse-soft"></i> Belum memiliki dosen pembimbing
                    </p>
                @endif
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            @php $cards = [
                ['label' => 'RPK Draft', 'value' => $rpkDraft, 'color' => 'orange', 'icon' => 'fa-file-alt', 'delay' => '0.1s'],
                ['label' => 'RPK Disetujui', 'value' => $rpkDisetujui, 'color' => 'emerald', 'icon' => 'fa-check-square', 'delay' => '0.15s'],
                ['label' => 'SPK Draft', 'value' => $spkDraft, 'color' => 'amber', 'icon' => 'fa-certificate', 'delay' => '0.2s'],
                ['label' => 'SPK Disetujui', 'value' => $spkDisetujui, 'color' => 'teal', 'icon' => 'fa-check-circle', 'delay' => '0.25s'],
                ['label' => 'Total Poin', 'value' => $totalPoin, 'color' => 'blue', 'icon' => 'fa-star', 'delay' => '0.3s'],
                ['label' => 'Total RPK & SPK', 'value' => $totalKegiatan, 'color' => 'purple', 'icon' => 'fa-tasks', 'delay' => '0.35s'],
                ['label' => 'Ditolak', 'value' => $jumlahDitolak, 'color' => 'red', 'icon' => 'fa-times-circle', 'delay' => '0.4s'],
                ['label' => '% Disetujui', 'value' => $persentase . '%', 'color' => 'cyan', 'icon' => 'fa-chart-line', 'delay' => '0.45s'],
            ]; @endphp
            @foreach($cards as $card)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center group hover:-translate-y-1.5 hover:shadow-xl hover:shadow-{{ $card['color'] }}-500/10 transition-all duration-300 relative overflow-hidden animate-scale-in" style="animation-delay: {{ $card['delay'] }}">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-{{ $card['color'] }}-400 to-{{ $card['color'] }}-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="min-w-0"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate">{{ $card['label'] }}</p><h2 class="text-3xl font-extrabold text-slate-800 group-hover:text-{{ $card['color'] }}-500 transition-colors mt-1" id="counter-{{ $loop->index }}">{{ $card['value'] }}</h2></div>
                <div class="w-12 h-12 bg-gradient-to-br from-{{ $card['color'] }}-50 to-{{ $card['color'] }}-100 text-{{ $card['color'] }}-500 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-transform"><i class="fas {{ $card['icon'] }}"></i></div>
            </div>
            @endforeach
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @php $charts = [
                ['id' => 'pieChart', 'title' => 'Status Kegiatan', 'icon' => 'fa-chart-pie', 'bg' => 'blue', 'delay' => '0.5s'],
                ['id' => 'barChart', 'title' => 'Prestasi Berdasarkan Tingkat', 'icon' => 'fa-layer-group', 'bg' => 'orange', 'delay' => '0.55s'],
                ['id' => 'donutChart', 'title' => 'Distribusi Jenis Kegiatan', 'icon' => 'fa-shapes', 'bg' => 'purple', 'delay' => '0.6s'],
                ['id' => 'lineChart', 'title' => 'Aktivitas Per Bulan', 'icon' => 'fa-chart-area', 'bg' => 'emerald', 'delay' => '0.65s'],
            ]; @endphp
            @foreach($charts as $chart)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col min-h-[400px] hover:shadow-md transition-shadow duration-300 animate-fade-in-up" style="animation-delay: {{ $chart['delay'] }}">
                <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-6"><span class="p-1.5 rounded-lg bg-{{ $chart['bg'] }}-50 text-{{ $chart['bg'] }}-500"><i class="fas {{ $chart['icon'] }}"></i></span>{{ $chart['title'] }}</h2>
                <div class="flex-1 relative w-full h-[280px]"><canvas id="{{ $chart['id'] }}"></canvas></div>
            </div>
            @endforeach
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function jalankanGrafikMahasiswa() {
    function inisialisasiSaatSiap() {
        if (typeof Chart === 'undefined') { setTimeout(inisialisasiSaatSiap, 50); return; }
        const pieCanvas = document.getElementById('pieChart');
        if (!pieCanvas) { setTimeout(inisialisasiSaatSiap, 50); return; }

        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', padding: 12, cornerRadius: 8 } }
        };

        function createSafeChart(id, config) {
            const canvas = document.getElementById(id);
            if (!canvas) return;
            const existingChart = Chart.getChart(id);
            if (existingChart) existingChart.destroy();
            return new Chart(canvas, config);
        }

        createSafeChart('pieChart', {
            type: 'pie',
            data: { labels: ['Draft', 'Disetujui', 'Ditolak'], datasets: [{ data: @json([$draft, $disetujui, $ditolak]), backgroundColor: ['#f97316', '#10b981', '#ef4444'], borderWidth: 0, hoverOffset: 4 }] },
            options: { ...commonOptions, animation: { animateScale: true, duration: 1000 }, plugins: { ...commonOptions.plugins, legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } } }
        });

        createSafeChart('barChart', {
            type: 'bar',
            data: { labels: ['Universitas', 'Regional', 'Nasional', 'Internasional'], datasets: [{ label: 'Jumlah Prestasi', data: {{ Js::from([$universitas, $regional, $nasional, $internasional]) }}, backgroundColor: '#3b82f6', borderRadius: 6, barPercentage: 0.5 }] },
            options: { ...commonOptions, animation: { duration: 1200, easing: 'easeOutQuart' }, plugins: { ...commonOptions.plugins, legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { display: false } }, x: { grid: { display: false }, border: { display: false } } } }
        });

        createSafeChart('donutChart', {
            type: 'doughnut',
            data: { labels: @json($kategoriLabels), datasets: [{ data: @json($kategoriData), backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9', '#f43f5e', '#14b8a6'], borderWidth: 0, hoverOffset: 4 }] },
            options: { ...commonOptions, cutout: '65%', animation: { animateScale: true, animateRotate: true, duration: 1500, easing: 'easeOutBounce' }, plugins: { ...commonOptions.plugins, legend: { position: 'right', labels: { usePointStyle: true, padding: 15, font: { size: 11 } } } } }
        });

        createSafeChart('lineChart', {
            type: 'line',
            data: { labels: @json($bulanLabels), datasets: [{ label: 'Aktivitas', data: @json($bulanData), borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.08)', borderWidth: 3, tension: 0.4, fill: true, pointBackgroundColor: '#ffffff', pointBorderColor: '#2563eb', pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6 }] },
            options: { ...commonOptions, animation: { duration: 1500, easing: 'easeOutQuart' }, plugins: { ...commonOptions.plugins, legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { display: false } }, x: { grid: { display: false }, border: { display: false } } } }
        });
    }
    inisialisasiSaatSiap();
})();
</script>

</x-app-layout>