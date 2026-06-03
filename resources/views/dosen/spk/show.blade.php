<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

    <div class="bg-white shadow rounded-xl p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail SPK
        </h1>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <strong>Mahasiswa</strong>
                <p>{{ $spk->user->name }}</p>
            </div>

            <div>
                <strong>Tahun</strong>
                <p>{{ $spk->tahun }}</p>
            </div>

            <div>
                <strong>Kegiatan</strong>
                <p>{{ $spk->kegiatan->kegiatan }}</p>
            </div>

            <div>
                <strong>Jenis</strong>
                <p>{{ $spk->kegiatan->jenis }}</p>
            </div>

            <div>
                <strong>Penyelenggara</strong>
                <p>{{ $spk->penyelenggara }}</p>
            </div>

            <div>
                <strong>Tanggal</strong>
                <p>{{ $spk->tanggal_kegiatan }}</p>
            </div>

            <div class="col-span-2">
                <strong>Keterangan</strong>
                <p>{{ $spk->keterangan }}</p>
            </div>

        </div>

    </div>

</div>

</x-app-layout>