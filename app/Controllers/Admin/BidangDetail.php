<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\UserModel;
use App\Models\LaporanModel;
// Controller untuk menampilkan detail bidang dan pegawai di dalamnya
class BidangDetail extends BaseController
{
    protected $bidangModel;
    protected $userModel;
    protected $lapModel;

    public function __construct()
    {
        $this->bidangModel = new BidangModel();
        $this->userModel   = new UserModel();
        $this->lapModel    = new LaporanModel();
    }

    /**
     * Index: detail bidang + card pegawai (level 1)
     */
    public function index($bidangId)
    {
        $data['bidang'] = $this->bidangModel->find($bidangId);

        // cari atasan bidang (role = atasan) — ambil first
        $atasan = $this->userModel->where('bidang_id', $bidangId)
                                  ->where('role', 'atasan')
                                  ->first();
        $data['atasan'] = $atasan;

        // ambil semua pegawai (role=staff) di bidang
        $pegawai = $this->userModel
            ->select('users.*, jabatan.nama_jabatan')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->where('users.bidang_id', $bidangId)
            ->where('users.role', 'staff')
            ->findAll();

        // proses statistik per pegawai (bulan ini)
        $thisMonth = date('m');
        $thisYear  = date('Y');

        $items = [];
        foreach ($pegawai as $p) {
            // ambil laporan bulan ini
            $laps = $this->lapModel
                ->where('user_id', $p['id'])
                ->where('MONTH(tanggal)', $thisMonth)
                ->where('YEAR(tanggal)', $thisYear)
                ->findAll();

            $totalAll = count($laps);
            $approved = 0;
            $rejected = 0;
            $hours = 0; // total durasi jika ada

            foreach ($laps as $l) {
                if (isset($l['status']) && $l['status'] === 'approved') $approved++;
                if (isset($l['status']) && $l['status'] === 'rejected') $rejected++;
                // durasi: jika ada kolom 'durasi' (dalam menit)
                if (isset($l['durasi'])) {
                    $hours += (int) $l['durasi'];
                }
            }

            // progress = percent approved dari total submitted (0..100)
            $progress = ($totalAll > 0) ? round(($approved / $totalAll) * 100, 1) : 0;

            // bandingkan terhadap bulan lalu untuk status naik/turun
            // bulan lalu compute
            $lastMonth = (int)date('m') - 1;
            $lastYear = (int)date('Y');
            if ($lastMonth === 0) { $lastMonth = 12; $lastYear -= 1; }

            $lapsLast = $this->lapModel
                ->where('user_id', $p['id'])
                ->where('MONTH(tanggal)', $lastMonth)
                ->where('YEAR(tanggal)', $lastYear)
                ->findAll();
            $approvedLast = 0;
            foreach ($lapsLast as $ll) {
                if (isset($ll['status']) && $ll['status'] === 'approved') $approvedLast++;
            }

            if ($approved > $approvedLast) $status = 'Naik';
            elseif ($approved < $approvedLast) $status = 'Turun';
            else $status = 'Stabil';

            $items[] = [
                'id' => $p['id'],
                'nama' => $p['nama'],
                'jabatan' => $p['nama_jabatan'] ?? '',
                'total_laporan' => $totalAll,
                'approved' => $approved,
                'rejected' => $rejected,
                'progress' => $progress,
                'hours' => $hours, // in minutes (convert in view)
                'status' => $status
            ];
        }

        // ranking sort by progress desc then approved
        usort($items, function($a, $b) {
            if ($b['progress'] == $a['progress']) {
                return $b['approved'] <=> $a['approved'];
            }
            return $b['progress'] <=> $a['progress'];
        });

        // attach ranking
        $rank = 1;
        foreach ($items as &$it) {
            $it['ranking'] = $rank++;
        }

        $data['pegawai'] = $items;

        return view('admin/bidang/detail', $data);
    }

    /**
     * Level 2: detail pegawai
     */
    public function pegawaiDetail($pegawaiId)
    {
        $user = $this->userModel
            ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
            ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->find($pegawaiId);

        if (!$user) {
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan');
        }

        // laporan bulan ini
        $bulan = date('m');
        $tahun = date('Y');
        $laporan = $this->lapModel
            ->where('user_id', $pegawaiId)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // statistik
        $approved = 0; $rejected = 0; $hours = 0;
        foreach ($laporan as $l) {
            if (isset($l['status']) && $l['status'] === 'approved') $approved++;
            if (isset($l['status']) && $l['status'] === 'rejected') $rejected++;
            if (isset($l['durasi'])) $hours += (int)$l['durasi'];
        }
        $progress = ($approved + $rejected) > 0 ? round(($approved / max(($approved+$rejected),1)) * 100,1) : 0;

        $data = [
            'pegawai' => $user,
            'laporan' => $laporan,
            'approved' => $approved,
            'rejected' => $rejected,
            'progress' => $progress,
            'hours' => $hours // minutes
        ];

        return view('admin/bidang/pegawai_detail', $data);
    }

    /**
     * Export PDF per pegawai
     */
    public function exportPegawai($pegawaiId)
{
    // ambil data user lengkap dengan jabatan & bidang
    $user = $this->userModel
        ->select('users.*, jabatan.nama_jabatan, bidang.nama_bidang')
        ->join('jabatan', 'jabatan.id = users.jabatan_id', 'left')
        ->join('bidang', 'bidang.id = users.bidang_id', 'left')
        ->find($pegawaiId);

    if (!$user) return redirect()->back()->with('error', 'Pegawai tidak ditemukan');

    $laporan = $this->lapModel
        ->where('user_id', $pegawaiId)
        ->orderBy('tanggal', 'DESC')
        ->findAll();

    $html = view('admin/bidang/export_pegawai', [
        'pegawai' => $user,
        'laporan' => $laporan
    ]);

    // generate pdf (pastikan dompdf sudah terpasang)
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html);
    $dompdf->render();

    return $dompdf->stream("Kinerja-".$user['nama'].".pdf", ["Attachment" => false]);
}

    public function exportBidang($bidangId)
{
    $bidangModel = new \App\Models\BidangModel();
    $userModel = new \App\Models\UserModel();
    $laporanModel = new \App\Models\LaporanModel();
    $jabatanModel = new \App\Models\JabatanModel();

    // Ambil data bidang
    $bidang = $bidangModel->find($bidangId);
    if (!$bidang) {
        return redirect()->back()->with('error', 'Bidang tidak ditemukan.');
    }

    // Ambil semua pegawai role=staff di bidang (safe)
    $pegawaiRecords = $userModel
        ->where('bidang_id', $bidangId)
        ->where('role', 'staff')
        ->findAll();

    // Kalau tidak ada pegawai, buat PDF minimal
    if (empty($pegawaiRecords)) {
        $data = [
            'bidang' => $bidang,
            'pegawai' => []
        ];

        $html = view('admin/bidang/export_bidang', $data);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();
        return $dompdf->stream("Rekap-Bidang-{$bidang['nama_bidang']}.pdf", ["Attachment" => true]);
    }

    // Siapkan array pegawai yang diisi statistik aman
    $items = [];
    foreach ($pegawaiRecords as $p) {
        // aman ambil nama jabatan
        $jab = null;
        if (!empty($p['jabatan_id'])) {
            $j = $jabatanModel->find($p['jabatan_id']);
            $jab = $j['nama_jabatan'] ?? '-';
        } else {
            $jab = '-';
        }

        $total = (int) $laporanModel->where('user_id', $p['id'])->countAllResults();
        $approved = (int) $laporanModel->where('user_id', $p['id'])->where('status', 'approved')->countAllResults();
        $rejected = (int) $laporanModel->where('user_id', $p['id'])->where('status', 'rejected')->countAllResults();

        $progress = $total > 0 ? round(($approved / $total) * 100, 1) : 0;

        $items[] = [
            'id' => $p['id'],
            'nama' => $p['nama'],
            'jabatan' => $jab,
            'laporan_total' => $total,
            'approved' => $approved,
            'rejected' => $rejected,
            'progress' => $progress
        ];
    }

    // sort by progress desc then approved desc
    usort($items, function($a, $b){
        if ($b['progress'] == $a['progress']) {
            return $b['approved'] <=> $a['approved'];
        }
        return $b['progress'] <=> $a['progress'];
    });

    $data = [
        'bidang' => $bidang,
        'pegawai' => $items,
        // ringkasan bidang
        'total_pegawai' => count($items),
        'total_laporan' => array_sum(array_column($items, 'laporan_total')),
        'total_approved' => array_sum(array_column($items, 'approved')),
        'total_rejected' => array_sum(array_column($items, 'rejected')),
    ];


    
    // render view -> pdf
    $html = view('admin/bidang/export_bidang', $data);
    
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html);
    $dompdf->render();
    return $dompdf->stream("Rekap-Bidang-{$bidang['nama_bidang']}.pdf", ["Attachment" => true]);
}


    public function select()
{
    $bidang = new BidangModel();
    
    $data['bidang'] = $bidang->findAll();

    return view('admin/bidang/select', $data);
}

}
