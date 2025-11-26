<!-- simple bell + dropdown -->
<div id="notif-root" class="relative">
  <button id="notif-bell" class="relative p-2 rounded hover:bg-white/10">
    <!-- bell icon (heroicon) -->
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .538-.214 1.055-.595 1.45L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>

    <span id="notif-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"></span>
  </button>

  <div id="notif-menu" class="hidden absolute right-0 mt-2 w-96 bg-white shadow-lg rounded-lg overflow-hidden z-50">
      <div class="p-3 border-b">
          <div class="flex justify-between items-center">
              <strong>Notifikasi</strong>
              <button id="notif-mark-all" class="text-sm text-blue-600">Tandai semua dibaca</button>
          </div>
      </div>
      <div id="notif-list" class="max-h-64 overflow-auto"></div>
      <div class="p-2 text-center border-t">
          <a href="<?= base_url('notifications/list') ?>" class="text-sm text-gray-600">Lihat semua</a>
      </div>
  </div>
</div>
