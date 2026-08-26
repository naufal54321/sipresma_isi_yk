<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @hasSection('title')
        <title>@yield('title') — {{ config('app.name', 'PRATAMA') }}</title>
        @else
        <title>{{ config('app.name', 'PRATAMA') }}</title>
        @endif

        <meta name="description" content="@yield('metaDescription', 'PRATAMA — Prestasi dan Talenta Mahasiswa ISI Yogyakarta')">
        <meta name="robots" content="noindex, nofollow">

        <meta property="og:title" content="@yield('title', config('app.name'))">
        <meta property="og:description" content="@yield('metaDescription', 'PRATAMA — Prestasi dan Talenta Mahasiswa ISI Yogyakarta')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        <link rel="canonical" href="{{ url()->current() }}">

        <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@600;700;900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ⚡ SEMBUNYIKAN ELEMEN DENGAN x-cloak */
            [x-cloak] { 
                display: none !important; 
            }

            /* ⚡ MATIKAN SEMUA ANIMASI & TRANSISI SAAT PRELOAD */
            body.preload *,
            body.preload *::before,
            body.preload *::after {
                animation-duration: 0s !important;
                animation-delay: 0s !important;
                transition-duration: 0s !important;
                transition-delay: 0s !important;
            }
        </style>
    </head>

      <body id="main-body" 
          class="preload font-sans antialiased bg-slate-50 text-slate-800 selection:bg-blue-200 selection:text-blue-900"
          x-data="{ sidebarKecil: localStorage.getItem('sidebarState') === 'true', siapAnimasi: false, mobileOpen: false }" 
          x-init="
              $nextTick(() => { 
                  document.body.classList.remove('preload'); 
                  siapAnimasi = true; 
                  $dispatch('sidebar-ready');
              });
               window.addEventListener('sidebar-toggle', (e) => {
                   sidebarKecil = e.detail;
               });
               window.addEventListener('sidebar-mobile-close', () => { mobileOpen = false; });
          "
          @sidebar-toggle.window="sidebarKecil = $event.detail">

        <div class="min-h-screen flex">

            @include('layouts.navigation')

            <div class="flex flex-col flex-1 min-w-0 transition-[margin] duration-300 ease-in-out relative"
                 :class="{
                     'lg:ml-20': sidebarKecil,
                     'lg:ml-64': !sidebarKecil,
                     'transition-none': !siapAnimasi
                 }">

                {{-- Loading bar di dalam konten --}}
                <div id="page-loader"><div class="bar"></div></div>

                {{-- Header --}}
                <div class="w-full bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 px-4 sm:px-8 py-3 flex items-center justify-between sticky top-0 z-40">
                    <div class="flex items-center gap-3">
                        <button @click="mobileOpen = !mobileOpen; $dispatch('sidebar-mobile-toggle')" 
                                class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                            <span x-show="!mobileOpen"><i class="fas fa-bars text-xl"></i></span>
                            <span x-show="mobileOpen" style="display:none"><i class="fas fa-times text-xl"></i></span>
                        </button>
                    </div>

                    <div class="relative ml-auto" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center gap-3 hover:bg-slate-50 p-2 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <div class="text-right hidden sm:block">
                                <h2 class="font-bold text-sm text-slate-800 leading-tight">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-[11px] text-slate-500 font-semibold tracking-wide uppercase mt-0.5">
                                    @foreach(auth()->user()->roles as $role)
                                        {{ $role->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eff6ff&color=2563eb&bold=true" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full ring-2 ring-slate-100 object-cover shadow-sm" loading="lazy">
                                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-300 ml-1" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-50 origin-top-right" style="display: none;">

                            <div class="px-4 py-3 border-b border-slate-50 sm:hidden">
                                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-user-circle w-4 text-center text-slate-400"></i> Kelola Profil
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Konten Utama --}}
                <div class="flex flex-col flex-1 relative">
                    
                    <div id="content-wrapper" class="flex-1 w-full flex flex-col">
                        
                        @isset($header)
                            <header class="bg-white/50 backdrop-blur-sm border-b border-slate-200 shadow-sm w-full shrink-0">
                                <div class="px-4 py-4 sm:px-8 sm:py-6">{{ $header }}</div>
                            </header>
                        @endisset

                        <main class="px-4 py-6 sm:p-8 w-full flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                    
                    <footer class="w-full py-5 text-center text-sm text-slate-500 border-t border-slate-200 bg-white/50 backdrop-blur-sm shrink-0">
                        &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
                    </footer>

                </div>
            </div>
        </div>

        <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

        {{-- Navigasi Script --}}
        <script>
document.addEventListener('DOMContentLoaded', () => {

    const loader = document.getElementById('page-loader');
    const bar = document.querySelector('#page-loader .bar');
    const wrapper = document.getElementById('content-wrapper');
    const sidebar = document.getElementById('sidebar-nav');
    const appShell = document.querySelector('.min-h-screen.flex');

    // ⚡ LOADING BAR SELESAI
    window.addEventListener('load', function() {
        if (bar && loader) {
            bar.style.width = '100%';
            bar.classList.remove('animating');
            setTimeout(() => {
                loader.classList.remove('active');
                bar.style.width = '0';
            }, 300);
        }
    });

    // ⚡ MULAI LOADING
    function startLoading() {
        if (loader && bar) {
            bar.classList.remove('animating');
            bar.style.width = '0';
            void bar.offsetHeight;
            bar.classList.add('animating');
            loader.classList.add('active');
        }
    }

    // ⚡ HENTIKAN LOADING
    function stopLoading() {
        if (bar && loader) {
            bar.style.width = '100%';
            bar.classList.remove('animating');
            setTimeout(() => {
                loader.classList.remove('active');
                bar.style.width = '0';
            }, 300);
        }
    }

    // ⚡ INIT ULANG KONTEN + SIDEBAR + JALANKAN SCRIPT
    function initNewContent(html, url) {
        const temp = document.createElement('div');
        temp.innerHTML = html;

        // ⚡ HALAMAN BER-WRAPPER data-no-spa TIDAK BOLEH DIPROSES SPA → FULL RELOAD
        if (temp.querySelector('[data-no-spa]')) {
            window.location.href = url || window.location.href;
            return false;
        }

        const titleTag = temp.querySelector('title');
        if (titleTag) document.title = titleTag.textContent;

        // Swap sidebar
        const newSidebar = temp.querySelector('#sidebar-nav');
        if (newSidebar && sidebar) {
            sidebar.innerHTML = newSidebar.innerHTML;
            if (window.Alpine) Alpine.initTree(sidebar);
        }

        // Fade out, swap, fade in — hilangkan white flash
        const newWrapper = temp.querySelector('#content-wrapper');
        if (!newWrapper) return false;
        wrapper.style.transition = 'opacity 0.12s';
        wrapper.style.opacity = '0';
        wrapper.innerHTML = newWrapper.innerHTML;
        if (window.Alpine) Alpine.initTree(wrapper);

        // Reset mobile sidebar setelah navigasi
        if (window.Alpine) { const b = Alpine.$data(document.body); if (b) b.mobileOpen = false; }

        // Tunggu render DOM + Alpine selesai, baru eksekusi script
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                // Jalankan ulang script inline di konten
                wrapper.querySelectorAll('script:not([src])').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    Array.from(oldScript.attributes).forEach(attr => {
                        newScript.setAttribute(attr.name, attr.value);
                    });
                    newScript.textContent = oldScript.textContent;
                    oldScript.replaceWith(newScript);
                });

                // Beri waktu script inline jalan, baru trigger event + fix datepicker
                setTimeout(() => {
                    document.dispatchEvent(new CustomEvent('content-updated'));
                    initCharts();
                    initDatepickers();
                    wrapper.style.opacity = '1';
                }, 100);
            });
        });

        return true;
    }

    // ⚡ FETCH + SWAP KONTEN
    function navigateTo(url) {
        window.dispatchEvent(new Event('sidebar-mobile-close'));
        startLoading();

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            if (!initNewContent(html, url)) {
                window.location.href = url;
                return;
            }
            history.pushState({ url }, '', url);
            stopLoading();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(() => {
            window.location.href = url;
        });
    }

    // ⚡ TANGKAP KLIK LINK DI SIDEBAR + KONTEN
    appShell.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        if (
            link.target === '_blank' ||
            e.ctrlKey || e.metaKey || e.button === 1 ||
            link.hasAttribute('download') ||
            link.href === '#' ||
            link.href === '' ||
            !link.href ||
            link.getAttribute('onclick') ||
            (link.href && link.href.startsWith('javascript:')) ||
            !link.href.startsWith(window.location.origin) ||
            link.href.includes('#') ||
            link.href.includes('/logout')
        ) {
            return;
        }

        e.preventDefault();
        if (link.href !== window.location.href) {
            navigateTo(link.href);
        }
    });

    // ⚡ BACK/FORWARD BROWSER
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.url) {
            startLoading();
            fetch(e.state.url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                if (!initNewContent(html, e.state.url)) {
                    location.reload();
                    return;
                }
                stopLoading();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(() => location.reload());
        }
    });

});

// ⚡ PERSISTENT PLOTTING MODAL — survive SPA navigation
(function() {
    const urlPlotting = '{{ url("admin/rpk") }}';
    const csrf = '{{ csrf_token() }}';

    window.bukaModalPlotting = function(button) {
        if (typeof Swal === 'undefined') {
            setTimeout(() => window.bukaModalPlotting(button), 100);
            return;
        }
        const rpkId = button.getAttribute('data-rpk-id');
        const namaMahasiswa = button.getAttribute('data-nama');
        const currentDosenId = button.getAttribute('data-dosen-id');
        const inputCls = 'w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200';
        const dosens = window.dosenList || [];

        let html = `
            <div class="text-left">
                <p class="text-sm text-gray-500 mb-1">RPK milik:</p>
                <p class="font-bold text-gray-800 mb-4">${namaMahasiswa}</p>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Dosen Pembimbing</label>
                <select id="swal-dosen" class="${inputCls}">
                    <option value="">— Tanpa Dosen —</option>
                    ${dosens.map(o =>
                        `<option value="${o.id}" ${o.id == currentDosenId ? 'selected' : ''}>${o.name}</option>`
                    ).join('')}
                </select>
            </div>
        `;

        Swal.fire({
            title: 'Atur Dosen Pembimbing',
            html: html,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563eb',
            customClass: { confirmButton: 'swal2-confirm rounded-xl', cancelButton: 'swal2-cancel rounded-xl' },
            preConfirm: () => {
                const dosenId = Swal.getPopup().querySelector('#swal-dosen').value;
                return { dosen_id: dosenId || null };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengatur dosen pembimbing & mengirim notifikasi email...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch(`${urlPlotting}/${rpkId}/set-pembimbing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ dosen_id: result.value.dosen_id })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        let msg = data.message;
                        if (result.value.dosen_id && data.email_sent) {
                            msg += ' Email notifikasi telah dikirim ke ' + data.dosen_name + '.';
                        } else if (result.value.dosen_id && !data.email_sent) {
                            msg += ' Gagal mengirim email notifikasi.';
                        }
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: msg, timer: 2500, showConfirmButton: false });
                        const row = document.querySelector(`[data-rpk-id="${rpkId}"]`)?.closest('tr');
                        if (row) {
                            const dosenCell = row.querySelector('td:nth-child(6)');
                            if (data.dosen_name) {
                                dosenCell.innerHTML = `<span class="block font-semibold text-slate-700">${data.dosen_name}</span>`;
                            } else {
                                dosenCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold bg-red-50 text-red-600 border border-red-200"><i class="fas fa-exclamation-triangle text-[9px]"></i> Belum Ada</span>`;
                            }
                        } else {
                            location.reload();
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Terjadi kesalahan.' });
                    }
                })
                .catch(() => {
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Tidak dapat menghubungi server.' });
                });
            }
        });
    };
})();

// ⚡ FLATPICKR INIT
function initDatepickers() {
    if (typeof flatpickr === 'undefined') return;
    document.querySelectorAll('.datepicker').forEach(el => {
        if (el._flatpickr) el._flatpickr.destroy();
        flatpickr(el, {
            dateFormat: 'Y-m-d',
            allowInput: true,
            locale: { firstDayOfWeek: 1 },
        });
    });
}

document.addEventListener('DOMContentLoaded', initDatepickers);
document.addEventListener('content-updated', initDatepickers);

// ⚡ CHART INIT DARI DATA ATTRIBUTE
function initCharts() {
    if (typeof Chart === 'undefined') return;

    document.querySelectorAll('canvas[data-chart]').forEach(canvas => {
        const id = canvas.id;
        if (!id) return;
        try {
            const config = JSON.parse(canvas.dataset.chart);
            const existing = Chart.getChart(id);
            if (existing) existing.destroy();
            new Chart(canvas, config);
        } catch (e) {
            console.warn('Chart init error:', id, e);
        }
    });
}

document.addEventListener('DOMContentLoaded', initCharts);
document.addEventListener('content-updated', initCharts);

// ⚡ PDF PREVIEW (PDF.JS - SOLUSI BLOKIR PDF DI IFRAME, KHUSUSNYA ANDROID CHROME)
function renderPdfPreview(container, url, fallbackUrl) {
    if (typeof pdfjsLib === 'undefined') {
        showPdfFallback(container, fallbackUrl);
        return;
    }
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    container.innerHTML = '<div class="flex flex-col items-center justify-center text-gray-500 py-8"><div class="w-8 h-8 border-2 border-blue-500 border-t-transparent rounded-full animate-spin mb-2"></div><span class="text-sm">Memuat dokumen...</span></div>';

    pdfjsLib.getDocument(url).promise.then(pdf => {
        if (!container.isConnected) return;
        return pdf.getPage(1).then(page => {
            const baseWidth = Math.min(container.clientWidth || 800, 800);
            const viewport = page.getViewport({ scale: 1 });
            const scale = Math.min((baseWidth - 24) / viewport.width, 2.5);
            const scaled = page.getViewport({ scale });

            container.innerHTML = '';
            const canvas = document.createElement('canvas');
            canvas.className = 'max-w-full h-auto mx-auto rounded-lg border border-gray-300 bg-white';
            canvas.width = Math.floor(scaled.width);
            canvas.height = Math.floor(scaled.height);
            container.appendChild(canvas);

            return page.render({ canvasContext: canvas.getContext('2d'), viewport: scaled }).promise.then(() => {
                if (pdf.numPages > 1 && container.isConnected) {
                    const info = document.createElement('div');
                    info.className = 'text-xs text-gray-500 text-center mt-2';
                    info.textContent = 'Halaman 1 dari ' + pdf.numPages + ' — buka file untuk melihat lengkap';
                    container.appendChild(info);
                }
            });
        });
    }).catch(() => {
        if (container.isConnected) showPdfFallback(container, fallbackUrl);
    });
}

function showPdfFallback(container, fallbackUrl) {
    container.innerHTML = `<div class="flex flex-col items-center justify-center text-gray-500 py-8 gap-3">
        <i class="fas fa-file-pdf text-4xl text-gray-300"></i>
        <span class="text-sm font-medium">Preview tidak dapat dimuat</span>
        ${fallbackUrl ? `<a href="${fallbackUrl}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition"><i class="fas fa-external-link-alt"></i> Buka File</a>` : ''}
    </div>`;
}

function initPdfPreviews() {
    if (typeof pdfjsLib === 'undefined') return;
    document.querySelectorAll('[data-pdf-preview]').forEach(el => {
        if (el.dataset.pdfInitialized) return;
        el.dataset.pdfInitialized = '1';
        renderPdfPreview(el, el.getAttribute('data-pdf-preview'), el.getAttribute('data-pdf-fallback'));
    });
}

document.addEventListener('DOMContentLoaded', initPdfPreviews);
document.addEventListener('content-updated', initPdfPreviews);
</script>
    </body>
</html>