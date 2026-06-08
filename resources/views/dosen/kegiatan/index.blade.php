<x-app-layout>

<div class="py-6">

    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Validasi Kegiatan RPK Mahasiswa
            </h1>

            <p class="text-gray-500 mt-1">
                Persetujuan Kegiatan RPK Mahasiswa
            </p>

        </div>
        <div class="mb-4 flex justify-end">

    <form method="GET"
          action="{{ route('dosen.kegiatan.index') }}"
          class="relative">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari data..."
               class="w-72 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>

        </svg>

    </form>

</div>
    

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            
            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-3 py-4 text-center">No</th>
                        <th class="px-4 py-4">Mahasiswa</th>
                        <th class="px-4 py-4">NIM</th>
                        <th class="px-4 py-4">Prodi</th>
                        <th class="px-4 py-4">Tahun</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-3 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($kegiatans as $kegiatan)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-3 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4">
                             {{ $kegiatan->rpk->user->name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                             {{ $kegiatan->rpk->user->nim ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $kegiatan->rpk->user->prodi ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $kegiatan->rpk->tahun ?? '-' }}

                        <td class="px-6 py-4">
                            {{ $kegiatan->kegiatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->jenis }}
                        </td>


                        <td class="px-3 py-4">

                            @if($kegiatan->status == 'draft')

                                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">
                                    Draft
                                </span>

                            @elseif($kegiatan->status == 'disetujui')

                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        <td class="px-5 py-4">

    <div class="flex items-center gap-2">

    <a href="{{ route('dosen.kegiatan.show', $kegiatan->id) }}"
       class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">
        Detail
    </a>

    @if($kegiatan->status == 'draft')

        

</div>

    @else

        <span class="text-gray-400 font-medium">
        </span>

    @endif

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9"
                            class="text-center py-10 text-gray-400">

                            Belum ada kegiatan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

function approveKegiatan(id)
{
    Swal.fire({
        title: 'Alasan Persetujuan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan kegiatan disetujui...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/dosen/kegiatan/' + id + '/approve';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

function rejectKegiatan(id)
{
    Swal.fire({
        title: 'Alasan Penolakan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan kegiatan ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/dosen/kegiatan/' + id + '/reject';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

</script>

</x-app-layout>
