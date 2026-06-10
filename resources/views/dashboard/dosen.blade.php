<x-app-layout>

<div class="py-8">
<div class="max-w-8xl mx-auto py-6">

    <!-- Hero -->
    <div class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 rounded-3xl p-8 text-white shadow-lg mb-8">

        <h1 class="text-3xl font-bold">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p class="mt-2 text-white">
            Dashboard Dosen Pembimbing SIPRESMA
        </p>

        <div class="mt-4 flex flex-wrap gap-6 text-sm">
            <span>
                Monitoring Prestasi Mahasiswa
            </span>
        </div>

    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Mahasiswa Bimbingan
            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $totalMahasiswa }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                RPK Menunggu
            </p>

            <h2 class="text-4xl font-bold text-orange-500 mt-2">
                {{ $rpkMenunggu }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                SPK Menunggu
            </p>

            <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                {{ $spkMenunggu }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Total Verifikasi
            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $rpkMenunggu + $spkMenunggu }}
            </h2>

        </div>

    </div>

    <!-- Progress -->
    <div class="bg-white rounded-2xl shadow p-6 mb-8">

        <div class="flex justify-between mb-3">

            <h2 class="font-bold text-gray-800">
                Progress Verifikasi
            </h2>

            <span>
                {{ $rpkMenunggu + $spkMenunggu }} Data
            </span>

        </div>

        <div class="w-full bg-gray-200 rounded-full h-5">

            <div
                class="bg-gradient-to-r from-emerald-500 to-teal-600 h-5 rounded-full"
                style="width: {{ min((($rpkMenunggu + $spkMenunggu)/100)*100,100) }}%">
            </div>

        </div>

    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- Pie -->
        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="font-bold mb-4">
                Data Menunggu Verifikasi
            </h2>

            <canvas id="pieChart"></canvas>

        </div>

        <!-- Bar -->
        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="font-bold mb-4">
                Perbandingan Data
            </h2>

            <canvas id="barChart"></canvas>

        </div>

    </div>

    <!-- Menu Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('dosen.kegiatan.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">

            <h3 class="font-bold text-lg text-blue-600">
                Verifikasi RPK
            </h3>

            <p class="text-gray-500 mt-2">
                Tinjau dan verifikasi kegiatan mahasiswa
            </p>

        </a>

        <a href="{{ route('dosen.spk.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">

            <h3 class="font-bold text-lg text-green-600">
                Verifikasi SPK
            </h3>

            <p class="text-gray-500 mt-2">
                Tinjau dan verifikasi SPK mahasiswa
            </p>

        </a>

        <a href="{{ route('dosen.mahasiswa.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">

            <h3 class="font-bold text-lg text-purple-600">
                Data Mahasiswa
            </h3>

            <p class="text-gray-500 mt-2">
                Lihat daftar mahasiswa bimbingan
            </p>

        </a>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('pieChart'), {

    type: 'pie',

    data: {

        labels: ['RPK Menunggu', 'SPK Menunggu'],

        datasets: [{
            data: [
                {{ $rpkMenunggu }},
                {{ $spkMenunggu }}
            ],

            backgroundColor: [
                '#f97316',
                '#22c55e'
            ]
        }]
    }

});

new Chart(document.getElementById('barChart'), {

    type: 'bar',

    data: {

        labels: [
            'Mahasiswa',
            'RPK',
            'SPK'
        ],

        datasets: [{

            label: 'Jumlah Data',

            data: [
                {{ $totalMahasiswa }},
                {{ $rpkMenunggu }},
                {{ $spkMenunggu }}
            ],

            backgroundColor: [
                '#3b82f6',
                '#f97316',
                '#22c55e'
            ]

        }]

    }

});

</script>

</x-app-layout>