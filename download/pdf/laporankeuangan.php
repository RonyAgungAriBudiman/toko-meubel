<?php
session_start();
ob_start();
include_once "../../sqlLib.php";
$sqlLib = new sqlLib();


?>


<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Bagian halaman HTML yang akan konvert -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>LAPORAN KEUANGAN</title>
    <style>
        table {
            font-size: 10px;
        }

        td {
            font-size: 10px;
        }

        th {
            font-size: 12px;
        }
    </style>
    <?php
            $tahun		= date("Y");
            $bulan		= date("m");
            $tanggal	= date("d");

            switch ($bulan) {
                case '01':
                    $bln_desc = "Januari";
                    break;
                case '02':
                    $bln_desc = "Februari";
                    break;
                case '03':
                    $bln_desc = "Maret";
                    break;
                case '04':
                    $bln_desc = "April";
                    break;
                case '05':
                    $bln_desc = "Mei";
                    break;
                case '06':
                    $bln_desc = "Juni";
                    break;
                case '07':
                    $bln_desc = "Juli";
                    break;
                case '08':
                    $bln_desc = "Agustus";
                    break;
                case '09':
                    $bln_desc = "September";
                    break;
                case '10':
                    $bln_desc = "Oktober";
                    break;
                case '11':
                    $bln_desc = "November";
                    break;
                case '12':
                    $bln_desc = "Desember";
                    break;
            }
            ?>    
</head>

<body>
    <table align="center">
        <tr>
            <td align="center" style="font-size: 14px; font-weight: bold;">
                KAS<br>
                RUKUN TETANGGA 02<br>
                PERUMAHAN GRAND SUTERA RAJEG<br>
                DESA TANJAKAN KECAMATAN RAJEG<br>
                KABUPATEN TANGERANG - 15540<br>
            </td>
        </tr>
    </table>
    <table align="center" cellspacing="0" cellpadding="0" border="0.5" width="100%" style="margin:0 auto; width:100%; text-align:center">
        <tr>
            <th style="text-align: center; padding:3px;" width="100">TANGGAL</th>
            <th style="text-align: center;" width="200">KETERANGAN</th>
            <!-- <th style="text-align: center;" width="100">SALDO AWAL</th> -->
            <th style="text-align: center;" width="100">MASUK</th>
            <th style="text-align: center;" width="100">KELUAR</th>
            <th style="text-align: center;" width="100">SALDO AKHIR</th>
        </tr>
        <?php
		    $no=1;
            $i = 0;
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
									//if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";	
            $sql.="WHERE YEAR(Tbl.Tanggal)='".$_GET['tahun']."'  AND Tbl.Keterangan ='Saldo Awal' ";										
			$sql.="Order By Tbl.Tanggal Asc";		
			$data = $sqlLib->select($sql);
			//echo $sql;
			foreach($data as $row)
				{ 	
					$sisa      = $row['SaldoAwal'];?>
		            <tr>
						<td style="text-align: center; padding:2px"><?php echo date("d-M-Y",strtotime($row['Tanggal'])) ?></td>
						<td style="text-align: left;"><?php echo $row['Keterangan'] ?></td>
						<!-- <td style="text-align: right;"><?php echo number_format($row['SaldoAwal']) ?></td> -->
						<td style="text-align: right;"><?php echo number_format(0) ?></td>
						<td style="text-align: right;"><?php echo number_format(0) ?></td>
						<td style="text-align: right;"><?php echo number_format($sisa) ?></td>									
					</tr>									
		            <?php
		            //$no++;
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
            //if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";	
            $sql_t.="WHERE YEAR(Tbl.Tanggal)='".$_GET['tahun']."'  AND Tbl.Keterangan !='Saldo Awal' ";										
            $sql_t.="Order By Tbl.Tanggal Asc";		
            $data_t = $sqlLib->select($sql_t);
            //echo $sql;
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

                if ($i % 59 == 0 and $i > 1) 
		                    {
                                ?>
                                </table>
			                    <div style="page-break-after: always;" ></div>
                                <table align="center">
                                    <tr>
                                        <td align="center" style="font-size: 14px; font-weight: bold;">
                                            KAS<br>
                                            RUKUN TETANGGA 02<br>
                                            PERUMAHAN GRAND SUTERA RAJEG<br>
                                            DESA TANJAKAN KECAMATAN RAJEG<br>
                                            KABUPATEN TANGERANG - 15540<br>
                                        </td>
                                    </tr>
                                </table>
                                <table align="center" cellspacing="0" cellpadding="0" border="0.5" width="100%" style="margin:0 auto; width:100%; text-align:center">
                                <tr>
                                    <th style="text-align: center; padding:3px;" width="100">TANGGAL</th>
                                    <th style="text-align: center;" width="200">KETERANGAN</th>
                                    <!-- <th style="text-align: center;" width="100">SALDO AWAL</th> -->
                                    <th style="text-align: center;" width="100">MASUK</th>
                                    <th style="text-align: center;" width="100">KELUAR</th>
                                    <th style="text-align: center;" width="100">SALDO AKHIR</th>
                                </tr>
                                <?php 
                            }?>
                
                
                <tr>
                    <td style="text-align: center; padding:2px"><?php echo date("d-M-Y",strtotime($row_t['Tanggal'])) ?> </td>
                    <td style="text-align: left;"><?php echo $row_t['Keterangan'] ?></td>
                    <!-- <td style="text-align: right;"><?php echo number_format($sisa_sebelum) ?></td> -->
                    <td style="text-align: right;"><?php echo number_format($in) ?></td>
                    <td style="text-align: right;"><?php echo number_format($out) ?></td>
                    <td style="text-align: right;"><?php echo number_format($sisa) ?></td>									
                </tr>									
                <?php
                $no++;
                $i++;
            }    
               
        ?>
        
        <tr>
            <th colspan="4" style="text-align: center; padding:3px; font-weight:bold;">SALDO AKHIR</th>
            <th style="text-align: right; font-weight:bold;"><?php echo number_format($sisa) ?></th>
        </tr>

    </table>
    <table align="center" cellspacing="0" cellpadding="0"  style="margin:0 auto; width:100%; text-align:center;">
        <tr>
            <td colspan="5" style="height: 20px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:15%;">&nbsp;</td>
            <td style="width:20%;">Mengetahui,</td>
            <td style="width:30%;">&nbsp;</td>
            <td style="width:20%;">Rajeg, <?php echo $tanggal." ".$bln_desc." ".$tahun ?></td>
            <td style="width:15%;">&nbsp;</td>
        </tr>  
        
        <tr>
            <td>&nbsp;</td>
            <td>Ketua RT 02</td>
            <td>&nbsp;</td>
            <td>Bendahara</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="height: 50px;">&nbsp;</td>
        </tr> 
        <tr>
            <td>&nbsp;</td>
            <td><b>WAGIMAN</b></td>
            <td>&nbsp;</td>
            <td><b>ROMADHON</b></td>
            <td>&nbsp;</td>
        </tr>   
        
    </table>
</body>

</html>

<?php
$filename = "Laporan Keuangan Kas RT02 " . date("Y") . ".pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya
$content = ob_get_clean();
//$content = '<page style="font-family: freeserif">'.nl2br($content).'</page>';

require_once("../../plugins/html2pdf/html2pdf.class.php");
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'ISO-8859-15', array(5, 5, 5, 5));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
} catch (HTML2PDF_exception $e) {
    echo $e;
}
?>