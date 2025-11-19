<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Laporan Masuk
    </h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 dark:bg-green-800 dark:text-green-200 text-green-800 px-4 py-3 rounded mb-4 shadow">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                
                <thead class="bg-[var(--polban-blue)] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">No</th>
                        <th class="px-4 py-3 text-left font-medium">Nama Staff</th>
                        <th class="px-4 py-3 text-left font-medium">Judul</th>
                        <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                        <th class="px-4 py-3 text-left font-medium">Status</th>
                        <th class="px-4 py-3 text-left font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $no=1; foreach($laporan as $l): 
                        $user = model('UserModel')->find($l['user_id']);
                    ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3"><?= $no++ ?></td>
                        <td class="px-4 py-3"><?= esc($user['nama']) ?></td>
                        <td class="px-4 py-3"><?= esc($l['judul']) ?></td>
                        <td class="px-4 py-3"><?= esc($l['tanggal']) ?></td>

                        <td class="px-4 py-3">
                            <?php if($l['status']=='pending'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-300 text-gray-800">
                                    Pending
                                </span>
                            <?php elseif($l['status']=='approved'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                                    Diterima
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-500 text-white">
                                    Ditolak
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3">
                            <a href="<?= base_url('atasan/laporan/detail/'.$l['id']) ?>" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium transition-all">
                                Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
