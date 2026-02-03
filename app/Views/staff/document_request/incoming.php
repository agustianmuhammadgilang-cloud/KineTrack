<?= $this->extend('layout/staff_template') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    :root {
        --polban-blue: #1D2F83;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Navigasi Aktif dengan Aksen Gold - Identik dengan Index */
    .nav-link-active {
        background-color: var(--polban-blue);
        color: white !important;
        box-shadow: 0 10px 20px -5px rgba(29, 47, 131, 0.25);
        border-bottom: 3px solid var(--polban-gold);
    }

    .main-card {
        background: white;
        border-radius: 32px; 
        border: 1px solid #eef2f6;
        box-shadow: 0 10px 30px -12px rgba(0, 51, 102, 0.05);
    }

    .btn-action {
        transition: var(--transition-smooth);
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Custom scrollbar untuk tabel agar tetap rapi di mobile */
    .table-container::-webkit-scrollbar {
        height: 6px;
    }
    .table-container::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    [x-cloak] { display: none !important; }
</style>

<div class="px-6 py-10 max-w-7xl mx-auto min-h-screen" 
     x-data="{ 
        showRejectModal: false, 
        showApproveModal: false,
        actionUrl: '', 
        docTitle: '',
        openReject(id, title) {
            this.actionUrl = '<?= site_url('document-request/reject/') ?>' + id;
            this.docTitle = title;
            this.showRejectModal = true;
        },
        openApprove(id, title) {
            this.actionUrl = '<?= site_url('document-request/approve/') ?>' + id;
            this.docTitle = title;
            this.showApproveModal = true;
        }
     }">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
            </div>
            <div>
                <h4 class="text-3xl font-black text-blue-900 tracking-tight">Permintaan <span class="text-blue-600">Masuk</span></h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">Kinetrack — Kelola Persetujuan Akses Arsip</p>
            </div>
        </div>

        <div class="flex bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/50 backdrop-blur-sm overflow-x-auto">
    <a href="<?= site_url('document-request') ?>" 
       class="text-slate-500 hover:text-blue-900 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Cari Dokumen
    </a>

    <a href="<?= site_url('document-request/incoming') ?>" 
       class="nav-link-active px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 whitespace-nowrap relative">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
        Permintaan Masuk
        <?php if (!empty($badgeIncoming)): ?>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm">
                <?= $badgeIncoming ?>
            </span>
        <?php endif; ?>
    </a>

    <a href="<?= site_url('document-request/my-status') ?>" 
       class="relative text-slate-500 hover:text-blue-900 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Status Saya
        <?php if (!empty($badgeStatus)): ?>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm">
                <?= $badgeStatus ?>
            </span>
        <?php endif; ?>
    </a>
</div>
    </div>

    <div class="main-card overflow-hidden">
        <div class="overflow-x-auto table-container">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pemohon</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Dokumen & Alasan</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($requests)): ?>
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" /></svg>
                            </div>
                            <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">Belum ada permintaan masuk</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $req): ?>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-900 text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/20 uppercase">
                                        <?= substr($req['nama_pemohon'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-blue-900 tracking-tight"><?= esc($req['nama_pemohon']) ?></p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5"><?= date('d M Y • H:i', strtotime($req['created_at'])) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8 max-w-md">
                                <p class="text-sm font-black text-blue-900 mb-2 leading-snug line-clamp-1"><?= esc($req['judul']) ?></p>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white transition-colors">
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed italic">"<?= esc($req['reason']) ?>"</p>
                                </div>
                                <?php if($req['attachment']): ?>
                                    <a href="<?= base_url('uploads/request/'.$req['attachment']) ?>" target="_blank" 
                                       class="inline-flex items-center gap-2 mt-3 text-[9px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-all">
                                        <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        </div>
                                        Lihat Lampiran
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <?php 
                                    $statusClass = [
                                        'pending'  => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'rejected' => 'bg-rose-50 text-rose-600 border-rose-100'
                                    ];
                                ?>
                                <span class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest border <?= $statusClass[$req['status']] ?? 'bg-slate-50 text-slate-500' ?>">
                                    <?= $req['status'] ?>
                                </span>
                            </td>
                            <td class="px-8 py-8 text-right">
    <?php if($req['status'] == 'pending'): ?>
    <div class="flex justify-end gap-3">
        <button @click="openApprove('<?= $req['id'] ?>', '<?= esc($req['judul'], 'js') ?>')" 
                class="btn-action w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100 hover:bg-emerald-600 hover:text-white shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
        </button>

        <button @click="openReject('<?= $req['id'] ?>', '<?= esc($req['judul'], 'js') ?>')" 
                class="btn-action w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center border border-rose-100 hover:bg-rose-600 hover:text-white shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    <?php else: ?>
        <?php endif; ?>
</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <template x-teleport="body">
    <div>
        <div x-show="showApproveModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div x-show="showApproveModal" x-transition.opacity @click="showApproveModal = false" class="fixed inset-0 bg-blue-950/60 backdrop-blur-sm"></div>
            <div x-show="showApproveModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden">
                
                <div class="bg-emerald-600 p-8 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-black uppercase tracking-widest">Setujui Akses</h5>
                            <p class="text-emerald-100 text-[9px] uppercase font-bold mt-0.5 tracking-widest">Konfirmasi Persetujuan Dokumen</p>
                        </div>
                    </div>
                </div>

                <div class="p-10">
                    <div class="mb-8 p-5 bg-emerald-50 rounded-2xl border border-emerald-100 border-l-4 border-l-emerald-500">
                        <label class="text-[9px] font-black text-emerald-900 uppercase mb-1 block tracking-widest opacity-60">Dokumen yang akan disetujui</label>
                        <p class="text-sm font-black text-emerald-900 leading-tight" x-text="docTitle"></p>
                    </div>
                    <p class="text-slate-500 text-sm font-medium text-center mb-8 px-4">Apakah Anda yakin ingin memberikan akses dokumen ini kepada pemohon?</p>
                    
                    <form :action="actionUrl" method="post" class="flex gap-4">
                        <?= csrf_field() ?>
                        <button type="button" @click="showApproveModal = false" class="flex-1 py-4 text-[10px] font-black text-slate-400 hover:text-blue-900 transition-colors uppercase tracking-[0.2em]">Batal</button>
                        <button type="submit" class="flex-[2] bg-emerald-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 transition-all">Ya, Setujui</button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div x-show="showRejectModal" x-transition.opacity @click="showRejectModal = false" class="fixed inset-0 bg-blue-950/60 backdrop-blur-sm"></div>
            <div x-show="showRejectModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden">
                
                <div class="bg-rose-600 p-8 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-black uppercase tracking-widest">Tolak Akses</h5>
                            <p class="text-rose-100 text-[9px] uppercase font-bold mt-0.5 tracking-widest">Berikan Alasan Penolakan</p>
                        </div>
                    </div>
                </div>

                <form :action="actionUrl" method="post" class="p-10">
                    <?= csrf_field() ?>
                    <div class="mb-8 p-5 bg-rose-50 rounded-2xl border border-rose-100 border-l-4 border-l-rose-500">
                        <label class="text-[9px] font-black text-rose-900 uppercase mb-1 block tracking-widest opacity-60">Dokumen Terkait</label>
                        <p class="text-sm font-black text-rose-900 leading-tight" x-text="docTitle"></p>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase px-1 tracking-[0.2em]">Alasan Penolakan <span class="text-rose-500">*</span></label>
                        <textarea name="note" rows="4" required class="w-full p-5 rounded-3xl bg-slate-50 border-none focus:ring-2 focus:ring-rose-600 focus:bg-white transition-all text-sm font-medium text-blue-900 placeholder:text-slate-300" placeholder="Sebutkan alasan mengapa permintaan ditolak..."></textarea>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" @click="showRejectModal = false" class="flex-1 py-4 text-[10px] font-black text-slate-400 hover:text-blue-900 transition-colors uppercase tracking-[0.2em]">Batal</button>
                        <button type="submit" class="flex-[2] bg-rose-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-rose-600/20 hover:bg-rose-700 transition-all">Konfirmasi Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

    <div class="mt-20 text-center pb-10">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">
            © <?= date('Y') ?> Kinetrack — Politeknik Negeri Bandung
        </p>
    </div>
</div>

<?= $this->endSection() ?>