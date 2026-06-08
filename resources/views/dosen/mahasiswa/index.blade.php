<x-app-layout>

<div class="py-6">

     <div class="max-w-8xl mx-auto py-6">

       
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Mahasiswa Bimbingan
            </h1>
        </div>

         <div class="flex justify-end mt-4 mb-4">

    <form method="GET"
          action="{{ route('dosen.mahasiswa.index') }}"
          class="relative">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari data..."
               class="w-72 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

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

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50 uppercase text-xs tracking-wider">
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

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">
                                Total RPK
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">
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

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                {{ $mhs->total_rpk }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
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