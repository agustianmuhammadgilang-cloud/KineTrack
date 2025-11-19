<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atasan - Kinetrack</title>

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
        <a href="<?= base_url('atasan') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#chart-bar" /></svg>
            Dashboard
        </a>
        <a href="<?= base_url('atasan/laporan') ?>" class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><use href="#user" /></svg>
            Laporan
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

</body>
</html>
