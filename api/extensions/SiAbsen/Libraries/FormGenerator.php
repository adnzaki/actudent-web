<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;

class FormGenerator {

    public function CreateForm($data)
    {
        $sourcePDF = file_get_contents(BASE_URL('/siabsen/leave-request/template/download'));
		$pdf = new Fpdi();
		$pdf->AddPage();
		$pdf->setSourceFile(StreamReader::createByString($sourcePDF));
		$tplIdx = $pdf->importPage(1); 
		$pdf->useTemplate($tplIdx, true); 

        $pdf->SetFont('Arial','', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255,255,255);

        // Date Created
        $createdDate = date_create($data['created']);
        $createdDate = date_format($createdDate,"d F Y");
        $pdf->Text(148, 57.5, $createdDate);

        // Nama Pegawai
        $pdf->SetFont('Arial','', 8);
        $pdf->Text(52, 120, $data['staff_name']);

        // Jabatan
        $pdf->Text(52, 124, $data['staff_title']);

        // Unit Kerja
        $pdf->Text(52, 128, $data['school_name']);

        // NIG
        $pdf->Text(132, 120, $data['staff_nik']);

        // Masa Kerja
        $pdf->Text(132, 124, ucwords(strtolower($data['working_period'])));

        // Alasan
        if($this->GetLineCell($data['reason']) > 1){
            $data['reason'] = substr($data['reason'], 0, 255);
            $pdf->Text(22, 163, substr($data['reason'], 0, 135));
            $pdf->Text(22, 166, substr($data['reason'], 136, strlen($data['reason'])));
        } else {
            $pdf->Text(22, 163, $data['reason']);
        }

        // Lama Cuti
        $diff = date_create($data['end_date'])->diff(date_create($data['start_date']));
        $diff = $diff->d + 1;
        $pdf->Text(40, 180, $diff . ' Hari');

        // Start Date
        $pdf->Text(95, 180, date_format(date_create($data['start_date']), "d F Y"));

        // End Date
        $pdf->Text(144, 180, date_format(date_create($data['end_date']), "d F Y"));

        // Alamat
        $this->printAddress($pdf, 22, 195, $data['address']);

        // Alamat
        $pdf->Text(85, 195, $data['phone_number']);

        // Staff Name
        $staffName = '(   ' .$data['staff_name']. '   )';
        $pdf->Text($this->getXCordinate(140, $staffName), 212, $staffName);

        // NIG
        $pdf->Text(160, 217, $data['staff_nik']);

        // Jenis Cuti
        $pdf->SetFont('zapfdingbats','', 10);
        if($data['leave_type'] == 'TAHUNAN') {
            $pdf->Text(72, 143, '4');
        } else if($data['leave_type'] == 'SAKIT') {
            $pdf->Text(72, 147, '4');
        } else if($data['leave_type'] == 'MELAHIRKAN') {{
            $pdf->Text(72, 151, '4');
        }}

        // Status Cuti
        $pdf->SetFont('zapfdingbats','', 10);
        if($data['status'] == 'APPROVED') {
            $pdf->Text(42, 228, '4');
        } else if($data['status'] == 'REJECTED') {
            $pdf->Text(188, 228, '4');
        } 
        
        /* Export to PDF File */
        $fileName = "FormCuti_" .date_format(date_create($data['start_date']), 'Ymd')."_" .$data['staff_name']."_".time().".pdf";
		$pathFile = SIABSEN_PATH . 'Assets/Temp/'. $fileName;
        $pdf->Output('F', $pathFile);
        return $pathFile;
    }

    public function updateFormApproval($formPath, $status) {
        $sourcePDF = file_get_contents($formPath);
		$pdf = new Fpdi();
		$pdf->AddPage();
		$pdf->setSourceFile(StreamReader::createByString($sourcePDF));
		$tplIdx = $pdf->importPage(1); 
		$pdf->useTemplate($tplIdx, true); 

        // Status Cuti
        $pdf->SetFont('zapfdingbats','', 10);
        if($data['status'] == 'APPROVED') {
            $pdf->Text(42, 228, '4');
        } else if($data['status'] == 'REJECTED') {
            $pdf->Text(188, 228, '4');
        } 

        /* Export to PDF File */
		$pathFile = SIABSEN_PATH . 'Assets/'.time().'_approval.pdf';
        $pdf->Output('F', $pathFile);
        return $pathFile;
    }

    private function printAddress($pdf, $x, $y, $text){
        $maxText = 40;
        $line = round(strlen($text) / $maxText) + 1;
        for($i=0; $i < $line; $i++) {
            $pdf->Text($x, $y, substr($text, ($i*$maxText), $maxText));
            $y = $y + 3;
        }

    }

    private function GetLineCell($text) {
        if(strlen($text) > 135) {
            return 2;
        } else {
            return 1;
        }
    }

    private function getXCordinate($x, $text){
        $columnLength = 55 / 2;
        $strLength = strlen($text) / 2;
        $cordX = $x + ($columnLength - $strLength);
        return $cordX;
    }
}