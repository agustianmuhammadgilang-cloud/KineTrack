<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Kinetrack</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js (Dropdown) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
  :root {
    --polban-blue: #1D2F83;
    --polban-orange: #F58025;
  }

  .sidebar-icon {
    width: 20px;
    min-width: 20px;
    height: 20px;
  }

  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: transparent;
  }
  ::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.2);
    border-radius: 3px;
  }




@keyframes pulse {
  0%   { transform: scale(1); opacity: 1; }
  50%  { transform: scale(1.15); opacity: 0.7; }
  100% { transform: scale(1); opacity: 1; }
}

.bell-pulse {
  animation: pulse 1s infinite;
}




</style>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">

<!-- Sidebar -->
<div class="fixed top-0 left-0 h-full w-64 bg-[var(--polban-blue)] text-white flex flex-col shadow-lg">

    <div class="px-6 py-4 text-center border-b border-white/20">
        <img src="<?= base_url('img/Logo No Name.png') ?>" class="mx-auto w-16 mb-2">
    </div>

    <nav class="flex-1 overflow-y-auto mt-4 text-sm">

    

<!-- Dashboard -->
<a href="<?= base_url('admin') ?>"
    class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
    <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
        <use href="#dashboard-home" />
    </svg>
    Dashboard
</a>


        <!-- Manajemen Users -->
        <div 
            x-data="{
                open: JSON.parse(localStorage.getItem('dropdownUser')) ?? false,
                toggle() {
                    this.open = !this.open;
                    localStorage.setItem('dropdownUser', this.open);
                }
            }"
            x-init="$watch('open', v => localStorage.setItem('dropdownUser', v))"
        >

            <button @click="toggle()"
                class="w-full flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
                <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
                    <use href="#user" />
                </svg>
                <span class="flex-1">Manajemen Users</span>

                <svg :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform text-white" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M6 9l6 6 6-6"/>
                </svg>
            </button>

            <div x-show="open" x-transition
                class="ml-10 flex flex-col mt-1">

                <a href="<?= base_url('admin/users') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'users') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola User
                </a>

                <a href="<?= base_url('admin/jabatan') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'jabatan') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola Jabatan
                </a>

                <a href="<?= base_url('admin/bidang') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'bidang') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola Bidang
                </a>

            </div>
        </div>

        
        <!-- Input Pengukuran (Dropdown Group) -->
        <div 
        x-data="{
          open: JSON.parse(localStorage.getItem('dropdownPengukuran')) ?? false,
          toggle() {
            this.open = !this.open;
            localStorage.setItem('dropdownPengukuran', this.open);
          }
        }"
            x-init="$watch('open', v => localStorage.setItem('dropdownPengukuran', v))"
            >
            
            <button @click="toggle()"
            class="w-full flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
            <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
    <use href="#document-check" />
</svg>
<span class="flex-1">Perjanjian Kinerja</span>
            
            <svg :class="open ? 'rotate-90' : ''"
            class="w-4 h-4 transition-transform text-white" fill="none" stroke="currentColor">
            <path stroke-width="2" d="M6 9l6 6 6-6"/>
          </svg>
        </button>
        
        <div x-show="open" x-transition
        class="ml-10 flex flex-col mt-1">
        
        <a href="<?= base_url('admin/tahun') ?>"
       
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'tahun') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola Tahun Anggaran
                </a>

                <a href="<?= base_url('admin/sasaran') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'sasaran') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola Sasaran Strategis
                </a>

                <a href="<?= base_url('admin/indikator') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'indikator') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola Indikator Kinerja
                </a>

                <a href="<?= base_url('admin/pic') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'pic') ? 'bg-white/20 font-semibold' : '' ?>">
                    Kelola PIC (Person In Charge)
                </a>

                <a href="<?= base_url('admin/tw') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'tw') ? 'bg-white/20 font-semibold' : '' ?>">
                    Manajemen Triwulan
                </a>


                <a href="<?= base_url('admin/pengukuran') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'testing-pk') ? 'bg-white/20 font-semibold' : '' ?>">
                    Testing PK (Perjanjian Kinerja)
                </a>
            </div>
        </div>

         <!-- Analisis Bidang -->
        <a href="<?= base_url('admin/bidang-select') ?>"
            class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
<svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
    <use href="#document-chart" />
</svg>
LHE
        </a>
        
        <!-- Output Pengukuran -->
<a href="<?= base_url('admin/pengukuran/output') ?>"
    class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
    <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
        <use href="#chart-analytics" />
    </svg>
    Pengukuran Kinerja
</a>


<!-- Profil -->
<a href="<?= base_url('admin/profile') ?>"
    class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
    <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
        <use href="#user-cog" />
    </svg>
    Pengaturan Profil
</a>


    </nav>

    <!-- Logout -->
    <div class="px-6 py-4 border-t border-white/20">
        <button onclick="window.location.href='<?= base_url('logout') ?>'"
            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-[var(--polban-orange)] rounded hover:bg-orange-600 transition">
            <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
                <use href="#arrow-left-on-rectangle" />
            </svg>
            Logout
        </button>
    </div>
</div>

<!-- Main Content -->
<div class="ml-64 p-8">
    <?= $this->renderSection('content') ?>
</div>

<!-- Icons -->
<svg style="display:none;">
  <symbol id="chart-bar" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M3 3v18h18"/>
  </symbol>

  <symbol id="user" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M12 12a5 5 0 100-10 5 5 0 000 10zM3 21a9 9 0 1118 0H3z"/>
  </symbol>

  <symbol id="folder" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M3 7h4l2 3h10v11H3V7z"/>
  </symbol>

  <symbol id="chart-pie" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M11 2v20M2 11h20"/>
  </symbol>

  <symbol id="arrow-left-on-rectangle" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M16 17l-5-5 5-5M21 12H9"/>
  </symbol>

  <symbol id="cog-6-tooth" viewBox="0 0 24 24">
    <path stroke="currentColor" fill="none" stroke-width="2" d="M10 3l1 6 5 1-3 4 1 6-5-2-5 2 1-6-3-4 5-1 1-6z"/>
  </symbol>

<symbol id="document-check" viewBox="0 0 24 24">
    <path 
        stroke="currentColor" 
        fill="none" 
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M9 12l2 2 4-4M7 2h7l5 5v13a2 2 0 01-2 2H7a2 2 0 01-2-2V4a2 2 0 012-2z"
    />
</symbol>



<symbol id="document-chart" viewBox="0 0 24 24">
    <path 
        stroke="currentColor" 
        fill="none" 
        stroke-width="2" 
        stroke-linecap="round" 
        stroke-linejoin="round"
        d="M7 2h7l5 5v13a2 2 0 01-2 2H7a2 2 0 01-2-2V4a2 2 0 012-2z"
    />
    <path 
        stroke="currentColor" 
        stroke-width="2" 
        stroke-linecap="round"
        d="M9 14v3M12 12v5M15 10v7"
    />
</symbol>

<symbol id="chart-analytics" viewBox="0 0 24 24">
    <polyline 
        points="4 14 8 10 12 13 20 6"
        stroke="currentColor"
        stroke-width="2"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
    <circle cx="4" cy="14" r="1.5" fill="currentColor"/>
    <circle cx="8" cy="10" r="1.5" fill="currentColor"/>
    <circle cx="12" cy="13" r="1.5" fill="currentColor"/>
    <circle cx="20" cy="6" r="1.5" fill="currentColor"/>
</symbol>






<symbol id="user-cog" viewBox="0 0 24 24">
    <!-- Kepala -->
    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>

    <!-- Badan -->
    <path d="M6 21c0-4 3-7 6-7s6 3 6 7" 
          stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>

    <!-- Gear -->
    <circle cx="18" cy="14" r="2" stroke="currentColor" stroke-width="2" fill="none"/>

    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
        d="M18 10v1.2
           M18 16.8V18
           M15.6 11.2l.8.8
           M20.4 16l-.8-.8
           M14 14h1.2
           M20.8 14H22
           M15.6 16.8l.8-.8
           M20.4 11.2l-.8.8" />
</symbol>




<symbol id="dashboard-home" viewBox="0 0 24 24">
    <!-- Rumah -->
    <path d="M3 10l9-7 9 7" 
        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    
    <!-- Kotak Dashboard -->
    <rect x="6" y="12" width="12" height="9" 
        stroke="currentColor" stroke-width="2" fill="none" rx="2" ry="2"/>

    <!-- Pembagi dashboard -->
    <path d="M12 12v9M6 16h12" 
        stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</symbol>




</svg>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('alert')): $a = session()->getFlashdata('alert'); ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    icon: '<?= esc($a['type']) ?>',
    title: '<?= esc($a['title']) ?>',
    text: '<?= esc($a['message']) ?>'
});
</script>


<?php endif; ?>
<script>
document.addEventListener("DOMContentLoaded", () => {

    let lastNotifId = localStorage.getItem("lastNotifId") ?? 0;

    // =========================================================
    // 1. TOAST – Notifikasi Terbaru
    // =========================================================
    async function checkNewNotif() {
        try {
            const res = await fetch("<?= base_url('notifications/latest') ?>");
            const notif = await res.json();

            if (!notif || !notif.id) return;

            if (notif.id != lastNotifId) {
                lastNotifId = notif.id;
                localStorage.setItem("lastNotifId", notif.id);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 10000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    icon: 'info',
                    title: notif.message
                });
            }
        } catch (e) {}
    }

    // =========================================================
    // 2. BADGE MERAH
    // =========================================================
    async function refreshBadge() {
        const res = await fetch("<?= base_url('notifications/unread-count') ?>");
        const data = await res.json();

        const badge = document.getElementById('notifBadge');

        if (data.count > 0) {
            badge.innerText = data.count;
            badge.classList.remove("hidden");
        } else {
            badge.classList.add("hidden");
        }
    }

    // =========================================================
    // 3. LIST DROPDOWN
    // =========================================================
    async function loadDropdown() {
        const list = document.getElementById("notifList");
        const res = await fetch("<?= base_url('notifications/list/10') ?>");
        const data = await res.json();

        list.innerHTML = "";

        data.forEach(n => {
            const li = document.createElement("li");
            li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer";

            li.innerHTML = `
                <div class="font-semibold ${n.status === 'unread' ? 'text-blue-600' : ''}">
                    ${n.message}
                </div>
                <div class="text-xs text-gray-600">${n.created_at}</div>
            `;

            li.addEventListener("click", () => {
                markAsRead(n.id, n);
            });

            list.appendChild(li);
        });
    }

    // =========================================================
    // 4. MARK AS READ TANPA REDIRECT
    // =========================================================
    async function markAsRead(id, notifData) {

        await fetch("<?= base_url('notifications/mark') ?>/" + id, { method: "POST" });

        refreshBadge();
        loadDropdown();

        Swal.fire({
            title: "Detail Notifikasi",
            html: `
                <div class='text-left'>
                    <p><b>Pesan:</b> ${notifData.message}</p>
                    <p><b>Tanggal:</b> ${notifData.created_at}</p>
                </div>
            `,
            icon: "info"
        });
    }

    // =========================================================
    // 5. TANDAI SEMUA DIBACA
    // =========================================================
    window.markAllNotif = async function () {
        await fetch("<?= base_url('notifications/mark-all') ?>", { method: "POST" });
        refreshBadge();
        loadDropdown();
    };

    // =========================================================
    // AUTO REFRESH TIAP 6 DETIK
    // =========================================================
    setInterval(() => {
        checkNewNotif();
        refreshBadge();
        loadDropdown();
    }, 6000);

    // Load awal
    checkNewNotif();
    refreshBadge();
    loadDropdown();
});
</script>

</body>
</html>
