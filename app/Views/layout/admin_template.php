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
<?php if (!empty($notif)): ?>
<script>
Swal.fire({
    icon: 'info',
    title: 'Notifikasi baru',
    text: '<?= esc($notif[0]['message']) ?>',
    toast: true,
    position: 'top-end',
    timer: 4000,
    showConfirmButton: false
});
</script>
<?php endif; ?>



<script>
function loadStaffNotif() {
    fetch("<?= base_url('staff/notifications/list') ?>")
        .then(res => res.json())
        .then(data => {
            const unread = data.filter(n => n.is_read == 0).length;

            // Update badge task sidebar
            const badge = document.querySelector('#task-badge');

            if (badge) {
                if (unread > 0) {
                    badge.innerHTML = unread;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
}

// polling setiap 5 detik
setInterval(loadStaffNotif, 5000);
loadStaffNotif();
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const badge = document.getElementById('notif-badge');
  const menu = document.getElementById('notif-menu');
  const bell = document.getElementById('notif-bell');
  const listEl = document.getElementById('notif-list');
  const markAllBtn = document.getElementById('notif-mark-all');

  async function fetchCount(){
    try {
      const res = await fetch('<?= base_url('notifications/unread-count') ?>');
      if(!res.ok) throw 0;
      const j = await res.json();
      const c = j.count ?? 0;
      if (c > 0) {
        badge.textContent = c;
        badge.classList.remove('hidden');
      } else {
        badge.classList.add('hidden');
      }
    } catch(e) {
      // ignore
    }
  }

  async function fetchList(){
    try {
      const res = await fetch('<?= base_url('notifications/list') ?>');
      if(!res.ok) return;
      const arr = await res.json();
      listEl.innerHTML = '';
      if (arr.length === 0) {
        listEl.innerHTML = '<div class="p-3 text-sm text-gray-600">Tidak ada notifikasi</div>';
        return;
      }
      for (const n of arr) {
        const date = new Date(n.created_at);
        const meta = n.meta ? JSON.parse(n.meta) : null;
        const item = document.createElement('div');
        item.className = 'p-3 border-b hover:bg-gray-50 flex justify-between items-start';
        item.innerHTML = `
            <div class="text-sm">
              <div class="font-medium text-gray-800">${escapeHtml(n.message)}</div>
              <div class="text-xs text-gray-500 mt-1">${date.toLocaleString()}</div>
            </div>
            <div class="ml-2">
              <button data-id="${n.id}" class="notif-mark-read text-xs text-blue-600">Tandai</button>
            </div>
        `;
        listEl.appendChild(item);
      }

      // attach mark buttons
      document.querySelectorAll('.notif-mark-read').forEach(btn=>{
        btn.addEventListener('click', async (e)=>{
          const id = btn.getAttribute('data-id');
          await fetch('<?= base_url('notifications/mark') ?>/' + id, { method:'POST' });
          await fetchCount();
          await fetchList();
        });
      });

    } catch(e){}
  }

  // toggle menu
  bell?.addEventListener('click', async (ev) => {
    menu.classList.toggle('hidden');
    if (!menu.classList.contains('hidden')) {
      await fetchList();
      // optional: mark all read on open? we keep manual
    }
  });

  markAllBtn?.addEventListener('click', async ()=>{
    await fetch('<?= base_url('notifications/mark-all') ?>', { method: 'POST' });
    await fetchCount();
    await fetchList();
  });

  // poll every 12s
  fetchCount();
  setInterval(fetchCount, 12000);

  // safe escape function
  function escapeHtml(str){
    if(!str) return '';
    return String(str).replace(/[&<>"'`=\/]/g, function(s){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'}[s];
    });
  }
});
</script>


</body>
</html>
