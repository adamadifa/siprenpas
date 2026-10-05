<!-- Spotlight / Command Palette (Quick Access Search Menu like Mac Spotlight) -->
<div id="spotlightModal" 
     class="fixed inset-0 z-[99999] hidden items-start justify-center pt-16 sm:pt-24 px-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-200"
     tabindex="-1"
     aria-labelledby="spotlightModalLabel" 
     aria-hidden="true">
    
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all duration-200 scale-95 opacity-0" id="spotlightContent">
        
        <!-- Search Input Bar -->
        <div class="relative flex items-center px-4 py-3.5 border-b border-slate-100 bg-white">
            <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 mr-3 shrink-0">
                <i class="ti ti-search text-lg"></i>
            </div>
            <input type="text" 
                   id="spotlightInput" 
                   placeholder="Cari menu, halaman, fitur, atau tekan Esc untuk keluar..." 
                   autocomplete="off"
                   spellcheck="false"
                   class="w-full bg-transparent text-sm sm:text-base font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 border-none p-0">
            
            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                <kbd class="px-2 py-1 text-[10px] font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-lg shadow-2xs">ESC</kbd>
            </div>
        </div>

        <!-- Quick Status & Filter Summary -->
        <div class="px-4 py-2 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-medium">
            <span id="spotlightCountText">Menampilkan menu cepat</span>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-white border border-slate-200 rounded text-[9px] font-bold text-slate-500">↑</kbd> <kbd class="px-1 py-0.5 bg-white border border-slate-200 rounded text-[9px] font-bold text-slate-500">↓</kbd> navigasi</span>
                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-white border border-slate-200 rounded text-[9px] font-bold text-slate-500">↵</kbd> pilih</span>
            </div>
        </div>

        <!-- Menu Results List -->
        <div id="spotlightResults" class="max-h-[380px] overflow-y-auto p-2 space-y-1 divide-y-0 scrollbar-thin scrollbar-thumb-slate-200">
            <!-- Items will be populated dynamically from active sidebar menu & quick index -->
        </div>

        <!-- Empty State -->
        <div id="spotlightEmpty" class="hidden py-12 text-center px-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <i class="ti ti-search-off text-2xl"></i>
            </div>
            <h6 class="text-xs font-bold text-slate-700 m-0">Tidak ada menu yang ditemukan</h6>
            <p class="text-[11px] text-slate-400 mt-1">Coba kata kunci lain seperti <i>siswa, presensi, keuangan, guru, dsb.</i></p>
        </div>

        <!-- Footer Shortcuts Info -->
        <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-bold text-slate-600">Spotlight Menu SIPREN</span>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <span>Shortcut: <kbd class="px-1.5 py-0.5 text-[9px] font-bold bg-white border border-slate-200 rounded text-slate-600">⌘ + K</kbd> atau <kbd class="px-1.5 py-0.5 text-[9px] font-bold bg-white border border-slate-200 rounded text-slate-600">CTRL + K</kbd></span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    let spotlightData = [];
    let selectedIndex = 0;
    const spotlightModal = document.getElementById('spotlightModal');
    const spotlightContent = document.getElementById('spotlightContent');
    const spotlightInput = document.getElementById('spotlightInput');
    const spotlightResults = document.getElementById('spotlightResults');
    const spotlightEmpty = document.getElementById('spotlightEmpty');
    const spotlightCountText = document.getElementById('spotlightCountText');

    // 1. Scan Sidebar & Build Menu Registry
    function buildMenuRegistry() {
        spotlightData = [];
        const sidebar = document.getElementById('main-sidebar');
        if (!sidebar) return;

        // Scan all sections
        const sections = sidebar.querySelectorAll('#sidebar-menu-scroll > div');
        sections.forEach(sec => {
            const headingEl = sec.querySelector('div[class*="uppercase"]');
            const categoryName = headingEl ? headingEl.textContent.trim() : 'Menu Utama';
            
            const links = sec.querySelectorAll('a[href]');
            links.forEach(a => {
                const url = a.getAttribute('href');
                if (!url || url === '#' || url.startsWith('javascript:')) return;

                const labelEl = a.querySelector('span');
                const title = labelEl ? labelEl.textContent.trim() : a.textContent.trim();
                const iconEl = a.querySelector('i[class*="ti-"]');
                let iconClass = 'ti ti-chevron-right';
                if (iconEl) {
                    const match = iconEl.className.match(/ti\s+ti-[a-z0-9-]+/);
                    if (match) iconClass = match[0];
                }

                // Check duplicates
                if (!spotlightData.some(item => item.url === url && item.title === title)) {
                    spotlightData.push({
                        title: title,
                        category: categoryName,
                        url: url,
                        icon: iconClass
                    });
                }
            });
        });
    }

    // 2. Open Spotlight
    window.openSpotlight = function() {
        if (!spotlightModal) return;
        if (spotlightData.length === 0) {
            buildMenuRegistry();
        }
        spotlightModal.classList.remove('hidden');
        spotlightModal.classList.add('flex');
        
        setTimeout(() => {
            spotlightContent.classList.remove('scale-95', 'opacity-0');
            spotlightContent.classList.add('scale-100', 'opacity-100');
            spotlightInput.focus();
            spotlightInput.select();
        }, 10);

        renderResults(spotlightInput.value);
    };

    // 3. Close Spotlight
    window.closeSpotlight = function() {
        if (!spotlightModal) return;
        spotlightContent.classList.remove('scale-100', 'opacity-100');
        spotlightContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            spotlightModal.classList.add('hidden');
            spotlightModal.classList.remove('flex');
        }, 150);
    };

    // 4. Render Search Results
    function renderResults(query = '') {
        const cleanQuery = query.toLowerCase().trim();
        let filtered = spotlightData;

        if (cleanQuery !== '') {
            filtered = spotlightData.filter(item => {
                return item.title.toLowerCase().includes(cleanQuery) || 
                       item.category.toLowerCase().includes(cleanQuery);
            });
        }

        selectedIndex = 0;
        spotlightResults.innerHTML = '';

        if (filtered.length === 0) {
            spotlightResults.classList.add('hidden');
            spotlightEmpty.classList.remove('hidden');
            spotlightCountText.textContent = '0 menu ditemukan';
            return;
        }

        spotlightResults.classList.remove('hidden');
        spotlightEmpty.classList.add('hidden');
        spotlightCountText.textContent = `${filtered.length} menu ditemukan`;

        filtered.forEach((item, idx) => {
            const a = document.createElement('a');
            a.href = item.url;
            a.className = `spotlight-item group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition cursor-pointer ${idx === 0 ? 'bg-emerald-50 text-emerald-900 ring-1 ring-emerald-500/30' : 'text-slate-700 hover:bg-slate-50'}`;
            a.dataset.index = idx;

            // Highlight match in title if query exists
            let displayTitle = item.title;
            if (cleanQuery) {
                const regex = new RegExp(`(${cleanQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                displayTitle = displayTitle.replace(regex, '<span class="bg-amber-100 text-amber-900 rounded px-0.5 font-bold">$1</span>');
            }

            a.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center shrink-0 transition">
                        <i class="${item.icon} text-base"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-slate-800 group-hover:text-emerald-900 truncate text-[13px]">${displayTitle}</div>
                        <div class="text-[10px] text-slate-400 font-medium truncate">${item.category}</div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0 ml-2">
                    <span class="text-[10px] font-bold text-slate-400 group-hover:text-emerald-600 flex items-center gap-1">
                        Buka <i class="ti ti-arrow-right text-xs"></i>
                    </span>
                </div>
            `;

            a.addEventListener('mouseenter', () => {
                setSelectedIndex(idx);
            });

            spotlightResults.appendChild(a);
        });
    }

    function setSelectedIndex(newIdx) {
        const items = spotlightResults.querySelectorAll('.spotlight-item');
        if (!items.length) return;

        items.forEach((el, i) => {
            if (i === newIdx) {
                el.classList.add('bg-emerald-50', 'text-emerald-900', 'ring-1', 'ring-emerald-500/30');
                el.classList.remove('text-slate-700', 'hover:bg-slate-50');
                el.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            } else {
                el.classList.remove('bg-emerald-50', 'text-emerald-900', 'ring-1', 'ring-emerald-500/30');
                el.classList.add('text-slate-700');
            }
        });
        selectedIndex = newIdx;
    }

    // 5. Input Event Listener
    if (spotlightInput) {
        spotlightInput.addEventListener('input', (e) => {
            renderResults(e.target.value);
        });
    }

    // 6. Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        // Open Spotlight with Cmd+K, Ctrl+K, Cmd+/, or Ctrl+/
        if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K' || e.key === '/')) {
            e.preventDefault();
            if (spotlightModal && !spotlightModal.classList.contains('hidden')) {
                closeSpotlight();
            } else {
                openSpotlight();
            }
            return;
        }

        if (!spotlightModal || spotlightModal.classList.contains('hidden')) return;

        const items = spotlightResults.querySelectorAll('.spotlight-item');

        if (e.key === 'Escape') {
            e.preventDefault();
            closeSpotlight();
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (items.length > 0) {
                const next = (selectedIndex + 1) % items.length;
                setSelectedIndex(next);
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (items.length > 0) {
                const prev = (selectedIndex - 1 + items.length) % items.length;
                setSelectedIndex(prev);
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (items.length > 0 && items[selectedIndex]) {
                items[selectedIndex].click();
            }
        }
    });

    // Close on outside click
    if (spotlightModal) {
        spotlightModal.addEventListener('click', (e) => {
            if (e.target === spotlightModal) {
                closeSpotlight();
            }
        });
    }

    // Initialize Menu registry on page load
    document.addEventListener('DOMContentLoaded', () => {
        buildMenuRegistry();
    });
})();
</script>
