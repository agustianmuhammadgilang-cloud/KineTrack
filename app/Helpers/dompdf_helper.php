<?php

use Dompdf\Dompdf;

function pdf_create($html, $filename = '', $stream = true)
{
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    if ($stream) {
        $dompdf->stream($filename . ".pdf", ["Attachment" => false]);
        exit();
    }

    return $dompdf->output();
}
