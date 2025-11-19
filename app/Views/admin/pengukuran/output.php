<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<h3>Pengukuran Kinerja (Output)</h3>

<div class="card p-3 mb-3">
    <form method="get" action="<?= base_url('admin/pengukuran/output') ?>">
        <div class="row">
            <div class="col-md-4">
                <select name="tahun_id" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    <?php foreach($tahun as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= ($selected_tahun == $t['id']) ? 'selected':'' ?>>
                            <?= $t['tahun'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <select name="triwulan" class="form-control">
                    <option value="">-- Pilih Triwulan --</option>
                    <?php for($i=1;$i<=4;$i++): ?>
                        <option value="<?= $i ?>" <?= ($selected_tw == $i) ? 'selected':'' ?>>
                            TW <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-polban">Tampilkan</button>
            </div>
        </div>
    </form>
</div>

<?php if(!empty($indikator)): ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sasaran</th>
            <th>Indikator</th>
            <th>Satuan</th>
            <th>Target (TW)</th>
            <th>Realisasi</th>
            <th>Progress</th>
            <th>Kendala</th>
            <th>Strategi</th>
            <th>Data Dukung</th>
            <th>File</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($indikator as $ind): ?>

            <?php 
                $p = $pengukuran_map[$ind['id']] ?? null;
                $tw = $selected_tw;

                // target triwulan atau fallback PK
                $target = ($ind["target_tw$tw"] !== null && $ind["target_tw$tw"] !== '')
                    ? $ind["target_tw$tw"]
                    : $ind["target_pk"];
            ?>

            <tr>
                <td><?= esc($ind['nama_sasaran']) ?></td>

                <td>
                    <?= $ind['kode_indikator'] ? '['.$ind['kode_indikator'].'] ' : '' ?>
                    <?= esc($ind['nama_indikator']) ?>
                </td>

                <td><?= esc($ind['satuan'] ?? '-') ?></td>

                <td><?= esc($target) ?></td>

                <td><?= esc($p['realisasi'] ?? '-') ?></td>

                <td><?= isset($p['progress']) ? esc($p['progress']).'%' : '-' ?></td>

                <td><?= esc($p['kendala'] ?? '-') ?></td>

                <td><?= esc($p['strategi'] ?? '-') ?></td>

                <td><?= esc($p['data_dukung'] ?? '-') ?></td>

                <td>
                    <?php if (!empty($p['file_dukung'])): ?>
                        <a href="<?= base_url('uploads/pengukuran/'.$p['file_dukung']) ?>" 
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat File
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="mt-3">
    <a href="<?= base_url('admin/pengukuran/export/'.$selected_tahun.'/'.$selected_tw) ?>" 
       class="btn btn-outline-secondary">
       Export
    </a>
</div>

<?php else: ?>

<div class="alert alert-info">
    Pilih Tahun & Triwulan terlebih dahulu untuk menampilkan data.
</div>

<?php endif; ?>

<?= $this->endSection() ?>
