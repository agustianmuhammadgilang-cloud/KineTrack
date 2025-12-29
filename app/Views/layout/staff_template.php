<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff - Kinetrack</title>

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
    <a href="<?= base_url('staff') ?>"
       class="sidebar-link <?= service('uri')->getSegment(1)=='staff' && service('uri')->getSegment(2)==null ? 'active':'' ?>">
        <svg class="sidebar-icon"><use href="#chart-bar"/></svg>
        <span>Dashboard</span>
    </a>

    <!-- LOG AKTIVITAS -->
<a href="<?= base_url('staff/activity-logs') ?>"
   class="sidebar-link <?= service('uri')->getSegment(2)=='activity-logs' ? 'active':'' ?>">
    <svg class="sidebar-icon"><use href="#clock"/></svg>
    <span>Log Aktivitas</span>
</a>


    <!-- ISI PENGUKURAN KINERJA -->
    <a href="<?= base_url('staff/task') ?>"
       class="sidebar-link <?= service('uri')->getSegment(2)=='task' ? 'active':'' ?>">
        <svg class="sidebar-icon"><use href="#chart-pie"/></svg>
        <span>Isi Pengukuran Kinerja</span>
    </a>

    <!-- DOKUMEN GROUP -->
    <?php
        $docActive = in_array(service('uri')->getSegment(2), ['dokumen','kategori']);
    ?>

    <div x-data="{ open: <?= $docActive ? 'true':'false' ?> }" class="mt-2">

        <!-- PARENT -->
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
$seg2 = $uri->getSegment(2, ''); // aman
$seg3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : ''; // aman
?>
<div x-show="open" x-transition class="submenu space-y-1">

    <a href="<?= base_url('staff/dokumen') ?>"
       class="submenu-link <?= $seg2=='dokumen' && $seg3=='' ? 'active':'' ?>">
        Dokumen Kinerja
    </a>

    <a href="<?= base_url('staff/kategori/ajukan') ?>"
       class="submenu-link <?= $seg3=='ajukan' ? 'active':'' ?>">
        Pengajuan Dokumen
    </a>

    <a href="<?= base_url('staff/dokumen/arsip') ?>"
       class="submenu-link <?= $seg3=='arsip' ? 'active':'' ?>">
        Arsip
    </a>

    <!-- DIVIDER -->
    <div class="mt-3 pt-2 border-t border-white/10">
        <div class="px-2 mb-1 text-[11px] tracking-widest uppercase text-white/50">
            Jenis Dokumen
        </div>

        <a href="<?= base_url('staff/dokumen/saya') ?>"
           class="submenu-link <?= $seg3=='saya' ? 'active':'' ?>">
            Dokumen Saya
        </a>

        <a href="<?= base_url('staff/dokumen/unit') ?>"
           class="submenu-link <?= $seg3=='unit' ? 'active':'' ?>">
            Dokumen Unit
        </a>


        <a href="<?= base_url('staff/dokumen/public') ?>"
   class="submenu-link <?= $seg3=='public' ? 'active':'' ?>">
    Dokumen Publik
</a>

    </div>
</div>

    </div>

    <!-- PROFIL -->
    <a href="<?= base_url('staff/profile') ?>"
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
  <symbol id="check-badge" viewBox="0 0 24 24">
    <symbol id="clock" viewBox="0 0 24 24">
  <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
  <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" fill="none"/>
</symbol>

    <path 
        stroke="#ffffff"
        fill="none"
        stroke-width="2"
        stroke-linecap="round" 
        stroke-linejoin="round"
        d="M9 12l2 2 4-4M12 2l3 7 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1 3-7z" 
    />
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

async function fetchPending(){
  try {
    const res = await fetch('<?= base_url('notifications/pending-count') ?>');
    const j = await res.json();
    const el = document.getElementById('task-badge');
    if (j.count > 0) {
      el.textContent = j.count;
      el.classList.remove('hidden');
    } else {
      el.classList.add('hidden');
    }
  } catch(e){}
}
fetchPending();
setInterval(fetchPending, 12000);

</script>

<?php if (!empty($notifikasi)): ?>
<script>
<?php foreach($notifikasi as $n): ?>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'info',
    title: <?= json_encode($n['message']) ?>,
    showConfirmButton: false,
    timer: 3500
});
<?php endforeach; ?>
</script>
<?php endif; ?>
</body>
</html>
