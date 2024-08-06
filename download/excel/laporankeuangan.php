<?php
session_start();
include("../../plugins/PHPExcel/PHPExcel.php");
include("../../plugins/PHPExcel/PHPExcel/IOFactory.php");

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

$inputFileType = 'Excel5';
$inputFileName = 'template/laporankeuangan.xls';
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

include_once "../../sqlLib.php";  $sqlLib = new sqlLib();
//include_once "../../sqlLib_pro.php";  $sqlLibPro = new sqlLibPro();  //server 10.11.13.127

$objPHPExcel->setActiveSheetIndex(0);
$outputFileName = 'Laporan Keuangan.xls';

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
$sql = "SELECT Tanggal, Keterangan, SaldoAwal, Masuk, Keluar
FROM(
        SELECT a.Tanggal, 'Saldo Awal' as Keterangan, a.Nominal as SaldoAwal, '0' as Masuk, '0' as Keluar
        FROM ms_opname a
    
        UNION ALL
        SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, a.Nominal as Masuk, '0' as Keluar
        FROM ms_masuk a
        
        UNION ALL
        SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, '0' as Masuk, a.Nominal as Keluar
        FROM ms_pengeluaran a
    
    
    ) as Tbl ";
$sql.="WHERE YEAR(Tbl.Tanggal)='".$_GET['tahun']."'  AND Tbl.Keterangan ='Saldo Awal' ";										
$sql.="Order By Tbl.Tanggal Asc";		
$data = $sqlLib->select($sql);
//echo $sql;
foreach($data as $row)
{ 	
    $sisa      = $row['SaldoAwal'];

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, date("d-M-Y",strtotime($row['Tanggal'])) ); 
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $row['Keterangan']); 
	    // $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $row['SaldoAwal']); 
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, '0'); 
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, '0'); 
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $sisa); 


		$objPHPExcel->getActiveSheet()->getStyle("A".$baris.":A".$baris)->applyFromArray($bordercenter);
		$objPHPExcel->getActiveSheet()->getStyle("B".$baris.":B".$baris)->applyFromArray($borderleft);
		$objPHPExcel->getActiveSheet()->getStyle("C".$baris.":E".$baris)->applyFromArray($borderright);

	$baris = $baris  + 1 ;
	$no++;
}

//transaksi
$sql_t = "SELECT Tanggal, Keterangan, SaldoAwal, Masuk, Keluar
FROM(
        SELECT a.Tanggal, 'Saldo Awal' as Keterangan, a.Nominal as SaldoAwal, '0' as Masuk, '0' as Keluar
        FROM ms_opname a
    
        UNION ALL
        SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, a.Nominal as Masuk, '0' as Keluar
        FROM ms_masuk a
        
        UNION ALL
        SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, '0' as Masuk, a.Nominal as Keluar
        FROM ms_pengeluaran a
    
    
    ) as Tbl ";
$sql_t.="WHERE YEAR(Tbl.Tanggal)='".$_GET['tahun']."'  AND Tbl.Keterangan !='Saldo Awal' ";										
$sql_t.="Order By Tbl.Tanggal Asc";		
$data_t = $sqlLib->select($sql_t);
foreach($data_t as $row_t)
{ 	
    $in = "0";
    $out = "0";

    if($row_t["Masuk"]>"0") $in = $row_t["Masuk"];
    if($row_t["Keluar"]>"0") $out =$row_t["Keluar"];

    $sisa_sebelum = $sisa;
    $sisa         =  $sisa_sebelum + ($in-$out);            		
    $tot_in += $in;
    $tot_out += $out;

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, date("d-M-Y",strtotime($row_t['Tanggal'])) ); 
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $row_t['Keterangan']); 
	    // $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $sisa_sebelum); 
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $in); 
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $out); 
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $sisa); 


		$objPHPExcel->getActiveSheet()->getStyle("A".$baris.":A".$baris)->applyFromArray($bordercenter);
		$objPHPExcel->getActiveSheet()->getStyle("B".$baris.":B".$baris)->applyFromArray($borderleft);
		$objPHPExcel->getActiveSheet()->getStyle("C".$baris.":E".$baris)->applyFromArray($borderright);

	$baris = $baris  + 1 ;
	$no++;
}

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'SALDO AKHIR'); 
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $sisa); 


    $objPHPExcel->getActiveSheet()->getStyle("A".$baris.":D".$baris)->applyFromArray($bordercenter);
    $objPHPExcel->getActiveSheet()->getStyle("E".$baris.":E".$baris)->applyFromArray($borderright);

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