<!DOCTYPE html>
<html>
<head>
    <title>Atasan - Kinetrack</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root{
            --polban-blue:#1D2F83;
            --polban-orange:#F58025;
        }
        .btn-polban{ background:var(--polban-orange); color:white; }
        .btn-polban:hover{ background:#c7671e; color:white; }
        .sidebar{
            width:250px; height:100vh; background:var(--polban-blue);
            position:fixed; padding-top:20px;
        }
        .sidebar a{
            display:block; padding:12px 20px; color:white; text-decoration:none;
        }
        .sidebar a:hover{
            background:rgba(255,255,255,0.1);
        }
        .content{ margin-left:260px; padding:30px; }
    </style>
</head>

<body>

<div class="sidebar">
    <h4 class="text-center text-white mb-4">KINETRACK</h4>

<!-- sidebar -->
<a href="<?= base_url('atasan') ?>">🏠 Dashboard</a>
<a href="<?= base_url('atasan/laporan') ?>">
  📄 Laporan Masuk
  <span id="pending-badge" class="badge bg-danger ms-2" style="display:none">0</span>
</a>



    <hr class="text-white">
    <a href="<?= base_url('logout') ?>">Logout</a>
</div>

<div class="content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


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
