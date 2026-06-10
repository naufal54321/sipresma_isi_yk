<x-app-layout>

<div class="py-8">
<div class="max-w-8xl mx-auto py-6">

    <!-- Hero -->
    <div class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 rounded-3xl p-8 text-white shadow-lg mb-8">

        <h1 class="text-3xl font-bold">
            Dashboard Admin
        </h1>

        <p class="mt-2 text-slate-200">
            Sistem Informasi Prestasi Mahasiswa (SIPRESMA)
        </p>

        <div class="mt-4 flex flex-wrap gap-6 text-sm">
            <span>Total Mahasiswa: {{ $totalMahasiswa }}</span>
            <span>Total Dosen: {{ $totalDosen }}</span>
        </div>

    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-5 shadow">
            <p>Total Mahasiswa</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalMahasiswa }}
            </h2>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl p-5 shadow">
            <p>Total Dosen</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalDosen }}
            </h2>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-5 shadow">
            <p>Total RPK</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalRpk }}
            </h2>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-2xl p-5 shadow">
            <p>Total SPK</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalSpk }}
            </h2>
        </div>

    </div>

    <!-- Statistik Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">RPK Draft</p>
            <h2 class="text-3xl font-bold text-orange-600">
                {{ $rpkDraft }}
            </h2>
        </div>

        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">RPK Disetujui</p>
            <h2 class="text-3xl font-bold text-green-600">
                {{ $rpkDisetujui }}
            </h2>
        </div>

        <div class="bg-red-50 border border-red-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">RPK Ditolak</p>
            <h2 class="text-3xl font-bold text-red-600">
                {{ $rpkDitolak }}
            </h2>
        </div>

    </div>

     <!-- Statistik Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">SPK Draft</p>
            <h2 class="text-3xl font-bold text-orange-600">
                {{ $spkDraft }}
            </h2>
        </div>

        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">SPK Disetujui</p>
            <h2 class="text-3xl font-bold text-green-600">
                {{ $spkDisetujui }}
            </h2>
        </div>

        <div class="bg-red-50 border border-red-100 rounded-2xl p-5 shadow">
            <p class="text-gray-500">SPK Ditolak</p>
            <h2 class="text-3xl font-bold text-red-600">
                {{ $spkDitolak }}
            </h2>
        </div>

    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold text-lg mb-4">
                Status RPK
            </h2>

            <canvas id="rpkChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold text-lg mb-4">
                Status SPK
            </h2>

            <canvas id="spkChart"></canvas>
        </div>

    </div>

    <!-- Grafik Batang -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">

        <h2 class="font-bold text-lg mb-4">
            Perbandingan Data Sistem
        </h2>

        <canvas id="summaryChart"></canvas>

    </div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="font-bold text-lg mb-4">
            Prestasi Berdasarkan Tingkat
        </h2>

        <canvas id="tingkatChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="font-bold text-lg mb-4">
            Distribusi Jenis Kegiatan
        </h2>

        <canvas id="jenisChart"></canvas>
    </div>

</div>

    <div class="bg-white rounded-2xl shadow p-6 mb-8">

    <h2 class="text-lg font-bold mb-4">
        Top 5 Mahasiswa Berprestasi
    </h2>

    <div class="space-y-4">

        @foreach($topMahasiswa as $mhs)

        <div class="flex justify-between border-b pb-3">

            <div>
                <p class="font-semibold">
                    {{ $mhs->name }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ $mhs->nim }}
                </p>
            </div>

            <span class="font-bold text-blue-600">
                {{ $mhs->total_poin ?? 0 }} poin
            </span>

        </div>

        @endforeach

    </div>

</div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b">

            <h2 class="text-lg font-bold">
            Aktivitas Mahasiswa & Dosen
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full table-auto">
    <thead class="bg-gray-50">
<tr>
    <th class="px-4 py-3 text-left">Aktor</th>
    <th class="px-4 py-3 text-left">Role</th>
    <th class="px-4 py-3 text-left">Aktivitas</th>
    <th class="px-4 py-3 text-left">Waktu</th>
    <th class="px-4 py-3 text-left">Status</th>
</tr>
</thead>

  <tbody>

@forelse($aktivitasTerbaru as $item)

<tr class="border-t hover:bg-gray-50">

    <td class="px-4 py-3 font-medium">
        {{ $item['aktor'] }}
    </td>

    <td class="px-4 py-3">

        @if($item['role'] == 'Dosen')

            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                Dosen
            </span>

        @else

            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                Mahasiswa
            </span>

        @endif

    </td>

    <td class="px-4 py-3">
        {{ $item['aktivitas'] }}
    </td>

    <td class="px-4 py-3">

        <div>
            {{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}
        </div>

        <div class="text-xs text-gray-500">
            {{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }} WIB
        </div>

    </td>

    <td class="px-4 py-3">

        @if($item['status'] == 'draft')

            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                Draft
            </span>

        @elseif($item['status'] == 'disetujui')

            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                Disetujui
            </span>

        @else

            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                Ditolak
            </span>

        @endif

    </td>

</tr>

@empty

<tr>
    <td colspan="6" class="text-center py-6 text-gray-500">
        Belum ada aktivitas
    </td>
</tr>

@endforelse

</tbody>
</table>

        </div>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('rpkChart'), {
    type: 'doughnut',
    data: {
        labels: ['Draft', 'Disetujui', 'Ditolak'],
        datasets: [{
            data: [
                {{ $rpkDraft }},
                {{ $rpkDisetujui }},
                {{ $rpkDitolak }}
            ],
            backgroundColor: [
                '#f97316',
                '#22c55e',
                '#ef4444'
            ]
        }]
    }
});

new Chart(document.getElementById('spkChart'), {
    type: 'pie',
    data: {
        labels: ['Draft', 'Disetujui', 'Ditolak'],
        datasets: [{
            data: [
                {{ $spkDraft }},
                {{ $spkDisetujui }},
                {{ $spkDitolak }}
            ],
            backgroundColor: [
                '#f97316',
                '#22c55e',
                '#ef4444'
            ]
        }]
    }
});

new Chart(document.getElementById('summaryChart'), {
    type: 'bar',
    data: {
        labels: [
            'Mahasiswa',
            'Dosen',
            'RPK',
            'SPK'
        ],
        datasets: [{
            label: 'Jumlah Data',
            data: [
                {{ $totalMahasiswa }},
                {{ $totalDosen }},
                {{ $totalRpk }},
                {{ $totalSpk }}
            ],
            backgroundColor: [
                '#3b82f6',
                '#22c55e',
                '#f97316',
                '#8b5cf6'
            ]
        }]
    },
    options: {
        responsive: true
    }
});


new Chart(document.getElementById('tingkatChart'), {
    type: 'bar',
    data: {
        labels: [
            'Universitas',
            'Regional',
            'Nasional',
            'Internasional'
        ],
        datasets: [{
            label: 'Jumlah Prestasi',
            data: [
                {{ $universitas }},
                {{ $regional }},
                {{ $nasional }},
                {{ $internasional }}
            ],
            backgroundColor: [
                '#3b82f6',
                '#22c55e',
                '#f97316',
                '#8b5cf6'
            ]
        }]
    }
});

new Chart(document.getElementById('jenisChart'), {
    type: 'doughnut',
    data: {
        labels: @json($jenisLabels),
        datasets: [{
            data: @json($jenisData)
        }]
    }
});

</script>

</x-app-layout>