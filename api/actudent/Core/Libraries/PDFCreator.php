<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFCreator
{
    public static function create($html, $filename = '', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        header('Content-type: application/pdf');

        $options = new Options();
        // $options->setIsHtml5ParserEnabled(true);
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if($stream) 
        {
            $dompdf->stream($filename, array("Attachment" => 1));
        }
        else 
        {
            return $dompdf->output();
        }      
    }
}