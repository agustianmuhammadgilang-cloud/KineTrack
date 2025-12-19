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

        <!-- ISI PENGUKURAN KINERJA -->
        <a href="<?= base_url('atasan/task') ?>"
           class="sidebar-link <?= service('uri')->getSegment(2)=='task' ? 'active':'' ?>">
            <svg class="sidebar-icon"><use href="#chart-pie"/></svg>
            <span>Isi Pengukuran Kinerja</span>
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
                   class="submenu-link <?= $seg2=='dokumen' && $seg3=='' ? 'active':'' ?>">
                    Dokumen Kinerja
                </a>
                <a href="<?= base_url('atasan/kategori/ajukan') ?>"
                   class="submenu-link <?= $seg3=='ajukan' ? 'active':'' ?>">
                    Pengajuan Dokumen
                </a>
                <a href="<?= base_url('atasan/dokumen/arsip') ?>"
                   class="submenu-link <?= $seg3=='arsip' ? 'active':'' ?>">
                    Arsip
                </a>
            </div>
        </div>

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
</svg>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('alert')): 
    $a = session()->getFlashdata('alert'); ?>
<script>
  Swal.fire({
    toast: true, position: 'top-end', showConfirmButton:false, timer:4000,
    icon: '<?= esc($a['type']) ?>', title: '<?= esc($a['title']) ?>', text: '<?= esc($a['message']) ?>'
  });
</script>
<?php endif; ?>

</body>
</html>
