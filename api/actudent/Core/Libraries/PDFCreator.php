<?php

require_once APPPATH . 'ThirdParty/dompdf/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\Controller;

class PDFCreator extends Controller
{
    public function create($html, $filename = '', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        $options->setIsHtml5ParserEnabled(true);
        $options->set('isRemoteEnabled',true);
        $dompdf = new Dompdf($options);
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