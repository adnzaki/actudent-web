<?php namespace Actudent\Core\Libraries\Tcpdf;

// require_once 'Config.php';
require APPPATH . 'ThirdParty/tcpdf/tcpdf.php';

use TCPDF;

class Pdf
{
    private $author;

    private $title;

    private $subject;

    private $keywords;

    public function __construct($author = 'Actudent', $title = 'Actudent Report', $subject = 'No subject', $keywords = 'Actudent, absensi, aplikasi, laporan, pdf')
    {
        $this->author = $author;
        $this->title = $title;
        $this->subject = $subject;
        $this->keywords = $keywords;
    }

    public function run()
    {
        $pdf = new TCPDF();

        // set document information
        //$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->author);
        $pdf->SetTitle($this->title);
        $pdf->SetSubject($this->subject);
        $pdf->SetKeywords($this->keywords);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // // set auto page breaks
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // // set image scale factor
        // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        $html = '<h1>Welcome to Actudent Report!</h1>';

        // Print text using writeHTMLCell()
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->writeHTMLCell(0, 0, '', '', $html);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('Actudent_report.pdf', 'I');
    }
}