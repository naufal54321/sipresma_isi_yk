<section>

    <div class="rounded-2xl border border-red-200 bg-red-50 p-6">

        <div class="flex items-start gap-4">

            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-triangle-exclamation text-red-600 text-xl"></i>
            </div>

            <div class="flex-1">

                <h3 class="text-lg font-bold text-red-700">
                    Hapus Akun
                </h3>

                <p class="mt-2 text-sm text-red-600 leading-relaxed">
                    Menghapus akun akan menghilangkan seluruh data yang terkait
                    secara permanen dan tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    Pastikan Anda telah mencadangkan data penting sebelum melanjutkan.
                </p>

                <div class="mt-6">

                    <button
                        type="button"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal','confirm-user-deletion')"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition">

                        <i class="fas fa-trash-can"></i>

                        Hapus Akun

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable>

        <form method="POST"
              action="{{ route('profile.destroy') }}"
              class="p-8">

            @csrf
            @method('DELETE')

            <div class="flex items-center gap-4 mb-6">

                <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-trash text-red-600 text-2xl"></i>
                </div>

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Konfirmasi Hapus Akun
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                </div>

            </div>

            <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6">

                <p class="text-sm text-red-700 leading-relaxed">

                    Setelah akun dihapus:

                </p>

                <ul class="mt-3 text-sm text-red-600 list-disc list-inside space-y-1">

                    <li>Seluruh data akun akan dihapus.</li>
                    <li>Riwayat aktivitas tidak dapat dipulihkan.</li>
                    <li>Anda tidak dapat login kembali menggunakan akun ini.</li>

                </ul>

            </div>

            <div>

                <label
                    for="password"
                    class="block text-sm font-semibold text-slate-700 mb-2">

                    Masukkan Password

                </label>

                <div class="relative">

                    <i class="fas fa-lock absolute left-4 top-3.5 text-slate-400"></i>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan password Anda"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">

                </div>

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="mt-2"/>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-5 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition">

                    Batal

                </button>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition">

                    <i class="fas fa-trash"></i>

                    Ya, Hapus Akun

                </button>

            </div>

        </form>

    </x-modal>

</section>