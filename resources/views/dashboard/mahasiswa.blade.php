<x-app-layout>

<div class="py-8">
<div class="max-w-8xl mx-auto py-6">

    <!-- Hero -->
    <div class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 rounded-3xl p-8 text-white shadow-lg mb-8">

        <h1 class="text-3xl font-bold">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>

        <p class="mt-2 text-blue-100">
            Sistem Informasi Prestasi Mahasiswa
        </p>

        <div class="mt-4 flex gap-6 text-sm">
            <span>NIM : {{ Auth::user()->nim }}</span>
            <span>{{ Auth::user()->prodi }}</span>
        </div>

    </div>

    <!-- Dosen Pembimbing -->
<div class="bg-white rounded-2xl shadow p-6 mb-8">

    <div class="flex items-center gap-4">

        <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-8 h-8 text-indigo-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

            </svg>

        </div>

        <div>

            <h2 class="text-lg font-bold text-gray-800">
                Dosen Pembimbing
            </h2>

            @if($dosenPembimbing)

                <p class="text-xl font-semibold text-indigo-600">
                    {{ $dosenPembimbing->name }}
                </p>

                <p class="text-gray-500">
                    Pembimbing Prestasi Mahasiswa
                </p>

            @else

                <p class="text-red-500">
                    Belum memiliki dosen pembimbing
                </p>

            @endif

        </div>

    </div>

</div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">RPK Draft</p>
            <h2 class="text-4xl font-bold text-orange-500">{{ $rpkDraft }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">RPK Disetujui</p>
            <h2 class="text-4xl font-bold text-green-600">{{ $rpkDisetujui }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">SPK Draft</p>
            <h2 class="text-4xl font-bold text-orange-500">{{ $spkDraft }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">SPK Disetujui</p>
            <h2 class="text-4xl font-bold text-green-600">{{ $spkDisetujui }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">Total Poin</p>
            <h2 class="text-4xl font-bold text-blue-600">{{ $totalPoin }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">Total Kegiatan</p>
            <h2 class="text-4xl font-bold text-purple-600">{{ $totalKegiatan }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">Ditolak</p>
            <h2 class="text-4xl font-bold text-red-600">{{ $ditolak }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500">Persentase Disetujui</p>
            <h2 class="text-4xl font-bold text-emerald-600">{{ $persentase }}%</h2>
        </div>

    </div>

    <!-- Progress -->
    <div class="bg-white rounded-2xl p-6 shadow mb-8">

        <div class="flex justify-between mb-3">
            <h2 class="font-bold">Progress Prestasi</h2>
            <span>{{ $totalPoin }}/100</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-5">

            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-5 rounded-full"
                style="width: {{ min(($totalPoin/100)*100,100) }}%">
            </div>

        </div>

    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold mb-4">Status Kegiatan</h2>
            <canvas id="pieChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold mb-4">Prestasi Berdasarkan Tingkat</h2>
            <canvas id="barChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold mb-4">Distribusi Jenis Kegiatan</h2>
            <canvas id="donutChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-bold mb-4">Aktivitas Per Bulan</h2>
            <canvas id="lineChart"></canvas>
        </div>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('pieChart'), {
type:'pie',
data:{
labels:['Draft','Disetujui','Ditolak'],
datasets:[{
data:@json([$draft,$disetujui,$ditolak]),
backgroundColor:['#f97316','#22c55e','#ef4444']
}]
}
});

new Chart(document.getElementById('barChart'), {
type:'bar',
data:{
labels:['Universitas','Regional','Nasional','Internasional'],
datasets:[{
label:'Jumlah Prestasi',
data: {{ Js::from([
    $universitas,
    $regional,
    $nasional,
    $internasional
]) }},
backgroundColor:'#3b82f6'
}]
}
});

new Chart(document.getElementById('donutChart'), {
type:'doughnut',
data:{
labels:@json($jenisLabels),
datasets:[{
data:@json($jenisData)
}]
}
});

new Chart(document.getElementById('lineChart'), {
type:'line',
data:{
labels:@json($bulanLabels),
datasets:[{
label:'Aktivitas',
data:@json($bulanData),
borderColor:'#2563eb',
fill:false
}]
}
});

</script>

</x-app-layout>