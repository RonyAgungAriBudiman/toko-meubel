<?php
session_start();
include("../../plugins/PHPExcel/PHPExcel.php");
include("../../plugins/PHPExcel/PHPExcel/IOFactory.php");

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

$inputFileType = 'Excel5';
$inputFileName = 'template/detailtunggakan.xls';
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

include_once "../../sqlLib.php";  $sqlLib = new sqlLib();
//include_once "../../sqlLib_pro.php";  $sqlLibPro = new sqlLibPro();  //server 10.11.13.127

$objPHPExcel->setActiveSheetIndex(0);
$outputFileName = 'detailtunggakan.xls';


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


$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
$objPHPExcel->getActiveSheet()->setCellValue('B1', ucwords($bulan[$_GET["bulan"]]).' - '. $_GET["tahun"] );
$objPHPExcel->getActiveSheet()->setCellValue('B2', ucwords($_GET["userid"]));
$objPHPExcel->getActiveSheet()->setCellValue('B3', $_GET["jenis"] );

$no=1;
$baris =5;
$tahun = $_GET["tahun"];
$bulan = $_GET["bulan"];
$jenis = $_GET["jenis"];


if($_GET['bulan']<10) $month = "0".$_GET['bulan'];
	else $month = $_GET['bulan'];

$sql = "SELECT a.Blok, a.No, a.Pemilik, a.Koordinator
		FROM ms_rumah a	
		WHERE a.Blok != ''  AND a.Koordinator ='".$_GET['userid']."' AND a.Status!='Kosong' AND
				CONCAT(a.Blok,'/',a.No) NOT IN (
					SELECT CONCAT(b.Blok,'/',b.NoRumah) 
					FROM ms_pemasukan b 
					WHERE b.Tahun ='".$tahun."' AND b.Bulan ='".$month."'  AND b.Jenis='".$jenis."' )";									
$sql.=" Order By a.Urut asc";		
$data = $sqlLib->select($sql);

foreach($data as $row) 
    {  
    	
    	$norumah = $row["Blok"].'/'.$row["No"].' '.$row["Pemilik"];

    	$sql_2 = "SELECT Nominal FROM ms_nominal WHERE Jenis = '".$jenis."'";
		$data_2=$sqlLib->select($sql_2);
		$t_nominal += $data_2[0]['Nominal'];
				 
	    $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no); 
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $norumah); 
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, number_format($data_2[0]['Nominal'])); 


		$objPHPExcel->getActiveSheet()->getStyle("A".$baris.":A".$baris)->applyFromArray($bordercenter);
		$objPHPExcel->getActiveSheet()->getStyle("B".$baris.":B".$baris)->applyFromArray($borderleft);
		$objPHPExcel->getActiveSheet()->getStyle("C".$baris.":C".$baris)->applyFromArray($borderright);

	$baris = $baris  + 1 ;
	$no++;
	}
	


     $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'GRAND TOTAL'); 
     $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, number_format($t_nominal)); 


		 $objPHPExcel->getActiveSheet()->getStyle("A".$baris.":A".$baris)->applyFromArray($bordercenter);
		 $objPHPExcel->getActiveSheet()->getStyle("B".$baris.":B".$baris)->applyFromArray($borderleft);
		 $objPHPExcel->getActiveSheet()->getStyle("C".$baris.":C".$baris)->applyFromArray($borderright);

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