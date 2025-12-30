<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\KategoriDokumenModel;
use App\Models\BidangModel;
// Controller untuk mengelola dokumen tervalidasi
class DokumenTervalidasi extends BaseController
{
    protected $dokumenModel;
    protected $kategoriModel;
    protected $bidangModel;

    public function __construct()
    {
        $this->dokumenModel  = new DokumenModel();
        $this->kategoriModel = new KategoriDokumenModel();
        $this->bidangModel   = new BidangModel();
    }

    /**
     * ================================
     * LEVEL 1 — LIST SEMUA KATEGORI
     * ================================
     */
    public function kategori()
    {
        $kategori = $this->kategoriModel
            ->select('kategori_dokumen.*, COUNT(dk.id) as total')
            ->join(
                'dokumen_kinerja dk',
                'dk.kategori_id = kategori_dokumen.id',
                'left'
            )
            ->where('kategori_dokumen.status', 'aktif')
            ->groupBy('kategori_dokumen.id')
            ->orderBy('kategori_dokumen.nama_kategori', 'ASC')
            ->findAll();

        return view('admin/dokumen_tervalidasi/kategori', [
            'title'    => 'Dokumen Tervalidasi',
            'kategori' => $kategori
        ]);
    }

    /**
     * ================================
     * LEVEL 2 — DOKUMEN PER KATEGORI
     * ================================
     */
    public function dokumen($kategoriId)
    {
        $kategori = $this->kategoriModel->find($kategoriId);
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Kategori tidak ditemukan'
            );
        }

        $bidangId = $this->request->getGet('bidang');
        $keyword  = $this->request->getGet('q');

        $builder = $this->dokumenModel
            ->select('dk.id, dk.judul, dk.file_path, dk.updated_at, b.nama_bidang')
            ->from('dokumen_kinerja dk')
            ->join('bidang b', 'b.id = dk.unit_asal_id', 'left')
            ->where('dk.kategori_id', $kategoriId)
            ->where('dk.status', 'archived')
            ->groupBy('dk.id') // 🔥 ANTI DUPLIKAT
            ->orderBy('dk.updated_at', 'DESC');

        if ($bidangId) {
            $builder->where('dk.unit_asal_id', $bidangId);
        }

        if ($keyword) {
            $builder->like('dk.judul', $keyword);
        }

        return view('admin/dokumen_tervalidasi/dokumen', [
            'title'        => 'Dokumen ' . $kategori['nama_kategori'],
            'kategori'     => $kategori,
            'dokumen'      => $builder->findAll(),
            'bidang'       => $this->bidangModel->findAll(),
            'kategoriList' => $this->kategoriModel
                                    ->where('status', 'aktif')
                                    ->orderBy('nama_kategori', 'ASC')
                                    ->findAll()
        ]);
    }

    /**
     * ================================
     * UPDATE KATEGORI DOKUMEN (ADMIN)
     * ================================
     */
    public function updateKategori($dokumenId)
{
    $dokumen = $this->dokumenModel->find($dokumenId);
    if (!$dokumen) {
        return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
    }

    $kategoriLama = $this->kategoriModel->find($dokumen['kategori_id']);

    $kategoriIdBaru = $this->request->getPost('kategori_id');
    $kategoriBaru   = $this->kategoriModel->find($kategoriIdBaru);

    if (!$kategoriBaru) {
        return redirect()->back()->with('error', 'Kategori tidak valid');
    }

    // 🔒 Optional: cegah update sia-sia
    if ($dokumen['kategori_id'] == $kategoriIdBaru) {
        return redirect()->back()->with('info', 'Dokumen sudah berada di kategori tersebut');
    }

    // UPDATE KATEGORI
    $this->dokumenModel->update($dokumenId, [
        'kategori_id' => $kategoriIdBaru
    ]);

    // ✅ LOG AKTIVITAS (KRITIKAL)
    log_activity(
        'update_dokumen_kategori',
        'Memindahkan dokumen "' . $dokumen['judul'] . 
        '" dari kategori "' . ($kategoriLama['nama_kategori'] ?? '-') . 
        '" ke "' . $kategoriBaru['nama_kategori'] . '"',
        'dokumen_kinerja',
        $dokumenId
    );

    return redirect()->back()->with(
        'success',
        'Kategori dokumen berhasil diperbarui'
    );
}

}
