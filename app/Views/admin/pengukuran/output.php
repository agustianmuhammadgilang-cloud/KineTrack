<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --polban-blue: #003366;
        --polban-blue-light: #004a94;
        --polban-gold: #D4AF37;
        --slate-soft: #f8fafc;
        --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Table & Card Refinement */
    .glass-card {
        background: white;
        border: 1px solid #eef2f6;
        border-radius: 24px;
        box-shadow: 0 10px 25px -5px rgba(0, 51, 102, 0.04);
    }

    .table-polban thead {
        background-color: var(--polban-blue);
        border-bottom: 3px solid var(--polban-gold);
    }

    .row-sasaran {
        background-color: #fcfcfd;
        border-left: 4px solid var(--polban-blue);
    }

    /* Action Buttons */
    .btn-export {
        transition: var(--transition-smooth);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 11px;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Custom Select */
    .custom-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23003366'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
</style>

<div class="px-4 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm text-blue-900">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-black text-blue-900 tracking-tight">
                    Pengukuran <span class="text-slate-400 font-light">|</span> <span class="text-blue-600">Output Kinerja</span>
                </h4>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-[0.2em] mt-1">
                    Laporan Capaian Indikator Kinerja Utama (IKU)
                </p>
            </div>
        </div>

        <?php if (!empty($selected_tahun) && !empty($selected_tw)) : ?>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('admin/pengukuran/export/'.$selected_tahun.'/'.$selected_tw) ?>"
               class="btn-export flex items-center gap-2 px-5 py-3 bg-emerald-600 text-white rounded-xl font-bold transition-all hover:bg-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Excel
            </a>
            <a href="<?= base_url('admin/pengukuran/output/report/'.$selected_tahun.'/'.$selected_tw.'/view') ?>"
               target="_blank"
               class="btn-export flex items-center gap-2 px-5 py-3 bg-rose-600 text-white rounded-xl font-bold transition-all hover:bg-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0H13m-4 4h1.5m1.5 0H13m-4 4h1.5m1.5 0H13"/></svg>
                PDF
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="glass-card p-8 mb-8">
        <form method="get" action="<?= base_url('admin/pengukuran/output') ?>" class="flex flex-col lg:flex-row items-center gap-8">
            <div class="w-full lg:w-1/3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Tahun Anggaran</label>
                <select name="tahun_id" onchange="this.form.submit()"
                    class="custom-select w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-blue-900 font-bold focus:ring-2 focus:ring-blue-900 focus:border-transparent transition-all">
                    <?php foreach($tahun as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= ($selected_tahun == $t['id']) ? 'selected':'' ?>>
                            Tahun Operasional <?= $t['tahun'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w-full lg:w-2/3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1 text-center lg:text-left">Pilih Triwulan (Quarter)</label>
                <div class="grid grid-cols-4 gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <button type="submit" name="triwulan" value="<?= $i ?>"
                            class="py-3 text-xs font-black rounded-xl transition-all uppercase tracking-tighter
                            <?= ($selected_tw == $i)
                                ? 'bg-blue-900 text-white shadow-lg shadow-blue-900/20'
                                : 'text-slate-500 hover:bg-white hover:text-blue-900' ?>">
                            TW 0<?= $i ?>
                        </button>
                    <?php endfor; ?>
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($indikator)): ?>
<div class="glass-card overflow-hidden !border-none shadow-xl shadow-blue-900/5">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-polban">
            <thead>
                <tr class="text-white uppercase text-[10px] font-bold tracking-[0.2em]">
                    <th class="p-5">Sasaran Strategis</th>
                    <th class="p-5">Indikator Kinerja</th>
                    <th class="p-5 text-center">Target</th>
                    <th class="p-5 text-center">Detail</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                <?php
                $grouped = [];
                foreach ($indikator as $ind) {
                    $key = '[' . $ind['kode_sasaran'] . '] ' . $ind['nama_sasaran'];
                    $grouped[$key][] = $ind;
                }

                foreach ($grouped as $sasaran => $inds):
                    foreach ($inds as $idx => $ind):
                        $tw = $selected_tw;
                        $target = (!empty($ind["target_tw$tw"])) ? $ind["target_tw$tw"] : $ind["target_pk"];
                ?>
                <tr class="group hover:bg-blue-50/30 transition-colors">
                    <?php if ($idx == 0): ?>
                    <td rowspan="<?= count($inds) ?>" class="p-5 align-top font-bold text-blue-900 text-xs leading-relaxed w-1/4 bg-slate-50/50">
                        <div class="flex items-start gap-3">
                            <div class="w-1 h-6 bg-blue-900/20 rounded-full mt-1"></div>
                            <div class="flex-1"><?= esc($sasaran) ?></div>
                        </div>
                    </td>
                    <?php endif; ?>

                    <td class="p-5 border-none">
                        <div class="flex items-start gap-3">
                            <span class="inline-block px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-black rounded border border-blue-100 mt-0.5">
                                <?= $ind['kode_indikator'] ?>
                            </span>
                            <span class="text-sm font-medium text-slate-700 leading-relaxed"><?= esc($ind['nama_indikator']) ?></span>
                        </div>
                    </td>

                    <td class="p-5 text-center font-black text-blue-900 border-none">
                        <?= esc($target) ?>
                    </td>

                    <td class="p-5 text-center border-none">
                        <a href="<?= base_url('admin/pengukuran/output/detail/'.$ind['id'].'/'.$selected_tahun.'/'.$selected_tw) ?>"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-600 hover:bg-blue-900 hover:text-white transition-all active:scale-90">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </a>
                    </td>
                </tr>
                <?php endforeach; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php else: ?>
    <div class="glass-card p-20 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h5 class="text-slate-800 font-bold">Data Tidak Ditemukan</h5>
        <p class="text-slate-400 text-sm mt-1">Silakan pilih triwulan yang berbeda untuk melihat data.</p>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>