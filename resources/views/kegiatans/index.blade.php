<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Data Kegiatan
                </h1>

                <p class="text-gray-500">
                    {{ $rpk->tahun }} - {{ $rpk->semester }}
                </p>
            </div>

            <a href="{{ route('kegiatans.create', $rpk->id) }}"
               class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl">

                + Tambah Kegiatan

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($kegiatans as $kegiatan)

                    <tr class="border-b">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->kegiatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->peran }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                {{ $kegiatan->status }}
                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
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