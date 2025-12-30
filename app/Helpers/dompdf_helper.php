<?php

use Dompdf\Dompdf;

// Helper untuk membuat PDF dari HTML menggunakan Dompdf
function pdf_create($html, $filename = '', $stream = true)
{
    // Inisialisasi Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Stream atau simpan file
    if ($stream) {
        $dompdf->stream($filename . ".pdf", ["Attachment" => false]);
        exit();
    }

    return $dompdf->output();
}
