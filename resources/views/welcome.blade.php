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
        .rekap-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .rekap-scroll::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        .rekap-scroll::-webkit-scrollbar-thumb {
            background: #ccc; 
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50">
    <div class="flex items-center gap-3">
        
        <img src="{{ asset('images/logo-isi.png') }}" alt="Logo Instansi" class="h-12 w-auto object-contain">
        
        <div>
            <h1 class="font-bold text-xl tracking-tight text-gray-900 leading-none">SIPRESMA</h1>
            <p class="text-xs text-gray-500 font-medium mt-1">Sistem Prestasi Mahasiswa</p>
        </div>
    </div>
    
    
        <div class="flex items-center gap-6">
            <a href="#" class="text-red-400 hover:text-red-600 text-sm font-medium flex items-center gap-2 transition">
                <i class="far fa-question-circle text-lg"></i> Panduan Pengguna
            </a>
            <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm transition">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </a>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-6 py-8">
        
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Beranda</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-800">10847</p>
                </div>
                <div class="bg-cyan-100 w-14 h-14 rounded-full flex items-center justify-center text-cyan-500 text-2xl">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">SPK (Draft/Disetujui)</p>
                    <p class="text-3xl font-bold text-gray-800 flex items-baseline gap-1">763/652</p>
                </div>
                <div class="bg-orange-100 w-14 h-14 rounded-full flex items-center justify-center text-orange-400 text-2xl">
                    <i class="fas fa-medal"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">Total Mahasiswa Berprestasi</p>
                    <p class="text-3xl font-bold text-gray-800">43</p>
                </div>
                <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center text-green-500 text-2xl">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-4 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[600px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Rekap Prestasi</h3>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4 rekap-scroll">
                    
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Nasional (sebagai Juara)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>
                    
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Internasional (sebagai Peserta)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>

                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Regional (sebagai Juara)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>

                     <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Lokal (sebagai Juara)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>
                    
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Nasional (sebagai Peserta)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>

                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-gray-800 font-semibold">Muhammad Naufal Yanuar</h4>
                                <p class="text-sm text-gray-500 mt-1">Lomba Tingkat Regional (sebagai Peserta)</p>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">Disetujui</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-8 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-[600px]">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                    <h3 class="font-bold text-gray-900">Statistik Prestasi Program Studi Tahun 2025</h3>
                </div>
                <div class="p-6 flex-1 w-full relative">
                    <canvas id="prestasiChart"></canvas>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('prestasiChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'S1 Tari', 'S1 Seni Karawitan', 'S1 Musik', 'S1 Penciptaan Musik', 
                        'S1 Pendidikan Musik', 'D4 Penyajian Musik', 'S1 Teater', 'S1 Etnomusikologi', 
                        'S1 Seni Pedalangan', 'S1 Pendidikan Seni Pertunjukan', 'D4 Teater Musikal', 
                        'S1 Seni Murni', 'S1 Kriya', 'D4 Desain Kriya Batik', 'S1 Desain Interior', 
                        'S1 Komunikasi Visual', 'S1 Desain Produk', 'S1 Tata Kelola Seni', 
                        'S1 Konservasi Seni', 'D4 Desain Media', 'S1 Fotografi', 'S1 Film dan Televisi', 
                        'D4 Animasi', 'D4 Produksi Film dan Televisi'
                    ],
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: [4.5, 6.8, 1.8, 9.6, 5.5, 3.2, 6.9, 4.1, 9.5, 6, 6.2, 3.2, 1.2, 3.8, 1.8, 4.6, 1.5, 7.8, 4.6, 9.8, 1.4, 5.8, 3, 2.7], // Data dummy disesuaikan dengan tinggi pada gambar
                        backgroundColor: '#4ade80', // Warna hijau cerah (mirip gambar)
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Menyembunyikan legend karena di gambar tidak ada
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 14,
                            ticks: {
                                stepSize: 2
                            },
                            grid: {
                                color: '#e5e7eb', // Warna garis grid abu-abu tipis
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 90, // Memaksa teks miring 90 derajat
                                minRotation: 90,
                                autoSkip: false, // Menampilkan semua label prodi
                                font: {
                                    size: 11
                                },
                                color: '#6b7280'
                            },
                            grid: {
                                display: false // Menghilangkan garis vertikal
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>