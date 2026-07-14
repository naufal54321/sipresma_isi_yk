<x-app-layout>

<div class="py-6">

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Tambah RPK
            </h1>

            <form id="formTambahRpk" action="{{ route('rpks.store') }}" method="POST">

                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                    <input type="text" name="tahun" id="inputTahun"
                           class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                           placeholder="Contoh: 2025">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                    <select name="semester" id="inputSemester"
                            class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">
                        <option value="">Pilih Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" id="btnSimpan"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold">
                        Simpan
                    </button>
                    <a href="{{ route('rpks.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formTambahRpk').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('btnSimpan');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            tahun: document.getElementById('inputTahun').value,
            semester: document.getElementById('inputSemester').value
        })
    })
    .then(res => res.json().then(data => ({ status: res.status, data })))
    .then(({ status, data }) => {
        btn.disabled = false;
        btn.textContent = 'Simpan';

        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
            setTimeout(() => window.location.href = '{{ route('rpks.index') }}', 2200);
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan' });
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Simpan';
        Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server' });
    });
});
</script>

</x-app-layout>