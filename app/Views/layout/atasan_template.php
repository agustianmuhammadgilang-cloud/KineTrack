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

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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

   <nav class="flex-1 overflow-y-auto mt-4" x-data="{ openDokumen: localStorage.getItem('dokumenOpen') === 'true' }"
     x-init="$watch('openDokumen', val => localStorage.setItem('dokumenOpen', val))">

    <!-- Dashboard -->
    <a href="<?= base_url('atasan') ?>"
       class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
            <use href="#chart-bar" />
        </svg>
        Dashboard
    </a>

    <!-- Isi Pengukuran -->
    <a href="<?= base_url('atasan/pengukuran') ?>"
       class="flex items-center px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
            <use href="#chart-pie" />
        </svg>
        Isi Pengukuran
    </a>

    <!-- Dokumen (Dropdown Persistent) -->
    <button type="button"
            @click="openDokumen = !openDokumen"
            class="w-full flex items-center justify-between px-6 py-3 text-sm font-medium rounded hover:bg-white/10 transition-colors">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
                <use href="#folder" />
            </svg>
            Dokumen
        </div>
        <svg class="w-4 h-4 transition-transform"
             :class="openDokumen ? 'rotate-90' : ''"
             fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div x-show="openDokumen"
         x-transition
         class="ml-6 mt-1 space-y-1">

        <a href="<?= base_url('atasan/dokumen') ?>"
           class="block px-6 py-2 text-sm rounded hover:bg-white/10 transition">
            Dokumen Masuk
        </a>

        <a href="<?= base_url('atasan/dokumen/unit') ?>"
           class="block px-6 py-2 text-sm rounded hover:bg-white/10 transition">
            Dokumen Unit
        </a>

        <a href="<?= base_url('atasan/dokumen/arsip') ?>"
           class="block px-6 py-2 text-sm rounded hover:bg-white/10 transition">
            Arsip Dokumen
        </a>
    </div>

    <!-- Profile -->
    <a href="<?= base_url('atasan/profile') ?>"
       class="flex items-center px-6 py-3 mt-2 text-sm font-medium rounded hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2">
            <use href="#user" />
        </svg>
        Profile
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Axios (optional) or use fetch) -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  // --- SweetAlert2 Toast default ---
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    customClass: { popup: 'shadow-sm' }
  });

  // show flashdata alert as toast (if server set session 'alert' array)
  <?php if (session()->getFlashdata('alert')): 
      $a = session()->getFlashdata('alert'); ?>
    Toast.fire({
      icon: '<?= esc($a['type']) ?>',
      title: '<?= esc($a['title']) ?>',
      text: '<?= esc($a['message']) ?>'
    });
  <?php endif; ?>

  // --- Polling logic for pending badge & toast ---
  (function(){
    let prevCount = null;            // store last count locally
    const badge = document.getElementById('pending-badge');

    // update badge UI
    function updateBadge(count){
      if(!badge) return;
      if(count && count > 0){
        badge.style.display = 'inline-block';
        badge.innerText = count;
      }else{
        badge.style.display = 'none';
      }
    }

    // call server endpoint
    async function fetchPending(){
      try{
        const res = await axios.get('<?= base_url('atasan/notifications/pending-count') ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if(res && res.data){
          const count = parseInt(res.data.pending) || 0;
          // first load: just set badge
          if(prevCount === null){
            prevCount = count;
            updateBadge(count);
            return;
          }
          // if count increased -> show toast
          if(count > prevCount){
            const added = count - prevCount;
            Toast.fire({
              icon: 'info',
              title: 'Ada laporan baru',
              text: `Anda memiliki ${count} laporan pending (${added} baru).`
            });
          }
          // update prev & badge
          prevCount = count;
          updateBadge(count);
        }
      }catch(err){
        console.error('Notif fetch error', err);
      }
    }

    // initial fetch
    fetchPending();

    // polling interval: 10 seconds (adjust as needed)
    setInterval(fetchPending, 10000);
  })();
</script>

</body>
</html>
