<?php
session_start();
include("../../plugins/PHPExcel/PHPExcel.php");
include("../../plugins/PHPExcel/PHPExcel/IOFactory.php");

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

$inputFileType = 'Excel5';
$inputFileName = 'template/datawarga.xls';
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

include_once "../../sqlLib.php";  $sqlLib = new sqlLib();
//include_once "../../sqlLib_pro.php";  $sqlLibPro = new sqlLibPro();  //server 10.11.13.127

$objPHPExcel->setActiveSheetIndex(0);
$outputFileName = 'Data Warga RT 02.xls';

    $bordercenter = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 8,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));
    
    $borderleft = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 8,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));
    
    
    $borderright = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 8,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));
    
    
    $center = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 11,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));
    
    $left = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 11,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));
    
    
    $right = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 11,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    ),
    'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ));


//$objPHPExcel->getActiveSheet()->setCellValue('A3', 'TAHUN '.$_GET["tahun"] ); 

$no=1;
$baris =8;
//saldo awal
$sql = "SELECT a.SeqWarga, a.Blok, a.No, a.Nama, a.NoKTP,a.Pekerjaan, a.Agama, a.JenisKelamin, a.HubunganKeluarga, a.TanggalLahir, concat('GRAND SUTERA ',a.Blok,'/',a.No) as BlokNo 
        FROM ms_warga a 
        WHERE a.Nama != ''  ";
//$sql.="WHERE YEAR(Tbl.Tanggal)='".$_GET['tahun']."'  AND Tbl.Keterangan ='Saldo Awal' ";										
$sql.="ORDER BY a.Blok ASC, a.No ASC, a.UrutKel ASC";		
$data = $sqlLib->select($sql);
//echo $sql;
foreach($data as $row)
{ 	
    $sisa      = $row['SaldoAwal'];
    $datenow = date('Y-m-d');
    $day     = ceil((abs(strtotime($row["TanggalLahir"]) - strtotime($datenow))) / (60 * 60 * 24));
    $umur    = floor($day / 365);

	    $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);         
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $row['Nama']); 
	    //$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $row['NoKTP']); 
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$baris, $row["NoKTP"], PHPExcel_Cell_DataType::TYPE_STRING);
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, date("d-M-Y",strtotime($row['TanggalLahir'])) ); 
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $umur);         
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $row['HubunganKeluarga']);        
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $row['JenisKelamin']);       
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $row['Pekerjaan']);       
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $row['Agama']);       
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $row['BlokNo']); 


		$objPHPExcel->getActiveSheet()->getStyle("A".$baris.":A".$baris)->applyFromArray($bordercenter);
		$objPHPExcel->getActiveSheet()->getStyle("B".$baris.":B".$baris)->applyFromArray($borderleft);
        $objPHPExcel->getActiveSheet()->getStyle("C".$baris.":I".$baris)->applyFromArray($bordercenter);
		$objPHPExcel->getActiveSheet()->getStyle("J".$baris.":J".$baris)->applyFromArray($borderleft);

	$baris = $baris  + 1 ;
	$no++;
}


$outputFileType = 'Excel5';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $outputFileType);
$objWriter->save($outputFileName);
$excel->disconnectWorksheets();
unset($excel);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$outputFileName.'"');
header("Cache-Control: no-cache, must-revalidate");
$objWriter->save('php://output');

unlink($outputFileName);