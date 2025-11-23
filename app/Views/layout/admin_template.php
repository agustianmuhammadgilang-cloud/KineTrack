<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Kinetrack</title>

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
</style>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<div class="fixed top-0 left-0 h-full w-64 bg-[var(--polban-blue)] text-white flex flex-col transition-all duration-300 shadow-lg">
    <div class="px-6 py-4 text-center border-b border-white/20">
        <img src="<?= base_url('img/Logo No Name.png') ?>" alt="Polban Logo" class="mx-auto w-16 mb-2">
    </div>
    

    <nav class="flex-1 overflow-y-auto mt-4">
        <a href="<?= base_url('admin') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#chart-bar" /></svg>
            Dashboard
        </a>
        <a href="<?= base_url('admin/users') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#user" /></svg>
            Users
        </a>
        <a href="<?= base_url('admin/jabatan') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#badge-check" /></svg>
            Jabatan
        </a>
        <a href="<?= base_url('admin/bidang') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#folder" /></svg>
            Bidang
        </a>
        <a href="<?= base_url('admin/bidang-select') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#chart-pie" /></svg>
            Analisis Bidang
        </a>
        <a href="<?= base_url('admin/pengukuran') ?>" 
          class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
                <use href="#chart-bar" />
            </svg>
            Input Pengukuran
        </a>
        <a href="<?= base_url('admin/pengukuran/output') ?>" 
          class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
                <use href="#folder" />
            </svg>
            Output Pengukuran
        </a>

        <a href="<?= base_url('admin/profile') ?>" 
   class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
        <use href="#cog-6-tooth" />
    </svg>
    Pengaturan Profil
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
  <symbol id="cog-6-tooth" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" 
          d="M10.343 3.94c.09-.542.56-.94 1.11-.94s1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109 0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.559.94-1.109.94-.55 0-1.02-.398-1.11-.94l-.15-.894c-.07-.424-.383-.764-.78-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.449l.527-.738c.25-.35.273-.806.108-1.203-.165-.398-.505-.71-.93-.781l-.894-.149C3.397 13.02 3 12.55 3 12c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.764-.383.93-.78.165-.398.142-.854-.108-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.273 1.204.108.397-.165.71-.505.78-.93l.15-.893z" />
    <path stroke-linecap="round" stroke-linejoin="round" 
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
</symbol>

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
