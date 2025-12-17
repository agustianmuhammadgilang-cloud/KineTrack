<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Review Dokumen</h2>
            <p class="text-sm text-gray-500">
                Periksa dokumen dan tentukan keputusan
            </p>
        </div>

        <a href="<?= base_url('atasan/dokumen') ?>"
           class="text-sm text-gray-600 hover:underline">
            ← Kembali
        </a>
    </div>

    <!-- Dokumen Card -->
    <div class="bg-white rounded-lg shadow p-6">

        <!-- Judul -->
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            <?= esc($dokumen['judul']) ?>
        </h3>

        <!-- Status -->
        <?php
        $statusMap = [
            'pending_kaprodi' => ['Menunggu Ketua Prodi', 'bg-yellow-100 text-yellow-800'],
            'pending_kajur'   => ['Menunggu Ketua Jurusan', 'bg-blue-100 text-blue-800'],
        ];
        [$label, $class] = $statusMap[$dokumen['status']] ?? ['-', 'bg-gray-100 text-gray-600'];
        ?>
        <span class="inline-block mb-4 px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
            <?= $label ?>
        </span>

        <!-- Deskripsi -->
        <div class="mb-6 text-gray-700 leading-relaxed border-l-4 border-gray-200 pl-4">
            <?= nl2br(esc($dokumen['deskripsi'] ?? '-')) ?>
        </div>

        <!-- File -->
        <div class="mb-6">
            <a href="<?= base_url('uploads/dokumen/' . $dokumen['file_path']) ?>"
               target="_blank"
               class="inline-flex items-center gap-2 text-blue-600 hover:underline font-medium">
                📄 Lihat Dokumen
            </a>
        </div>

        <!-- Action -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <!-- Reject -->
            <button id="btnReject"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow">
                Tolak
            </button>

            <!-- Approve -->
            <form action="<?= base_url('atasan/dokumen/approve/' . $dokumen['id']) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow">
                    Setujui
                </button>
            </form>
        </div>

    </div>
</div>

<!-- SweetAlert Reject -->
<script>
document.getElementById('btnReject').addEventListener('click', function () {
    Swal.fire({
        title: 'Tolak Dokumen',
        input: 'textarea',
        inputLabel: 'Catatan Penolakan',
        inputPlaceholder: 'Tuliskan alasan penolakan...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        preConfirm: (catatan) => {
            if (!catatan) {
                Swal.showValidationMessage('Catatan wajib diisi');
            }
            return catatan;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= base_url('atasan/dokumen/reject/' . $dokumen['id']) ?>";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '<?= csrf_token() ?>';
            csrf.value = '<?= csrf_hash() ?>';

            const note = document.createElement('input');
            note.type = 'hidden';
            note.name = 'catatan';
            note.value = result.value;

            form.appendChild(csrf);
            form.appendChild(note);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>

<?= $this->endSection() ?>
