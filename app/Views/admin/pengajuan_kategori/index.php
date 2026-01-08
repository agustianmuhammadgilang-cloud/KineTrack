<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="h-2 w-full flex">
        <div class="h-full w-1/2 bg-[#1D2F83]"></div>
        <div class="h-full w-1/2 bg-[#F58025]"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="py-8 animate-fade-in-down">
            <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">
                <span>Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                <span class="text-[#1D2F83]">Pengajuan Kategori</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-black text-[#1D2F83] tracking-tight uppercase">
                        Inbox <span class="text-[#F58025]">Pengajuan</span>
                    </h1>
                    <p class="text-gray-500 mt-1 font-medium italic">Tinjau dan validasi permohonan wadah dokumen baru dari staff.</p>
                </div>

                <div class="flex gap-2">
                    <div class="bg-amber-50 border border-amber-100 px-4 py-2 rounded-2xl flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="text-xs font-black text-amber-700 uppercase">Perlu Tindakan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="overflow-x-auto p-4">
                <table class="w-full border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-left text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Informasi Kategori</th>
                            <th class="px-6 py-4 text-center">Status Tracking</th>
                            <th class="px-6 py-4 text-right">Aksi Keputusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengajuan)): ?>
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-6 bg-gray-50 rounded-full mb-4 text-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0l-2 5H6l-2-5m16 0H4"/></svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-300">Belum Ada Pengajuan Baru</h4>
                                </div>
                            </td>
                        </tr>
                        <?php endif ?>

                        <?php foreach ($pengajuan as $i => $p): ?>
                        <tr class="group bg-white hover:bg-gray-50/50 transition-all border border-gray-100 shadow-sm">
                            <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-50 text-xs font-black text-gray-300 group-hover:text-[#1D2F83]">
                                <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>
                            </td>
                            
                            <td class="px-6 py-5 border-y border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-base font-bold text-gray-800 group-hover:text-[#1D2F83] transition-colors italic">
                                        <?= esc($p['nama_kategori']) ?>
                                    </span>
                                    <span class="text-xs text-gray-400 mt-1 line-clamp-1 italic">
                                        <?= esc($p['deskripsi']) ?: 'Tanpa catatan tambahan dari pengaju.' ?>
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-5 border-y border-gray-50">
                                <div class="flex justify-center">
                                    <?php
                                        $statusConfig = [
                                            'pending'       => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-100', 'icon' => 'M12 8v4l3 3'],
                                            'approved'      => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-100', 'icon' => 'M5 13l4 4L19 7'],
                                            'approved_auto' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'icon' => 'M5 13l4 4L19 7'],
                                            'rejected'      => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-100', 'icon' => 'M6 18L18 6M6 6l12 12']
                                        ];
                                        $cfg = $statusConfig[$p['status']] ?? $statusConfig['pending'];
                                    ?>
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider <?= $cfg['bg'] ?> <?= $cfg['text'] ?> border <?= $cfg['border'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="<?= $cfg['icon'] ?>"/>
                                        </svg>
                                        <?= ucfirst(str_replace('_', ' ', $p['status'])) ?>
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-5 rounded-r-2xl border-y border-r border-gray-50">
                                <div class="flex justify-end items-center gap-3">
                                    <?php if ($p['status'] == 'pending'): ?>
                                        <a href="<?= base_url('admin/pengajuan-kategori/approve/'.$p['id']) ?>"
                                           onclick="return confirm('Apakah Anda yakin menyetujui kategori ini?')"
                                           class="group/btn relative flex items-center gap-2 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white px-4 py-2 rounded-xl text-xs font-black transition-all active:scale-95 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            APPROVE
                                        </a>

                                        <a href="<?= base_url('admin/pengajuan-kategori/reject/'.$p['id']) ?>"
                                           onclick="return confirm('Tolak pengajuan kategori ini?')"
                                           class="flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-4 py-2 rounded-xl text-xs font-black transition-all active:scale-95 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            REJECT
                                        </a>
                                    <?php else: ?>
                                        <div class="flex items-center gap-2 text-gray-300 font-bold text-[10px] uppercase tracking-widest px-4 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Processed
                                        </div>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.6s ease-out; }
    
    /* Hover effect for rows to feel premium */
    tbody tr {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    tbody tr:hover {
        transform: scale(1.005);
        z-index: 10;
        position: relative;
    }
</style>

<?= $this->endSection() ?>