<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRESMA - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Custom scrollbar untuk daftar rekap */
        .rekap-scroll::-webkit-scrollbar { width: 6px; }
        .rekap-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .rekap-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_isi_welcome.png') }}" alt="Logo Instansi" class="h-12 w-auto object-contain">
            <div>
                <h1 class="font-bold text-xl tracking-tight text-gray-900 leading-none">SIPRESMA</h1>
                <p class="text-xs text-gray-500 font-medium mt-1">Sistem Prestasi Mahasiswa ISI Yogyakarta</p>
            </div>
        </div>
        <div class="flex items-center gap-6">
          <details class="relative">
    <summary class="cursor-pointer list-none text-red-400 hover:text-red-600 text-sm font-medium flex items-center gap-2">
        <i class="far fa-question-circle text-lg"></i>
        Panduan Pengguna
    </summary>

    <div class="absolute mt-2 w-72 bg-white border rounded-lg shadow-lg z-50">

        <a href="https://youtube.com/watch?v=XXXXXXXXXXX"
           target="_blank"
           class="block px-2 py-2 hover:bg-gray-100">
            <i class="fab fa-youtube text-red-500 mr-2"></i>
            Video Tutorial Sipresma
        </a>

        <a href="{{ asset('panduan/Panduan_SIPRESMA.pdf') }}"
           target="_blank"
           class="block px-2 py-2 hover:bg-gray-100">
            <i class="fas fa-file-pdf text-red-500 mr-2"></i>
            Buku Panduan PDF
        </a>

    </div>
</details>
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm transition">
                    <i class="fas fa-columns"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm transition">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </a>
            @endauth
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-6 py-8">
        
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Beranda</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($totalMahasiswa, 0, ',', '.') }}</p>
                </div>
                <div class="bg-cyan-100 w-14 h-14 rounded-full flex items-center justify-center text-cyan-500 text-2xl">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">SPK (Draft/Disetujui)</p>
                    <p class="text-3xl font-bold text-gray-800 flex items-baseline gap-1">{{ $spkDraft }}/{{ $spkDisetujui }}</p>
                </div>
                <div class="bg-orange-100 w-14 h-14 rounded-full flex items-center justify-center text-orange-400 text-2xl">
                    <i class="fas fa-medal"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">Total Mahasiswa Berprestasi</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($mahasiswaBerprestasi, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center text-green-500 text-2xl">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
            
            <div class="lg:col-span-4 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[600px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Rekap Prestasi Terbaru</h3>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4 rekap-scroll">
                    @forelse($rekapPrestasi as $spk)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h4 class="text-gray-800 font-semibold">{{ $spk->user->name ?? 'Anonim' }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $spk->kegiatan->kegiatan ?? $spk->keterangan }} 
                                        @if(isset($spk->kegiatan->tingkat)) (Tingkat {{ $spk->kegiatan->tingkat }}) @endif
                                    </p>
                                </div>
                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400">
                            Belum ada rekap prestasi yang disetujui.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-8 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[600px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Statistik Prestasi Program Studi Tahun {{ date('Y') }}</h3>
                </div>
                <div class="p-6 flex-1 w-full relative">
                    <canvas id="prestasiChart"></canvas>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[400px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Prestasi Berdasarkan Tingkat</h3>
                </div>
                <div class="p-6 flex-1 w-full relative">
                    <canvas id="tingkatChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[400px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Distribusi Jenis Kegiatan</h3>
                </div>
                <div class="p-6 flex-1 w-full relative flex items-center justify-center">
                    <canvas id="jenisChart"></canvas>
                </div>
            </div>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Palet Warna untuk Chart
            const colorPalette = [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6', '#f43f5e'
            ];

            // 1. Chart Prodi (Bar Chart)
            const ctxProdi = document.getElementById('prestasiChart').getContext('2d');
            new Chart(ctxProdi, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: '#4ade80',
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: { color: '#e5e7eb' },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                maxRotation: 90, minRotation: 90,
                                autoSkip: false, font: { size: 11 }, color: '#6b7280'
                            },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 2. Chart Tingkat (Bar Chart)
            const ctxTingkat = document.getElementById('tingkatChart').getContext('2d');
            new Chart(ctxTingkat, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($tingkatLabels) !!},
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: {!! json_encode($tingkatData) !!},
                        backgroundColor: '#3b82f6', // Biru
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: { color: '#e5e7eb' }
                        },
                        x: {
                            grid: { display: false }
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
                        borderWidth: 2,
                        borderColor: '#ffffff'
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
                                font: { size: 12 }
                            }
                        }
                    },
                    cutout: '65%' // Besaran lubang tengah Donut
                }
            });
        });
    </script>
</body>
</html>