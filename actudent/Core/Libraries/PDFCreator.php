<?php

require_once APPPATH . 'ThirdParty/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;

class PDFCreator
{
    public function create($html, $filename = '', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if($stream) 
        {
            $dompdf->stream($filename.".pdf", array("Attachment" => 1));
        }
        else 
        {
            return $dompdf->output();
        }
    }
}