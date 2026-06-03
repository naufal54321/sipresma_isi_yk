<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            Mahasiswa Bimbingan
        </h1>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">
                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                NIM
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Prodi
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total RPK
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total SPK
                            </th>

                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">

                        @forelse($mahasiswa as $mhs)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $mhs->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $mhs->nim ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $mhs->prodi ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $mhs->total_rpk }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $mhs->total_spk }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                Belum ada mahasiswa bimbingan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</x-app-layout>