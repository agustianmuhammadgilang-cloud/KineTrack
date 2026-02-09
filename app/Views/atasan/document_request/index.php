<?= $this->extend('layout/atasan_template') ?>
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

    /* Navigasi Aktif dengan Aksen Gold */
    .nav-link-active {
        background-color: var(--polban-blue);
        color: white !important;
        box-shadow: 0 10px 20px -5px rgba(29, 47, 131, 0.25);
        border-bottom: 3px solid var(--polban-gold);
    }

    .doc-card {
        background: white;
        border-radius: 32px;
        border: 1px solid #eef2f6;
        transition: var(--transition-smooth);
        box-shadow: 0 10px 30px -12px rgba(0, 51, 102, 0.05);
    }

    .doc-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px -12px rgba(0, 51, 102, 0.12);
        border-color: rgba(29, 47, 131, 0.1);
    }

    .btn-polban {
        transition: all 0.25s ease-out;
        background: var(--polban-blue);
        color: white !important;
    }

    .btn-polban:hover {
        background-color: var(--polban-blue-light);
        box-shadow: 0 4px 12px rgba(29, 47, 131, 0.2);
        outline: none;
    }

    .btn-polban:active {
        transform: scale(0.98);
    }

    .input-premium {
        transition: var(--transition-smooth);
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
    }

    .input-premium:focus {
        background-color: white;
        border-color: var(--polban-blue);
        box-shadow: 0 0 0 4px rgba(29, 47, 131, 0.05);
        outline: none;
    }

    [x-cloak] { display: none !important; }
</style>

<div class="px-6 py-10 max-w-7xl mx-auto min-h-screen" 
    x-data="{
        showModal: false,
        hasAttachment: false,
        fileName: '',
        form: { document_id: '', judul: '', unit: '', owner_id: '', nama_pemilik: '' },
        handleFile(e) { this.fileName = e.target.files[0] ? e.target.files[0].name : ''; },
        resetForm() { 
            this.showModal = false; 
            setTimeout(() => {
                this.hasAttachment = false; 
                this.fileName = ''; 
            }, 300);
        }
    }">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <div>
                <h4 class="text-3xl font-black text-blue-900 tracking-tight">E-Katalog <span class="text-blue-600">Dokumen</span></h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">Kinetrack — Panel Eksklusif Atasan</p>
            </div>
        </div>

        <div class="flex bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/50 backdrop-blur-sm overflow-x-auto">
            <a href="<?= site_url('atasan/document-request') ?>" class="nav-link-active px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari Dokumen
            </a>
            
            <a href="<?= site_url('atasan/document-request/my-status') ?>" 
               class="relative text-slate-500 hover:text-blue-900 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Status Saya
                <?php if (!empty($badgeStatus)): ?>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full">
                        <?= $badgeStatus ?>
                    </span>
                <?php endif; ?>
            </a>
        </div> 
    </div>

    <section>
        <form method="get" class="max-w-3xl mb-14 relative group">
            <input type="text" name="search" placeholder="Cari berdasarkan judul, nomor dokumen, atau kata kunci..." 
                class="input-premium w-full pl-16 pr-44 py-5 rounded-[2rem] shadow-sm text-blue-900 font-medium"
                value="<?= esc(service('request')->getGet('search')) ?>">
            
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-900 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>

            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 btn-polban px-7 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em]">
                Temukan
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (empty($documents)): ?>
                <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" /></svg>
                    </div>
                    <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">Data Dokumen Tidak Ditemukan</p>
                </div>
            <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                    <div class="doc-card p-8 flex flex-col relative overflow-hidden group">
                        <div class="absolute top-0 right-0">
                            <div class="bg-amber-100 text-amber-700 text-[8px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest border-l border-b border-amber-200/50">
                                Restricted
                            </div>
                        </div>

                        <div class="w-14 h-14 bg-blue-50 text-blue-900 rounded-2xl flex items-center justify-center border border-blue-100 mb-6 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-500 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        
                        <h6 class="font-black text-blue-900 mb-6 text-lg leading-tight line-clamp-2 min-h-[3.5rem] tracking-tight">
                            <?= esc($doc['judul']) ?>
                        </h6>

                        <div class="space-y-5 pt-6 border-t border-slate-100 mt-auto">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200 shadow-sm">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pemilik Dokumen</p>
                                    <p class="text-xs font-bold text-slate-700"><?= esc($doc['nama_pemilik']) ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200 shadow-sm">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Unit Kerja</p>
                                    <p class="text-xs font-bold text-slate-700"><?= esc($doc['nama_unit'] ?? 'Unit Umum') ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200 shadow-sm">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Dibuat Pada</p>
                                    <p class="text-xs font-bold text-blue-900/70"><?= date('d F Y', strtotime($doc['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <?php
                        $docId  = $doc['id'];
                        $status = $requestStatus[$docId] ?? null;
                        ?>

                        <?php if ($doc['created_by'] == session('user_id')): ?>
                            <div class="mt-8 w-full py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-100 rounded-2xl">
                                Dokumen Anda
                            </div>
                        <?php elseif ($status === 'pending'): ?>
                            <button disabled class="mt-8 w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-slate-200 text-slate-400 cursor-not-allowed">
                                Menunggu Persetujuan
                            </button>
                        <?php elseif ($status === 'approved'): ?>
                            <div class="mt-8 w-full py-4 text-center text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700 rounded-2xl">
                                Sudah Memiliki Akses
                            </div>
                        <?php else: ?>
                            <button @click="
                                showModal = true;
                                form.document_id = '<?= $doc['id'] ?>';
                                form.judul = '<?= esc($doc['judul'], 'js') ?>';
                                form.nama_pemilik = '<?= esc($doc['nama_pemilik'], 'js') ?>';
                                form.unit = '<?= esc($doc['nama_unit'] ?? 'Unit Umum', 'js') ?>';
                                form.owner_id = '<?= $doc['created_by'] ?>';
                            " class="btn-polban mt-8 w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-blue-900/10">
                                <?= $status === 'rejected' ? 'Ajukan Ulang' : 'Ajukan Akses' ?>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <template x-teleport="body">
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="resetForm()" class="fixed inset-0 bg-blue-950/60 backdrop-blur-sm"></div>
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-blue-900 p-8 text-white relative">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20 shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-black uppercase tracking-[0.2em]">Form Pengajuan</h5>
                                <p class="text-blue-300 text-[9px] uppercase font-bold mt-0.5 tracking-widest">Request Access Control</p>
                            </div>
                        </div>
                        <button @click="resetForm()" class="w-10 h-10 rounded-full bg-black/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>

                <form action="<?= site_url('atasan/document-request/store') ?>" method="post" enctype="multipart/form-data" class="p-10">
    <?= csrf_field() ?>
    <input type="hidden" name="document_id" :value="form.document_id">
    <input type="hidden" name="owner_id" :value="form.owner_id">

                    <div class="space-y-8">
                        <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100 border-l-4 border-l-amber-500">
                            <label class="text-[9px] font-black text-blue-900 uppercase mb-2 block tracking-widest opacity-60">Target Dokumen</label>
                            <p class="text-base font-black text-blue-900 leading-tight" x-text="form.judul"></p>
                            <div class="flex gap-4 mt-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    <span class="text-[10px] text-blue-900/70 font-black uppercase tracking-tighter" x-text="form.nama_pemilik"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                    <span class="text-[10px] text-blue-900/70 font-black uppercase tracking-tighter" x-text="form.unit"></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase px-1 tracking-[0.2em]">Alasan Mengakses <span class="text-rose-500">*</span></label>
                            <textarea name="reason" rows="3" required class="input-premium w-full p-5 rounded-3xl text-sm font-medium text-blue-900 placeholder:text-slate-300" placeholder="Jelaskan keperluan Anda secara profesional..."></textarea>
                        </div>

                        <div class="pt-2">
                            <div class="flex items-center justify-between mb-5 px-1">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase block tracking-[0.2em]">Lampiran Pendukung</label>
                                    <p class="text-[9px] text-slate-400 font-bold mt-1">Surat tugas atau bukti pendukung lainnya</p>
                                </div>
                                <button type="button" @click="hasAttachment = !hasAttachment; if(!hasAttachment) fileName = ''" :class="hasAttachment ? 'bg-blue-900 shadow-blue-200' : 'bg-slate-200'" class="relative inline-flex h-7 w-12 items-center rounded-full transition-all duration-300 shadow-inner">
                                    <span :class="hasAttachment ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-5 w-5 transform rounded-full bg-white transition-transform shadow-md"></span>
                                </button>
                            </div>

                            <div x-show="hasAttachment" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                <div class="relative group">
                                    <input type="file" name="attachment" @change="handleFile" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 opacity-0 cursor-pointer z-10" :required="hasAttachment">
                                    <div class="input-premium w-full p-8 rounded-[2rem] text-center flex flex-col items-center border-dashed border-2" :class="fileName ? 'border-blue-900 bg-blue-50/50' : 'border-slate-200'">
                                        <template x-if="!fileName">
                                            <div class="flex flex-col items-center">
                                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mb-3 text-slate-400 shadow-sm border border-slate-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                                </div>
                                                <span class="text-[11px] text-slate-500 font-black uppercase tracking-widest">Pilih Berkas</span>
                                            </div>
                                        </template>
                                        <template x-if="fileName">
                                            <div class="flex flex-col items-center">
                                                <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center mb-3 shadow-lg">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" /></svg>
                                                </div>
                                                <span class="text-xs text-blue-900 font-black px-4 line-clamp-1" x-text="fileName"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex gap-4">
                        <button type="button" @click="resetForm()" class="flex-1 py-4 text-[10px] font-black text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-[0.2em]">Batal</button>
                        <button type="submit" class="flex-[2] btn-polban py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
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