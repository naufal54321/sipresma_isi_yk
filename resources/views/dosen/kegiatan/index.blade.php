<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Approval Kegiatan Mahasiswa
            </h1>

            <p class="text-gray-500 mt-1">
                Persetujuan kegiatan mahasiswa
            </p>

        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Mahasiswa</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($kegiatans as $kegiatan)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                             {{ $kegiatan->rpk->user->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                             {{ $kegiatan->rpk->user->nim ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->kegiatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->jenis }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->tingkat }}
                        </td>

                        <td class="px-6 py-4">

                            @if($kegiatan->status == 'draft')

                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs">
                                    Draft
                                </span>

                            @elseif($kegiatan->status == 'disetujui')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-2">

                                <form action="{{ route('dosen.kegiatan.approve', $kegiatan->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-400 text-white px-4 py-2 rounded-lg text-sm">

                                        Setujui

                                    </button>

                                </form>

                                <form action="{{ route('dosen.kegiatan.reject', $kegiatan->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm">

                                        Tolak

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
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

</x-app-layout>
