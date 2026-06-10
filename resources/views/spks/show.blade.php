<x-app-layout>

<div class="max-w-7xl mx-auto py-6">

    <!-- Tombol Kembali -->
    <div class="mb-6">

        <a href="{{ route('spks.index') }}"
           class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition">

            ← Kembali

        </a>

    </div>

    <div class="bg-white shadow rounded-xl p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail SPK
        </h1>

        <h2 class="text-xl font-semibold mb-4">
            Data Pengajuan SPK
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <strong>Mahasiswa</strong>
                <p>{{ $spk->user->name }}</p>
            </div>

            <div>
                <strong>NIM</strong>
                <p>{{ $spk->user->nim }}</p>
            </div>

            <div>
                <strong>Program Studi</strong>
                <p>{{ $spk->user->prodi }}</p>
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
                <strong>Tanggal Kegiatan</strong>
                <p>{{ $spk->tanggal_kegiatan }}</p>
            </div>

            <div>
                <strong>Poin Prestasi</strong>
                <p>
                    {{ $spk->kegiatan->masterKegiatan->poin ?? '-' }}
                </p>
            </div>

            <div>
                <strong>Status</strong>
                <br>

                @if($spk->status == 'draft')

                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                        Draft
                    </span>

                @elseif($spk->status == 'disetujui')

                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                        Disetujui
                    </span>

                @else

                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                        Ditolak
                    </span>

                @endif

            </div>

            <div class="md:col-span-2">
                <strong>Keterangan</strong>
                <p>{{ $spk->keterangan }}</p>
            </div>

            <div class="md:col-span-2">
                <strong>Catatan Dosen</strong>

                <p>
                    {{ $spk->catatan_dosen ?? 'Belum ada catatan dari dosen.' }}
                </p>
            </div>

            <!-- Preview File -->
            <div class="md:col-span-2 mt-4">

                <strong>Preview Bukti</strong>

                <iframe
                    src="{{ asset('storage/' . $spk->bukti) }}"
                    width="100%"
                    height="700"
                    class="border rounded-lg mt-2">

                </iframe>

            </div>

        </div>

    </div>

</div>

</x-app-layout>