<?php

require_once APPPATH . 'ThirdParty/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use CodeIgniter\Controller;

class PDFCreator extends Controller
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
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        }
        else 
        {
            return $dompdf->output();
        }

        $this->response->setContentType('application/pdf');
    }
}