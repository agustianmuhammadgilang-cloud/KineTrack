<?= $this->extend('layout/pimpinan_template') ?>
<?= $this->section('content') ?>

<h3 class="text-2xl font-bold text-[var(--polban-blue)] mb-6">
    Detail Pengukuran - Indikator
</h3>


<!-- Informasi Indikator -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200 mb-6">

    <h4 class="text-xl font-semibold text-gray-800 mb-4">
        Informasi Indikator
    </h4>

    <p class="text-gray-600 mb-1">
        <strong>Sasaran Strategis:</strong> <?= esc($indikator['nama_sasaran']) ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Nama Indikator:</strong> <?= esc($indikator['nama_indikator']) ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Satuan:</strong> <?= esc($indikator['satuan'] ?? '-') ?>
    </p>

    <p class="text-gray-600 mb-1">
        <strong>Target PK (<?= esc($tahun) ?>):</strong> <?= esc($indikator['target_pk'] ?? '-') ?>
    </p>

    <p class="text-gray-600 mb-4">
        <strong>Target Per Triwulan:</strong><br>
        • TW I : <?= esc($indikator['target_tw1'] ?? '-') ?><br>
        • TW II : <?= esc($indikator['target_tw2'] ?? '-') ?><br>
        • TW III : <?= esc($indikator['target_tw3'] ?? '-') ?><br>
        • TW IV : <?= esc($indikator['target_tw4'] ?? '-') ?>
    </p>

    <p class="text-gray-700 text-sm italic">
        <strong>Periode:</strong> Tahun <?= esc($tahun) ?> — Triwulan <?= esc($tw) ?>
    </p>
</div>

<!-- Tombol Back -->
<a href="<?= base_url('pimpinan/pengukuran/output?tahun_id='.$tahun.'&triwulan='.$tw) ?>"
   class="inline-block mb-4 bg-[var(--polban-blue)] text-white px-4 py-2 rounded-lg shadow hover:bg-blue-800 transition">
    Kembali
</a>



<!-- TABEL PENGUKURAN STAFF -->
<div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

    <h4 class="text-xl font-semibold text-gray-800 mb-4">
        Input Pengukuran Staff
    </h4>

    <?php if (empty($pengukuran)): ?>
        <p class="text-gray-600 text-sm">Belum ada pengukuran yang diinput staff.</p>

    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Staff</th>
                        <th class="p-3 border">Realisasi</th>
                        <th class="p-3 border">Progress</th>
                        <th class="p-3 border">Kendala</th>
                        <th class="p-3 border">Strategi</th>
                        <th class="p-3 border">File Dukung</th>
                        <th class="p-3 border">Tanggal Input</th>
                    </tr>
                </thead>

                <tbody>
<?php foreach ($pengukuran as $p): ?>
    <tr class="hover:bg-gray-50">

        <!-- STAFF -->
        <td class="p-3 border"><?= esc($p['user_nama']) ?></td>

        <!-- REALISASI -->
        <td class="p-3 border"><?= esc($p['realisasi']) ?></td>

        <!-- PROGRESS -->
        <td class="p-3 border"><?= $p['progress'] ? esc($p['progress']) : '-' ?></td>

        <!-- KENDALA -->
        <td class="p-3 border"><?= esc($p['kendala'] ?: '-') ?></td>

        <!-- STRATEGI -->
        <td class="p-3 border"><?= esc($p['strategi'] ?: '-') ?></td>

        <!-- FILE DUKUNG -->
        <td class="p-3 border text-center">
            <?php
                $files = json_decode($p['file_dukung'], true);

                // BACKWARD COMPATIBILITY: jika single string
                if (is_string($p['file_dukung']) && !is_array($files)) {
                    $files = [$p['file_dukung']];
                }
            ?>

            <?php if (!empty($files) && is_array($files)): ?>
                <ul class="text-left space-y-1">
                    <?php foreach ($files as $i => $f): ?>
                        <li>
                            <a href="<?= base_url('uploads/pengukuran/' . $f) ?>"
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                File <?= $i + 1 ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <span class="text-gray-500">-</span>
            <?php endif; ?>
        </td>

        <!-- TANGGAL INPUT -->
        <td class="p-3 border">
            <?= esc(date('d M Y H:i', strtotime($p['created_at']))) ?>
        </td>

        

    </tr>
<?php endforeach; ?>
</tbody>

            </table>
        </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(url, namaStaff) {
        Swal.fire({
            title: '<div class="text-2xl font-black text-blue-900 tracking-tight mb-2">Konfirmasi Hapus</div>',
            html: `
                <div class="text-slate-500 text-sm font-medium leading-relaxed">
                    Apakah Anda yakin ingin menghapus data pengukuran dari staff <br>
                    <span class="text-blue-600 font-bold">"${namaStaff}"</span>?
                    <p class="text-[10px] text-red-400 mt-3 uppercase tracking-[0.2em] font-bold">Data realisasi dan file dukung akan terhapus permanen</p>
                </div>
            `,
            icon: 'warning',
            iconColor: '#D4AF37',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonText: 'Batalkan',
            reverseButtons: true,
            background: '#ffffff',
            padding: '2.5rem',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-[30px] border border-slate-100 shadow-2xl',
                confirmButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-red-600 text-white hover:bg-red-700 transition-all active:scale-95',
                cancelButton: 'px-6 py-3 mx-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-500 hover:bg-slate-200 transition-all active:scale-95'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Efek loading
                Swal.fire({
                    title: '<span class="text-sm font-bold text-slate-500 uppercase tracking-widest">Memproses Penghapusan...</span>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const loader = Swal.getHtmlContainer().querySelector('.swal2-loader');
                        if (loader) loader.style.borderTopColor = '#003366';
                    },
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-[20px]' }
                });
                
                window.location.href = url;
            }
        });
    }

</script>

<?= $this->endSection() ?>