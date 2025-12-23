<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\KategoriDokumenModel;
use App\Models\BidangModel;

class DokumenTidakTervalidasi extends BaseController
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
     * LEVEL 1 — KATEGORI BELUM DIVALIDASI
     * ================================
     */
public function kategori()
{
    $kategori = $this->kategoriModel
        ->select('kategori_dokumen.*, COUNT(dk.id) as total')
        ->join(
            'dokumen_kinerja dk',
            'dk.kategori_id = kategori_dokumen.id AND dk.status = "archived"',
            'left'
        )
        ->whereIn('kategori_dokumen.status', ['pending', 'rejected'])
        ->groupBy('kategori_dokumen.id')
        ->orderBy('kategori_dokumen.nama_kategori', 'ASC')
        ->findAll();

    return view('admin/dokumen_tidak_tervalidasi/kategori', [
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

        if (!$kategori || $kategori['status'] !== 'pending') {
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
            ->groupBy('dk.id')
            ->orderBy('dk.updated_at', 'DESC');

        if ($bidangId) {
            $builder->where('dk.unit_asal_id', $bidangId);
        }

        if ($keyword) {
            $builder->like('dk.judul', $keyword);
        }

        return view('admin/dokumen_tidak_tervalidasi/dokumen', [
            'title'        => 'Dokumen Tidak Tervalidasi',
            'kategori'     => $kategori,
            'dokumen'      => $builder->findAll(),
            'bidang'       => $this->bidangModel->findAll()
        ]);
    }
}
