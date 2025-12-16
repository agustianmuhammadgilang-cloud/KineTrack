<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:p-6 md:p-8 transition-all duration-300 dark:bg-gray-900">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-blue-900 dark:text-blue-300 flex items-center gap-2">
            Dashboard Admin
            <span class="text-xl"></span>
        </h2>

        <!-- NOTIFIKASI -->
        <div x-data="{ openNotif: false }" class="relative mr-4">
            <button @click="openNotif = !openNotif"
                    class="relative p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <svg id="bellPulse" class="w-6 h-6 text-gray-700 dark:text-gray-200 bell-pulse"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zm0 16a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span id="notifBadge"
                      class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full animate-ping">
                    0
                </span>
            </button>

            <div x-show="openNotif"
                 @click.outside="openNotif = false"
                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg rounded-xl z-50">
                <ul id="notifList" class="max-h-80 overflow-y-auto">
                    <!-- Diisi otomatis JS -->
                </ul>
                <div class="p-2 text-center text-blue-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                     id="markAll" @click="markAllNotif()">
                    Tandai semua dibaca
                </div>
            </div>
        </div>

    </div>

    <!-- Topbar Profile -->
    <div class="w-full flex items-center justify-end mb-6">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-2 p-2 rounded-xl transition-all
                       hover:bg-blue-100 dark:hover:bg-gray-700">
                <img src="<?= base_url('uploads/profile/' . (session('foto') ?? 'default.png')) ?>"
                     class="w-10 h-10 rounded-full object-cover border-2 border-blue-900">
                <span class="hidden sm:block font-semibold text-gray-800 dark:text-gray-200 tracking-wide">
                    <?= session('nama') ?>
                </span>
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none">
                    <?= heroicons_outline('chevron-down') ?>
                </svg>
            </button>

            <div x-show="open" x-transition @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 shadow-xl rounded-xl 
                        border border-gray-200 dark:border-gray-700 py-2 z-50">
                <a href="<?= base_url('admin/profile') ?>"
                   class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 
                          hover:bg-[var(--polban-blue)] hover:text-white transition-all">
                    Profil Saya
                </a>
                <a href="<?= base_url('logout') ?>"
                   class="block px-4 py-2 rounded-lg text-red-600 dark:text-red-400 
                          hover:bg-red-100 dark:hover:bg-red-700 transition-all">
                    Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-8">

        <!-- CARD TEMPLATE -->
        <div class="group rounded-2xl p-6 shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-2xl
                    bg-gradient-to-r from-blue-500 to-blue-600 text-white relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50 transition-all">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" viewBox="0 0 24 24" fill="none">
                    <?= heroicons_outline('users') ?>
                </svg>
            </div>
            <p class="font-semibold text-sm sm:text-base">Total User</p>
            <h1 class="text-3xl sm:text-4xl font-bold mt-1 sm:mt-2"><?= $total_user ?></h1>
        </div>

        <div class="group rounded-2xl p-6 shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-2xl
                    bg-gradient-to-r from-yellow-400 to-yellow-500 text-white relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50 transition-all">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('trophy') ?>
                </svg>
            </div>
            <p class="font-semibold text-sm sm:text-base">Total Jabatan</p>
            <h1 class="text-3xl sm:text-4xl font-bold mt-1 sm:mt-2"><?= $total_jabatan ?></h1>
        </div>

        <div class="group rounded-2xl p-6 shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-2xl
                    bg-gradient-to-r from-orange-400 to-orange-500 text-white relative overflow-hidden">
            <div class="absolute right-3 top-3 opacity-20 group-hover:opacity-50 transition-all">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none">
                    <?= heroicons_outline('folder') ?>
                </svg>
            </div>
            <p class="font-semibold text-sm sm:text-base">Total Bidang</p>
            <h1 class="text-3xl sm:text-4xl font-bold mt-1 sm:mt-2"><?= $total_bidang ?></h1>
        </div>

    </div>

    <!-- Main Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Welcome Box -->
        <div class="lg:col-span-2">
            <div class="bg-white/70 dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl 
                        p-6 sm:p-8 shadow-md border border-gray-100 dark:border-gray-700 
                        transition-all duration-300">
                
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    👋 Halo, <?= session('nama') ?>!
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2 leading-relaxed text-sm sm:text-base">
                    Selamat bekerja, tetap jaga kualitas data sesuai standar  
                    <b>Politeknik Negeri Bandung</b>.
                </p>

                <a href="<?= base_url('admin/bidang-select') ?>"
                    class="inline-flex w-full sm:w-auto mt-4 sm:mt-6 px-4 sm:px-6 py-3 bg-orange-500 hover:bg-orange-600 
                           text-white font-semibold rounded-xl transition shadow-md justify-center">
                    🚀 Analisis Kinerja Bidang
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 sm:p-6 
                    border border-gray-100 dark:border-gray-700 transition-all duration-300">
            <h4 class="font-bold mb-4 text-lg sm:text-xl text-gray-800 dark:text-gray-200 flex items-center gap-2">
                ⚡ Quick Actions
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="<?= base_url('admin/users') ?>"
                    class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-white dark:bg-gray-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 
                           transition-all shadow hover:shadow-lg transform hover:-translate-y-1 font-semibold text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none"><?= heroicons_outline('user') ?></svg>
                    Kelola User
                </a>

                <a href="<?= base_url('admin/bidang') ?>"
                    class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-white dark:bg-gray-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 
                           transition-all shadow hover:shadow-lg transform hover:-translate-y-1 font-semibold text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none"><?= heroicons_outline('folder') ?></svg>
                    Kelola Bidang
                </a>

                <a href="<?= base_url('admin/jabatan') ?>"
                    class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-white dark:bg-gray-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 
                           transition-all shadow hover:shadow-lg transform hover:-translate-y-1 font-semibold text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none"><?= heroicons_outline('trophy') ?></svg>
                    Kelola Jabatan
                </a>

                <a href="<?= base_url('admin/bidang-select') ?>"
                    class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-white dark:bg-gray-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 
                           transition-all shadow hover:shadow-lg transform hover:-translate-y-1 font-semibold text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none"><?= heroicons_outline('chart-bar') ?></svg>
                    Analisis Bidang
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <p class="text-center text-gray-500 dark:text-gray-400 mt-6 sm:mt-8 text-xs sm:text-sm">
        © <?= date('Y') ?> KINETRACK — Politeknik Negeri Bandung.
    </p>

</div>

<?= $this->endSection() ?>
