<?php
use App\Models\PicModel;

$badgePengukuran = false;

if (session()->has('user_id')) {
    $picModel = new PicModel();

    $badgePengukuran = $picModel
        ->where('user_id', session()->get('user_id'))
        ->where('is_viewed_by_staff', 0)
        ->countAllResults() > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atasan - Kinetrack</title>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Heroicons -->
<script src="https://unpkg.com/heroicons@2.1.1/dist/umd/outline.js"></script>

<style>
  :root {
    --polban-blue: #1D2F83;
    --polban-orange: #F58025;
  }

  /* Scrollbar style for sidebar */
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

  /* ========== SIDEBAR UX ========= */
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 24px;
    color: white;
    font-size: 0.875rem;
    border-radius: 10px;
    position: relative;
    transition: all .2s ease;
}

.sidebar-link:hover {
    background: rgba(255,255,255,0.12);
}

.sidebar-link.active {
    background: rgba(255,255,255,0.18);
    font-weight: 600;
}

.sidebar-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 10px;
    bottom: 10px;
    width: 4px;
    background: var(--polban-orange);
    border-radius: 0 6px 6px 0;
}

.sidebar-icon {
    width: 20px;
    height: 20px;
    stroke: white;
    stroke-width: 2;
    opacity: .7;
    transition: all .2s ease;
}

.sidebar-link:hover .sidebar-icon,
.sidebar-link.active .sidebar-icon {
    opacity: 1;
    transform: translateX(2px);
}

/* Submenu */
.submenu {
    margin-left: 36px;
    margin-top: 6px;
}

.submenu-link {
    display: block;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 0.82rem;
    opacity: .8;
    transition: all .2s ease;
}

.submenu-link:hover {
    background: rgba(255,255,255,0.1);
    opacity: 1;
}

.submenu-link.active {
    background: rgba(255,255,255,0.15);
    font-weight: 500;
    opacity: 1;
}

/* FORCE WHITE ICON */
.sidebar-icon {
    stroke: #ffffff !important;
    fill: none !important;
}

.sidebar-link:hover .sidebar-icon,
.sidebar-link.active .sidebar-icon {
    stroke: #ffffff !important;
    opacity: 1;
}
</style>

<script>
function fileUpload() {
    return {
        drag: false,
        files: [],
        updateInput() {
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f));
            this.$refs.input.files = dt.files;
        },
        handleFileSelect(event) {
            for (let f of event.target.files) {
                this.files.push(f);
            }
            this.updateInput();
        },
        handleDrop(e) {
            this.drag = false;
            const dropped = e.dataTransfer.files;
            for (let f of dropped) {
                this.files.push(f);
            }
            this.updateInput();
        },
        removeFile(index) {
            this.files.splice(index, 1);
            this.updateInput();
        }
    }
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<div class="fixed top-0 left-0 h-full w-64 bg-[var(--polban-blue)] text-white flex flex-col transition-all duration-300 shadow-lg">
    <div class="px-6 py-4 text-center border-b border-white/20">
        <img src="<?= base_url('img/Logo No Name.png') ?>" alt="Polban Logo" class="mx-auto w-16 mb-2">
    </div>

    <nav class="flex-1 overflow-y-auto mt-4 px-3 space-y-1">

        <!-- DASHBOARD -->
        <a href="<?= base_url('atasan') ?>"
           class="sidebar-link <?= service('uri')->getSegment(1)=='atasan' && service('uri')->getSegment(2)==null ? 'active':'' ?>">
            <svg class="sidebar-icon"><use href="#chart-bar"/></svg>
            <span>Dashboard</span>
        </a>
        <!-- LOG AKTIVITAS -->
<a href="<?= base_url('atasan/activity-log') ?>"
   class="sidebar-link <?= service('uri')->getSegment(2)=='activity-log' ? 'active':'' ?>">
    <svg class="sidebar-icon">
        <use href="#clock"/>
    </svg>
    <span>Log Aktivitas</span>
</a>



<!-- ISI PENGUKURAN KINERJA -->
<a href="<?= base_url('atasan/task') ?>"
   class="sidebar-link <?= service('uri')->getSegment(2)=='task' ? 'active':'' ?> relative">

    <svg class="sidebar-icon">
        <use href="#chart-pie"/>
    </svg>

    <span class="flex items-center gap-2">
        Isi Pengukuran Kinerja

        <!-- BADGE MERAH -->
        <span id="badge-pengukuran"
              class="relative flex h-2.5 w-2.5 hidden">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
        </span>
    </span>
</a>


        <!-- DOKUMEN GROUP -->
        <?php
            $docActive = in_array(service('uri')->getSegment(2), ['dokumen','kategori']);
        ?>
        <div x-data="{ open: <?= $docActive ? 'true':'false' ?> }" class="mt-2">
            <button @click="open = !open"
                class="sidebar-link w-full justify-between <?= $docActive ? 'active':'' ?>">
                <div class="flex items-center gap-3">
                    <svg class="sidebar-icon"><use href="#folder"/></svg>
                    <span>Dokumen</span>
                </div>
                <svg
                    class="w-4 h-4 text-white/80 transition-transform"
                    stroke="currentColor"
                    fill="none"
                    :class="open && 'rotate-90'">
                    <use href="#arrow-left-on-rectangle"/>
                </svg>
            </button>

            <!-- SUBMENU -->
            <?php
            $uri = service('uri');
            $seg2 = $uri->getSegment(2, '');
            $seg3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : '';
            ?>
            <div x-show="open" x-transition class="submenu space-y-1">
                <a href="<?= base_url('atasan/dokumen') ?>"
   class="submenu-link relative <?= $seg2=='dokumen' && $seg3=='' ? 'active':'' ?>">

    <span class="flex items-center gap-2">
        Dokumen Kinerja

        <!-- BADGE MERAH -->
        <span id="badge-dokumen-atasan"
              class="relative flex h-2.5 w-2.5 hidden">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
        </span>
    </span>
</a>

                <!--  -->
                <!-- Dokumen Unit (PUBLIC UNIT) -->
<a href="<?= base_url('atasan/dokumen/unit') ?>" 
   class="submenu-link <?= $seg3=='unit' ? 'active':'' ?>">
    Dokumen Unit
    <span id="badge-unit"
          class="ml-2 px-2 py-0.5 
                 bg-red-100 text-red-700 
                 text-xs font-medium 
                 rounded hidden">
        Baru
    </span>
</a>


<a href="<?= base_url('atasan/dokumen/public') ?>" 
   class="submenu-link <?= $seg3=='public' ? 'active':'' ?>">
    Dokumen Publik
    <span id="badge-public"
          class="ml-2 px-2 py-0.5 
                 bg-red-100 text-red-700 
                 text-xs font-medium 
                 rounded hidden">
        Baru
    </span>
</a>

                <a href="<?= base_url('atasan/dokumen/arsip') ?>"
                   class="submenu-link <?= $seg3=='arsip' ? 'active':'' ?>">
                    Arsip
                </a>
            </div>
        </div>

    
        <!-- GRAFIK KINERJA -->
<a href="<?= base_url('atasan/grafik') ?>"
   class="sidebar-link <?= service('uri')->getSegment(2)=='grafik' ? 'active':'' ?>">
    <svg class="sidebar-icon"><use href="#chart-bar"/></svg>
    <span>Grafik Kinerja</span>
</a>


        <!-- PROFIL -->
        <a href="<?= base_url('atasan/profile') ?>"
           class="sidebar-link <?= service('uri')->getSegment(2)=='profile' ? 'active':'' ?>">
            <svg class="sidebar-icon"><use href="#user"/></svg>
            <span>Pengaturan Profil</span>
        </a>
    </nav>

    <div class="px-6 py-4 border-t border-white/20">
        <button onclick="window.location.href='<?= base_url('logout') ?>'" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium bg-[var(--polban-orange)] rounded hover:bg-orange-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#arrow-left-on-rectangle" /></svg>
            Logout
        </button>
    </div>
</div>

<!-- Main Content -->
<div class="ml-64 p-8">
    <?= $this->renderSection('content') ?>
</div>

<!-- Heroicons -->
<svg style="display:none;">
  <symbol id="chart-bar" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18"/></symbol>
  <symbol id="user" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 100-10 5 5 0 000 10zM3 21a9 9 0 1118 0H3z"/></symbol>
  <symbol id="badge-check" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></symbol>
  <symbol id="folder" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2 3h10v11H3V7z"/></symbol>
  <symbol id="chart-pie" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 2v20M2 11h20"/></symbol>
  <symbol id="arrow-left-on-rectangle" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 17l-5-5 5-5M21 12H9"/></symbol>
  <symbol id="clock" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 8v4l3 3M12 3a9 9 0 100 18 9 9 0 000-18z" />
</symbol>

</svg>

<script>
document.addEventListener("DOMContentLoaded", () => {

    let lastNotifId = localStorage.getItem("lastNotifId_staff") ?? 0;

    async function checkNewNotif() {
        const res = await fetch("<?= base_url('notifications/latest') ?>");
        const notif = await res.json();

        if (!notif || !notif.id) return;

        if (notif.id != lastNotifId) {
            lastNotifId = notif.id;
            localStorage.setItem("lastNotifId_staff", notif.id);

            Swal.fire({
                toast: true,
                position: 'top-end',
                timer: 8000,
                showConfirmButton: false,
                icon: 'info',
                title: notif.message
            });
        }
    }

    async function refreshBadge() {
        const res = await fetch("<?= base_url('notifications/unread-count') ?>");
        const data = await res.json();

        const badge = document.getElementById('notifBadge');
        if (!badge) return;

        if (data.count > 0) {
            badge.innerText = data.count;
            badge.classList.remove("hidden");
        } else {
            badge.classList.add("hidden");
        }
    }

    async function loadDropdown() {
        const list = document.getElementById("notifList");
        if (!list) return;

        const res = await fetch("<?= base_url('notifications/list/10') ?>");
        const data = await res.json();

        list.innerHTML = "";

        data.forEach(n => {
            const li = document.createElement("li");
            li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer";

            li.innerHTML = `
                <div class="${n.status === 'unread' ? 'font-semibold text-blue-600' : ''}">
                    ${n.message}
                </div>
                <div class="text-xs text-gray-500">${n.created_at}</div>
            `;

            li.onclick = () => markAsRead(n.id, n);
            list.appendChild(li);
        });
    }

    async function markAsRead(id, n) {
        await fetch("<?= base_url('notifications/mark') ?>/" + id, { method: "POST" });
        refreshBadge();
        loadDropdown();

        Swal.fire({
            title: "Detail Notifikasi",
            text: n.message,
            icon: "info"
        });
    }

    window.markAllNotif = async () => {
        await fetch("<?= base_url('notifications/mark-all') ?>", { method: "POST" });
        refreshBadge();
        loadDropdown();
    };

    setInterval(() => {
        checkNewNotif();
        refreshBadge();
        loadDropdown();
    }, 6000);

    checkNewNotif();
    refreshBadge();
    loadDropdown();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('alert')): 
    $alert = session()->getFlashdata('alert');
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: "<?= esc($alert['type']) ?>",
        title: "<?= esc($alert['title']) ?>",
        text: "<?= esc($alert['message']) ?>",
        timer: 3000,
        showConfirmButton: false
    });
});
</script>
<?php endif; ?>



<script>
document.addEventListener("DOMContentLoaded", () => {

    const badge = document.getElementById('badge-pengukuran');
    if (!badge) return;

    async function refreshBadgePengukuran() {
        try {
            const res = await fetch("<?= base_url('badge/pengukuran') ?>");
            const data = await res.json();

            const currentMenu = "<?= service('uri')->getSegment(2) ?>";

            if (data.show && currentMenu !== 'task') {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        } catch (e) {
            console.error(e);
        }
    }

    refreshBadgePengukuran();
    setInterval(refreshBadgePengukuran, 5000);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const badge = document.getElementById('badge-dokumen-atasan');
    if (!badge) return;

    const link = badge.closest('a');

    async function refreshBadgeDokumen() {
        try {
            const res = await fetch("<?= base_url('badge/dokumen-atasan') ?>", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) return;

            const data = await res.json();

            if (data.show) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        } catch (err) {
            console.error('Badge dokumen error:', err);
        }
    }

    // Saat atasan klik menu dokumen → badge dihapus
    if (link) {
        link.addEventListener('click', async () => {
            try {
                await fetch("<?= base_url('badge/dokumen-atasan/mark-all') ?>", {
                    method: "POST",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                badge.classList.add('hidden');
            } catch (err) {
                console.error('Mark dokumen read error:', err);
            }
        });
    }

    // Load pertama
    refreshBadgeDokumen();

    // Realtime (polling)
    setInterval(refreshBadgeDokumen, 5000);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    async function checkBadge(endpoint, elementId) {
        try {
            const res = await fetch("<?= base_url() ?>/" + endpoint, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            const badge = document.getElementById(elementId);
            if (!badge) return;

            if (data.show) badge.classList.remove('hidden');
            else badge.classList.add('hidden');

        } catch (err) { console.error(err); }
    }

    // Klik menu → hilangkan badge
    function hideOnClick(linkSelector, markEndpoint, badgeId) {
        const link = document.querySelector(linkSelector);
        if (!link) return;

        link.addEventListener('click', async () => {
            await fetch("<?= base_url() ?>/" + markEndpoint, {
                method: "POST", headers:{'X-Requested-With':'XMLHttpRequest'}
            });
            document.getElementById(badgeId)?.classList.add('hidden');
        });
    }

    // RUN
    setInterval(() => checkBadge('badge/dokumen-unit', 'badge-unit'), 5000);
    setInterval(() => checkBadge('badge/dokumen-public', 'badge-public'), 5000);

    hideOnClick('a[href$="dokumen/unit"]', 'badge/dokumen-unit/mark-all', 'badge-unit');
    hideOnClick('a[href$="dokumen/public"]', 'badge/dokumen-public/mark-all', 'badge-public');

    // pertama load
    checkBadge('badge/dokumen-unit', 'badge-unit');
    checkBadge('badge/dokumen-public', 'badge-public');   

});
</script>

<div id="cropperModal" class="fixed inset-0 z-[99] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" aria-hidden="true"></div>

        <div class="relative inline-block w-full max-w-xl overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">Sesuaikan Foto Profil</h3>
            </div>
            
            <div class="p-6">
                <div class="max-h-[400px] overflow-hidden bg-gray-100 flex justify-center rounded-xl">
                    <img id="imageToCrop" src="" alt="Source" class="max-w-full block">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                <button type="button" id="cancelCrop" class="px-5 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button type="button" id="confirmCrop" class="px-5 py-2 text-sm font-semibold text-white bg-[var(--polban-blue)] rounded-xl hover:opacity-90 transition-all shadow-lg shadow-blue-200">
                    Terapkan & Potong
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let cropper;
const cropperModal = document.getElementById('cropperModal');
const imageToCrop = document.getElementById('imageToCrop');

// Fungsi Global untuk memicu cropper
window.openCropper = function(file, options = {}) {
    const reader = new FileReader();
    reader.onload = (e) => {
        imageToCrop.src = e.target.result;
        cropperModal.classList.remove('hidden');
        
        if (cropper) cropper.destroy();

        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1, 
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            ...options
        });
    };
    reader.readAsDataURL(file);
};

// Tombol Batal
document.getElementById('cancelCrop')?.addEventListener('click', () => {
    cropperModal.classList.add('hidden');
    if (cropper) cropper.destroy();
    // Reset input file di view profil agar bisa pilih file yang sama lagi
    const input = document.getElementById('inputFoto');
    if(input) input.value = '';
});
</script>
</body>
</html>
