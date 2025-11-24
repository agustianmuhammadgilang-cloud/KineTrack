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
</style>
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
                <use href="#chart-bar" />
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
              <use href="#chart-bar" />
            </svg>
            <span class="flex-1">Input Pengukuran</span>
            
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
                    Kelola PIC
                </a>

                <a href="<?= base_url('admin/pengukuran') ?>"
                    class="px-4 py-2 rounded hover:bg-white/10 transition
                    <?= (service('uri')->getSegment(2) == 'testing-pk') ? 'bg-white/20 font-semibold' : '' ?>">
                    Testing PK
                </a>
            </div>
        </div>

         <!-- Analisis Bidang -->
        <a href="<?= base_url('admin/bidang-select') ?>"
            class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
            <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
                <use href="#chart-pie" />
            </svg>
            Analisis Bidang
        </a>
        
        <!-- Output Pengukuran -->
        <a href="<?= base_url('admin/pengukuran/output') ?>"
            class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
            <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
                <use href="#folder" />
            </svg>
            Output Pengukuran
        </a>

        <!-- Profil -->
        <a href="<?= base_url('admin/profile') ?>"
            class="flex items-center gap-3 px-6 py-3 rounded hover:bg-white/10 transition">
            <svg class="sidebar-icon text-white" fill="none" stroke="currentColor">
                <use href="#cog-6-tooth" />
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

</body>
</html>
