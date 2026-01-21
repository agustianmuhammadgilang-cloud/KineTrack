<?= $this->extend('layout/atasan_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue-light: #004a94; /* Pastikan ini ada */
        --polban-gold: #D4AF37;
        --success-emerald: #059669;
        --danger-rose: #e11d48;
    }

    .app-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        box-shadow: 0 10px 30px -5px rgba(0, 51, 102, 0.05);
    }

    .btn-decision {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 11px;
        cursor: pointer;
    }

    /* Perbaikan Button Approve */
    .btn-approve {
        background: var(--polban-blue);
        color: white !important; /* Paksa teks tetap putih */
        border: none;
    }

    .btn-approve:hover {
        background: var(--polban-blue-light);
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(0, 51, 102, 0.4);
    }

    .btn-approve:active {
        transform: translateY(0);
    }

    /* Perbaikan Button Reject */
    .btn-reject {
        background: white;
        color: var(--danger-rose);
        border: 2px solid #ffe4e6;
    }

    .btn-reject:hover {
        background: var(--danger-rose);
        border-color: var(--danger-rose);
        color: white; /* Teks berubah putih saat hover reject */
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(225, 29, 72, 0.3);
    }

    .info-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 8px;
        display: block;
    }
</style>

<div class="px-6 py-8 max-w-5xl mx-auto">
    
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-1 bg-polban-gold h-10 rounded-full"></div>
            <div>
                <h1 class="text-2xl font-black text-blue-900 tracking-tight">Review Keputusan</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dokumen ID: #DOC-<?= $dokumen['id'] ?></p>
            </div>
        </div>
        <a href="<?= base_url('atasan/dokumen') ?>" class="text-xs font-black text-slate-400 hover:text-blue-900 transition-colors uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kembali
        </a>
    </div>

    <div class="app-card overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3">
            
            <div class="lg:col-span-2 p-8 md:p-12 border-r border-slate-50">
                <div class="mb-10">
                    <?php
                    $statusMap = [
                        'pending_kaprodi' => 'MENUNGGU VERIFIKASI KAPRODI',
                        'pending_kajur'   => 'MENUNGGU PERSETUJUAN KAJUR',
                    ];
                    ?>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded-lg border border-blue-100">
                        <?= $statusMap[$dokumen['status']] ?? 'STATUS TIDAK DIKETAHUI' ?>
                    </span>
                    <h2 class="text-3xl font-black text-blue-900 mt-4 leading-tight">
                        <?= esc($dokumen['judul']) ?>
                    </h2>
                </div>

                <div class="space-y-8">
                    <div>
                        <span class="info-label">Deskripsi Pengajuan</span>
                        <div class="text-slate-600 leading-relaxed text-sm font-medium bg-slate-50 p-6 rounded-2xl">
                            <?= nl2br(esc($dokumen['deskripsi'] ?? 'Pengaju tidak menyertakan deskripsi tambahan.')) ?>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-slate-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase">File Lampiran</p>
                                <p class="text-xs font-bold text-blue-900 truncate max-w-[200px]"><?= $dokumen['file_path'] ?></p>
                            </div>
                        </div>
                        <a href="<?= base_url('uploads/dokumen/' . $dokumen['file_path']) ?>" target="_blank" class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black rounded-lg uppercase hover:bg-blue-900 transition-colors">
                            Lihat File
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50/50 p-8 md:p-12 flex flex-col justify-between">
                <div>
                    <div class="mb-8">
                        <span class="info-label">Aksi Keputusan</span>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Sebagai otoritas penandatangan, keputusan Anda akan menentukan alur verifikasi selanjutnya.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <form action="<?= base_url('atasan/dokumen/approve/' . $dokumen['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-decision btn-approve w-full py-5 rounded-2xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                Setujui Dokumen
                            </button>
                        </form>

                        <button id="btnReject" class="btn-decision btn-reject w-full py-5 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            Tolak Pengajuan
                        </button>
                    </div>
                </div>

                <div class="mt-12 p-5 bg-blue-900 rounded-2xl text-white">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-polban-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                        <p class="text-[10px] font-bold leading-relaxed opacity-80 uppercase tracking-tight">
                            Persetujuan akan meneruskan dokumen ke tingkat jabatan di atasnya atau menandai dokumen selesai.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('btnReject').addEventListener('click', function () {
    Swal.fire({
        title: '<div class="text-blue-900 font-black text-xl uppercase tracking-tight">Konfirmasi Penolakan</div>',
        html: `
            <div class="text-left mt-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Alasan Penolakan</label>
                <textarea id="rejectReason" class="w-full h-32 p-4 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-900 focus:border-transparent outline-none transition-all" placeholder="Contoh: Dokumen belum ditandatangani oleh pemohon..."></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'TOLAK SEKARANG',
        cancelButtonText: 'KEMBALI',
        confirmButtonColor: '#e11d48', // Red for Reject
        cancelButtonColor: '#f8fafc',
        reverseButtons: true,
        customClass: {
            container: 'rounded-3xl',
            popup: 'rounded-[32px] p-6',
            confirmButton: 'px-8 py-4 rounded-xl font-black text-xs tracking-widest',
            cancelButton: 'px-8 py-4 rounded-xl font-black text-xs tracking-widest text-slate-500'
        },
        preConfirm: () => {
            const reason = Swal.getPopup().querySelector('#rejectReason').value;
            if (!reason) {
                Swal.showValidationMessage('Anda wajib memberikan alasan penolakan agar staff dapat memperbaiki dokumen.');
            }
            return reason;
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