<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAnggaranModel;
use App\Models\SasaranModel;
use App\Models\IndikatorModel;
use App\Models\PengukuranModel;
use XLSXWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Pengukuran extends BaseController
{
    protected $tahunModel;
    protected $sasaranModel;
    protected $indikatorModel;
    protected $pengukuranModel;

    public function __construct()
    {
        $this->tahunModel       = new TahunAnggaranModel();
        $this->sasaranModel     = new SasaranModel();
        $this->indikatorModel   = new IndikatorModel();
        $this->pengukuranModel  = new PengukuranModel();
    }


    // ================================================================
    // PAGE: INPUT PENGUKURAN
    // ================================================================
    public function index()
    {
        $data['tahun'] = $this->tahunModel->orderBy('tahun', 'DESC')->findAll();
        return view('admin/pengukuran/index', $data);
    }


    // ================================================================
    // AJAX LOAD INDIKATOR
    // ================================================================
    public function load()
{
    $tahunId = $this->request->getPost('tahun_id');
    $tw      = (int)$this->request->getPost('triwulan');

    // Validasi dasar
    if (!$tahunId || !$tw) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Parameter tidak lengkap'
        ]);
    }

    // Ambil semua indikator berdasarkan tahun (tanpa triwulan!)
    $indikator = $this->indikatorModel
        ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->where('sasaran_strategis.tahun_id', $tahunId)
        ->orderBy('sasaran_strategis.id', 'ASC')
        ->orderBy('indikator_kinerja.id', 'ASC')
        ->findAll();

    return $this->response->setJSON([
        'status'  => true,
        'data'    => $indikator
    ]);
}




    // ================================================================
    // SIMPAN BULK INPUT
    // ================================================================
    // ================================================================
// SIMPAN BULK INPUT (ADMIN)
// ================================================================
public function store()
{
    $tahunId = $this->request->getPost('tahun_id');
    $tw      = (int)$this->request->getPost('triwulan');

    // Ambil semua indikator berdasarkan tahun
    $indikatorList = $this->indikatorModel
        ->select('indikator_kinerja.id')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->where('sasaran_strategis.tahun_id', $tahunId)
        ->findAll();

    if (empty($indikatorList)) {
        return redirect()->back()->with('error', 'Tidak ada indikator untuk tahun ini.');
    }

    $saveCount = 0;

    foreach ($indikatorList as $ind) {
        $id = $ind['id'];

        $dataSave = [
            'indikator_id' => $id,
            'tahun_id'     => $tahunId,
            'triwulan'     => $tw,
            'realisasi'    => (float)$this->request->getPost("realisasi_$id"),
            'kendala'      => trim($this->request->getPost("kendala_$id")),
            'strategi'     => trim($this->request->getPost("strategi_$id")),
            'data_dukung'  => trim($this->request->getPost("data_dukung_$id")),
            'created_by'   => session('user_id')
        ];

        // Upload File
        $files = $this->request->getFiles();
        $fileArr = [];

        if (!empty($files["file_$id"])) {
            foreach ($files["file_$id"] as $file) {

                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/pengukuran/', $newName);
                    $fileArr[] = $newName;
                }
            }
        }

        if (!empty($fileArr)) {
            $dataSave['file_dukung'] = json_encode($fileArr);
        }


        // Insert / Update
        $existing = $this->pengukuranModel
            ->where('indikator_id', $id)
            ->where('tahun_id', $tahunId)
            ->where('triwulan', $tw)
            ->first();

        if ($existing) {
            $this->pengukuranModel->update($existing['id'], $dataSave);
        } else {
            $this->pengukuranModel->insert($dataSave);
        }

        $saveCount++;
    }

    return redirect()->back()->with('success', "$saveCount data berhasil disimpan");
}



    // ================================================================
    // OUTPUT / READ ONLY
    // ================================================================
    public function output()
    {
        $tahunId = $this->request->getGet('tahun_id');
        $tw      = $this->request->getGet('triwulan');

        // Tahun hanya yang aktif!
        $data['tahun'] = $this->tahunModel
            ->where('status', 'active')
            ->orderBy('tahun', 'DESC')
            ->findAll();

        $data['selected_tahun'] = $tahunId;
        $data['selected_tw']    = $tw;

        if ($tahunId && $tw) {

            $data['indikator'] = $this->indikatorModel
    ->select('indikator_kinerja.*, sasaran_strategis.kode_sasaran, sasaran_strategis.nama_sasaran')
    ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
    ->where('sasaran_strategis.tahun_id', $tahunId)
    ->orderBy('sasaran_strategis.id')
    ->orderBy('indikator_kinerja.id')
    ->findAll();   // HAPUS where triwulan


            $existing = $this->pengukuranModel
                ->where('tahun_id', $tahunId)
                ->where('triwulan', $tw)
                ->findAll();

            $map = [];
            foreach ($existing as $e) {
                $map[$e['indikator_id']] = $e;
            }

            $data['pengukuran_map'] = $map;
        } else {
            $data['indikator'] = [];
            $data['pengukuran_map'] = [];
        }

        return view('admin/pengukuran/output', $data);
    }


// ================================================================
// DETAIL PENGUKURAN (ADMIN) FINAL
// ================================================================
public function detail($indikator_id, $tahun_id, $tw)
{
    // Load model lain yang diperlukan
    $tahunModel = new \App\Models\TahunAnggaranModel();

    // =============================
    // 1. Ambil indikator + sasaran
    // =============================
    $indikator = $this->indikatorModel
        ->select('indikator_kinerja.*, sasaran_strategis.nama_sasaran')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->where('indikator_kinerja.id', $indikator_id)
        ->first();

    if (!$indikator) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Indikator tidak ditemukan");
    }

    // =============================
    // 2. Ambil tahun dari tabel tahun_anggaran
    // =============================
    $tahunData = $tahunModel->find($tahun_id);
    $tahun = $tahunData ? $tahunData['tahun'] : '-';

    // =============================
    // 3. Ambil semua input pengukuran staff
    // =============================
    $pengukuran = $this->pengukuranModel
        ->select('pengukuran_kinerja.*, users.nama as user_nama')
        ->join('users', 'users.id = pengukuran_kinerja.user_id', 'left')
        ->where('pengukuran_kinerja.indikator_id', $indikator_id)
        ->where('pengukuran_kinerja.tahun_id', $tahun_id)
        ->where('pengukuran_kinerja.triwulan', $tw)  // pastikan kolom = triwulan
        ->orderBy('pengukuran_kinerja.created_at', 'DESC')
        ->findAll();

    // =============================
    // 4. Kirim ke view
    // =============================
    return view('admin/pengukuran/detail_output', [
        'indikator'  => $indikator,
        'pengukuran' => $pengukuran,
        'tahun'      => $tahun,
        'tw'         => $tw
    ]);
}






public function export($tahunId, $tw)
{
    // =============== 1. AMBIL DATA INDIKATOR ===============
    $indikator = $this->indikatorModel
        ->select('indikator_kinerja.*, 
                  sasaran_strategis.id as sasaran_id,
                  sasaran_strategis.kode_sasaran, 
                  sasaran_strategis.nama_sasaran')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->where('sasaran_strategis.tahun_id', $tahunId)
        ->orderBy('sasaran_strategis.id')
        ->orderBy('indikator_kinerja.id')
        ->findAll();

    if (empty($indikator)) {
        return $this->response->setJSON(['status'=>false,'message'=>'Tidak ada indikator untuk tahun/triwulan ini.']);
    }

    $indikatorIds = array_column($indikator, 'id');

    // =============== 2. DATA PENGUKURAN PER STAFF ===============
    $pengukuran = $this->pengukuranModel
        ->select('pengukuran_kinerja.*, users.nama as user_nama')
        ->join('users', 'users.id = pengukuran_kinerja.user_id', 'left')
        ->where('tahun_id', $tahunId)
        ->where('triwulan', $tw)
        ->whereIn('indikator_id', $indikatorIds)
        ->orderBy('indikator_id')
        ->orderBy('created_at')
        ->findAll();

    $mapPengukuran = [];
    foreach ($pengukuran as $p) {
        $mapPengukuran[$p['indikator_id']][] = $p;
    }

    // =============== 3. DATA PIC (nama + jabatan) ===============
    $db = \Config\Database::connect();
    $builder = $db->table('pic_indikator');
    $picRows = $builder
        ->select('pic_indikator.indikator_id, users.nama as pic_nama, jabatan.nama_jabatan as pic_jabatan')
        ->join('users','users.id = pic_indikator.user_id','left')
        ->join('jabatan','jabatan.id = pic_indikator.jabatan_id','left')
        ->whereIn('pic_indikator.indikator_id', $indikatorIds)
        ->get()
        ->getResultArray();

    $picMap = [];
    foreach ($picRows as $r) {
        $label = $r['pic_nama'];
        if (!empty($r['pic_jabatan'])) {
            $label .= " — " . $r['pic_jabatan'];
        }
        $picMap[$r['indikator_id']][] = $label;
    }

    foreach ($picMap as $k => $arr) {
        $picMap[$k] = implode("; ", array_unique($arr));
    }

    // =============== 4. MULAI XLSX ===============
    $writer = new XLSXWriter();
    $sheetName = "TW $tw";

    $header = [
        'Kode Sasaran'          => 'string',
        'Nama Sasaran'          => 'string',
        'Kode Indikator'        => 'string',
        'Nama Indikator'        => 'string',
        'PIC (Nama — Jabatan)'  => 'string',
        'Target'                => 'string',
        'Staff'                 => 'string',
        'Realisasi'             => 'string',
        'Progress / Kegiatan'   => 'string',
        'Kendala / Permasalahan'=> 'string',
        'Strategi / Tindak Lanjut'=> 'string',
        'File Dukung / Data Pendukung'=> 'string',
        'Tanggal Input'         => 'string'
    ];

    $headerStyle = [
        'font-style' => 'bold',
        'halign' => 'center',
        'widths' => [15,30,15,35,30,15,25,15,25,25,25,25,20]
    ];

    $writer->writeSheetHeader($sheetName, $header, $headerStyle);

    // =============== 5. LOOPING DENGAN GROUPING SASARAN ===============
    $lastSasaranId = null;

    foreach ($indikator as $ind) {

        $indId = $ind['id'];
        $sasId = $ind['sasaran_id'];

        $picLabel   = $picMap[$indId] ?? '-';
        $target     = (string)($ind['target_pk'] ?? '-');

        $staffPengukuran = $mapPengukuran[$indId] ?? [['user_nama'=>'-','realisasi'=>'-','progress'=>'-','kendala'=>'-','strategi'=>'-','file_dukung'=>'-','created_at'=>'-']];

        foreach ($staffPengukuran as $sp) {
            // Jika masih sasaran yang sama = kolom kosong
            if ($sasId === $lastSasaranId) {
                $kodeSasaran = '';
                $namaSasaran = '';
            } else {
                $kodeSasaran = $ind['kode_sasaran'];
                $namaSasaran = $ind['nama_sasaran'];
                $lastSasaranId = $sasId;
            }

            $row = [
                $kodeSasaran,
                $namaSasaran,
                $ind['kode_indikator'] ?? '-',
                $ind['nama_indikator'] ?? '-',
                $picLabel,
                $target,
                $sp['user_nama'] ?? '-',
                $sp['realisasi'] ?? '-',
                $sp['progress'] ?? '-',
                $sp['kendala'] ?? '-',
                $sp['strategi'] ?? '-',
                $sp['file_dukung'] ?? '-',
                $sp['created_at'] ?? '-'
            ];

            $writer->writeSheetRow($sheetName, $row);
        }
    }

    // =============== 6. OUTPUT FILE ===============
    $fileName = "Output_Pengukuran_Tahun{$tahunId}_TW{$tw}.xlsx";

    header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($fileName).'"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $writer->writeToStdOut();
    exit;
}



// ================================================================
// EDIT FORM
// ================================================================
public function edit($id)
{
    $data = $this->pengukuranModel
        ->select('pengukuran_kinerja.*, indikator_kinerja.nama_indikator')
        ->join('indikator_kinerja', 'indikator_kinerja.id = pengukuran_kinerja.indikator_id')
        ->where('pengukuran_kinerja.id', $id)
        ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    return view('admin/pengukuran/pengukuran_edit', ['data' => $data]);
}



// ================================================================
// UPDATE
// ================================================================
public function update($id)
{
    $row = $this->pengukuranModel->find($id);
    if (!$row) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $save = [
        'realisasi'    => $this->request->getPost('realisasi'),
        'progress'     => $this->request->getPost('progress'),  // << ini penting
        'kendala'      => $this->request->getPost('kendala'),
        'strategi'     => $this->request->getPost('strategi'),
        'updated_at'   => date('Y-m-d H:i:s'),                  // << auto update timestamp
    ];

    // File baru?
    $existingFiles = json_decode($row['file_dukung'], true) ?: [];

    $files = $this->request->getFiles();
    $newFiles = [];

    if (!empty($files["file_dukung"])) {
        foreach ($files["file_dukung"] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(FCPATH . 'uploads/pengukuran/', $name);
                $newFiles[] = $name;
            }
        }
    }

    if (!empty($newFiles)) {
        $save['file_dukung'] = json_encode(array_merge($existingFiles, $newFiles));
    }


    $this->pengukuranModel->update($id, $save);

    return redirect()->to(base_url('admin/pengukuran/output?tahun_id=' . $row['tahun_id'] . '&triwulan=' . $row['triwulan']))
        ->with('success', 'Data berhasil diupdate');
}



// ================================================================
// DELETE
// ================================================================
public function delete($id)
{
    $row = $this->pengukuranModel->find($id);
    if (!$row) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // Hapus file
    $files = json_decode($row['file_dukung'], true) ?: [];

    foreach ($files as $f) {
        $path = FCPATH . 'uploads/pengukuran/' . $f;
        if (file_exists($path)) unlink($path);
    }


    $this->pengukuranModel->delete($id);

    return redirect()->back()->with('success', 'Data berhasil dihapus');
}



// ================================================================
// EXPORT PDF PER DATA
// ================================================================
public function exportPdf($id)
{
    $data = $this->pengukuranModel
    ->select('pengukuran_kinerja.*, indikator_kinerja.nama_indikator, indikator_kinerja.kode_indikator, users.nama as user_nama')
    ->join('indikator_kinerja', 'indikator_kinerja.id = pengukuran_kinerja.indikator_id')
    ->join('users', 'users.id = pengukuran_kinerja.user_id', 'left')
    ->where('pengukuran_kinerja.id', $id)
    ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $html = view('admin/pengukuran/pengukuran_pdf', ['data' => $data]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("Pengukuran_{$data['id']}.pdf", ['Attachment' => true]);
}

public function report($tahunId, $tw)
{
    helper('dompdf');

    $tahun = $this->tahunModel->find($tahunId);
    if (!$tahun) {
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'title' => 'Data Tidak Ditemukan',
            'message' => 'Tahun tidak valid.'
        ]);
    }

    // QUERY FIX — gunakan tabel pengukuran_kinerja
    $data = $this->pengukuranModel
        ->select('
            pengukuran_kinerja.*,
            indikator_kinerja.nama_indikator, indikator_kinerja.satuan,
            indikator_kinerja.target_tw1, indikator_kinerja.target_tw2,
            indikator_kinerja.target_tw3, indikator_kinerja.target_tw4,
            sasaran_strategis.nama_sasaran,
            users.nama AS pic
        ')
        ->join('indikator_kinerja', 'indikator_kinerja.id = pengukuran_kinerja.indikator_id')
        ->join('sasaran_strategis', 'sasaran_strategis.id = indikator_kinerja.sasaran_id')
        ->join('users', 'users.id = pengukuran_kinerja.user_id')
        ->where('pengukuran_kinerja.tahun_id', $tahunId)
        ->where('pengukuran_kinerja.triwulan', $tw)
        ->orderBy('sasaran_strategis.nama_sasaran')
        ->findAll();

    $html = view('admin/pengukuran/report_pdf', [
        'tahun' => $tahun['tahun'],
        'tw'    => $tw,
        'data'  => $data
    ]);

    return pdf_create($html, "Laporan-Pengukuran-TW-$tw-{$tahun['tahun']}");
}

public function deleteFile($pengukuranId, $fileIndex)
{
    $record = $this->pengukuranModel->find($pengukuranId);

    if (!$record) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    $files = json_decode($record['file_dukung'], true);

    if (!isset($files[$fileIndex])) {
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    $filePath = WRITEPATH . 'uploads/pengukuran/' . $files[$fileIndex];

    // hapus file dari folder
    if (is_file($filePath)) {
        unlink($filePath);
    }

    // hapus dari array
    unset($files[$fileIndex]);

    // simpan kembali
    $this->pengukuranModel->update($pengukuranId, [
        'file_dukung' => json_encode(array_values($files))
    ]);

    return redirect()->back()->with('success', 'File berhasil dihapus.');
}

    
}