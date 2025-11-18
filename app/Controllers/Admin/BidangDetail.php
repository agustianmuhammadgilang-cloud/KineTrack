<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\BidangDetailModel;

class BidangDetail extends BaseController
{
    public function index($id)
    {
        $bidangModel = new BidangModel();
        $detailModel = new BidangDetailModel();

        // data bidang
        $data['bidang'] = $bidangModel->find($id);

        // pegawai dalam bidang tersebut
        $pegawai = $detailModel->getPegawaiByBidang($id);

        // proses statistik tiap pegawai
        foreach ($pegawai as &$p) {
            $thisMonth = $detailModel->countLaporanBulanan($p['id']);
            $lastMonth = $detailModel->countLaporanBulanLalu($p['id']);

            $p['laporan_bulan_ini'] = $thisMonth;

            // progress %
            $p['progress'] = $thisMonth == 0 ? 0 : ($thisMonth / max($lastMonth, 1)) * 100;

            // status naik / turun
            if ($thisMonth > $lastMonth) {
                $p['status'] = 'Naik';
            } elseif ($thisMonth < $lastMonth) {
                $p['status'] = 'Turun';
            } else {
                $p['status'] = 'Stabil';
            }
        }

        // ranking (sort descending by laporan bulan ini)
        usort($pegawai, function($a, $b) {
            return $b['laporan_bulan_ini'] <=> $a['laporan_bulan_ini'];
        });

        // beri ranking ke masing² pegawai
        $rank = 1;
        foreach ($pegawai as &$p) {
            $p['ranking'] = $rank++;
        }

        $data['pegawai'] = $pegawai;

        return view('admin/bidang/detail', $data);
    }
}
