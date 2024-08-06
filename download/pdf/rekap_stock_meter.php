<?php
session_start();
ob_start();
include "../../koneksi_sql.php";
include_once "../../sqlLib.php";
$sqlLib = new sqlLib();

$sql_material = "SELECT CONCAT(Nama,' ',Spesifikasi,' ',Ukuran)  as Nama
                FROM ms_material
                WHERE JenisID ='J004' AND  MaterialID = '" . $_GET["materialid"] . "'";
$data_material = $sqlLib->select($sql_material);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Bagian halaman HTML yang akan konvert -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>REKAP STOCK METER</title>
    <style>
        table {
            font-size: 10px;
        }

        td {
            font-size: 12px;
        }

        th {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <table align="center">
        <tr>
            <td align="center" style="font-size: 14px; font-weight: bold;">REKAP STOCK METER <br> <?php echo $data_material[0]['Nama']?> <br> <?php echo date("d F Y") ?><br>&nbsp;</td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" border="0.5" width="100%">
        <tr>
            <th style="text-align: center;" width="100">BULAN</th>
            <th style="text-align: center;" width="80">STOCK</th>
            <th style="text-align: center;" width="80">PRODUKSI</th>
            <th style="text-align: center;" width="80">SPB</th>
            <th style="text-align: center;" width="80">KIRIM</th>
            <th style="text-align: center;" width="100">SUDAH KIRIM<br> BUKA FAKTUR</th>
            <th style="text-align: center;" width="100">SUDAH KIRIM<br> BELUM BUKA FAKTUR</th>
            <th style="text-align: center;" width="100">PENGGANTI REJECT<br> DAN SAMPLE</th>
        </tr>

        <?php
        $tahunlalu = $_GET['tahun'] - 1;
        $sql_tahunan = "SELECT 
                                (
                                SELECT COALESCE(SUM(a.Qty),NULL,0) as Produksi
                                FROM ms_alokasi_harga_material a 
                                WHERE a.MaterialID ='810V3SMT60' AND YEAR(a.Tanggal)='" . $tahunlalu . "' 
                                AND a.Tujuan ='gudang' AND a.Kategori ='terima material') as Stock,                                
                                (		
                                SELECT COALESCE(SUM(a.Qty),NULL,0) as Produksi
                                FROM ms_alokasi_harga_material a 
                                WHERE a.MaterialID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $tahunlalu . "' 
                                AND a.Tujuan ='gudang' AND a.Kategori ='produk jadi') as Produksi,                                
                                (	   
                                SELECT COALESCE(SUM(b.Jumlah),NULL,0) as SPB 
                                FROM ms_sales_order a
                                LEFT JOIN tr_sales_order b on b.NoReg = a.NoReg
                                WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $tahunlalu . "'  
                                 AND a.Batal ='0') as SPB,                                
                                (	    	
                                SELECT COALESCE(SUM(b.Qty),NULL,0) as Kirim
                                FROM ms_surat_jalan a
                                LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                                WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $tahunlalu . "' 
                                 AND a.Batal ='0'  ) as Kirim,
                                (
                                SELECT COALESCE(SUM(b.Jumlah),NULL,0)
                                FROM ms_tagihan a
                                LEFT JOIN tr_tagihan b on b.NoFaktur = a.NoFaktur
                                WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.TglFaktur)>='" . $tahunlalu . "' 
                                AND b.NoReg IN (
                                                    SELECT DISTINCT x.NoReg 
                                                    FROM ms_surat_jalan x
                                                    LEFT JOIN tr_surat_jalan y on y.NoSuratJalan =x.NoSuratJalan
                                                    WHERE y.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(x.Tanggal)='" . $tahunlalu . "' 
                                                    AND x.DokumenReturn ='' AND x.Batal ='0')
                                                    ) as SudahKirimBukaFaktur,
                                (
                                SELECT  COALESCE(SUM(CASE WHEN (b.Qty - c.Jumlah) is null THEN b.Qty Else '0' END),NULL,0)		
                                FROM ms_surat_jalan a
                                LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                                LEFT JOIN tr_tagihan c on c.NoReg = a.NoReg
                                WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $tahunlalu . "' 
                                AND a.DokumenReturn ='' AND a.Batal ='0' ) as SudahKirimBelumFaktur,
                                (
                                SELECT COALESCE(SUM(b.Qty),NULL,0) as Reject
                                FROM ms_surat_jalan a
                                LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                                WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $tahunlalu . "' 
                                AND a.Batal ='0'
                                AND a.NoReg IN (
                                    SELECT x.NoReg FROM ms_sales_order x
                                    LEFT JOIN tr_sales_order y on y.NoReg = x.NoReg
                                    WHERE x.Jenis ='non po' AND y.ProdukID ='" . $_GET["materialid"] . "'
                                )) as PenggantiReject";
        $data_tahunan = $sqlLib->select($sql_tahunan);
        if ($_GET["materialid"] != '810V3') {
            $data_tahunan[0]['Stock'] = 0;
        } else {
            $data_tahunan[0]['Stock'] = $data_tahunan[0]['Stock'];
        }

        ?>

        <tr>
            <td style="text-align: left; padding:3px;">Tahun <?php echo $tahunlalu; ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['Stock']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['Produksi']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['SPB']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['Kirim']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['SudahKirimBukaFaktur']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['SudahKirimBelumFaktur']) ?></td>
            <td style="text-align: right;"><?php echo number_format($data_tahunan[0]['PenggantiReject']) ?></td>
        </tr>

        <?php
        for ($bln = 1; $bln <= 12; $bln++) {
            if ($bln == '1') {
                $bulan = 'Januari';
            } elseif ($bln == '2') {
                $bulan = 'Februari';
            } elseif ($bln == '3') {
                $bulan = 'Maret';
            } elseif ($bln == '4') {
                $bulan = 'April';
            } elseif ($bln == '5') {
                $bulan = 'Mei';
            } elseif ($bln == '6') {
                $bulan = 'Juni';
            } elseif ($bln == '7') {
                $bulan = 'Juli';
            } elseif ($bln == '8') {
                $bulan = 'Agustus';
            } elseif ($bln == '9') {
                $bulan = 'September';
            } elseif ($bln == '10') {
                $bulan = 'Oktober';
            } elseif ($bln == '11') {
                $bulan = 'November';
            } elseif ($bln == '12') {
                $bulan = 'Desember';
            }

            $sql = "SELECT 
                            (
                            SELECT COALESCE(SUM(a.Qty),NULL,0) as Produksi
                            FROM ms_alokasi_harga_material a 
                            WHERE a.MaterialID ='810V3SMT60' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "' AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.Tujuan ='gudang' AND a.Kategori ='terima material') as Stock,                                
                            (		
                            SELECT COALESCE(SUM(a.Qty),NULL,0) as Produksi
                            FROM ms_alokasi_harga_material a 
                            WHERE a.MaterialID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "' AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.Tujuan ='gudang' AND a.Kategori ='produk jadi') as Produksi,                                
                            (	   
                            SELECT COALESCE(SUM(b.Jumlah),NULL,0) as SPB 
                            FROM ms_sales_order a
                            LEFT JOIN tr_sales_order b on b.NoReg = a.NoReg
                            WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "'  AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.Batal ='0') as SPB,                                
                            (	    	
                            SELECT COALESCE(SUM(b.Qty),NULL,0) as Kirim
                            FROM ms_surat_jalan a
                            LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                            WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "' AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.Batal ='0'  ) as Kirim,
                            (
                            SELECT COALESCE(SUM(b.Jumlah),NULL,0)
                            FROM ms_tagihan a
                            LEFT JOIN tr_tagihan b on b.NoFaktur = a.NoFaktur
                            WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.TglFaktur)='" . $_GET['tahun'] . "' AND MONTH(a.TglFaktur)='" . $bln . "'  
                            AND b.NoReg IN (
                                                SELECT DISTINCT x.NoReg 
                                                FROM ms_surat_jalan x
                                                LEFT JOIN tr_surat_jalan y on y.NoSuratJalan =x.NoSuratJalan
                                                WHERE y.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(x.Tanggal)='" . $_GET['tahun'] . "' 
                                                AND x.DokumenReturn ='' AND x.Batal ='0')
                                                ) as SudahKirimBukaFaktur,
                            (
                            SELECT  COALESCE(SUM(CASE WHEN (b.Qty - c.Jumlah) is null THEN b.Qty Else '0' END),NULL,0)		
                            FROM ms_surat_jalan a
                            LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                            LEFT JOIN tr_tagihan c on c.NoReg = a.NoReg
                            WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "'  AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.DokumenReturn ='' AND a.Batal ='0' ) as SudahKirimBelumFaktur,
                            (
                            SELECT COALESCE(SUM(b.Qty),NULL,0) as Reject
                            FROM ms_surat_jalan a
                            LEFT JOIN tr_surat_jalan b on b.NoSuratJalan = a.NoSuratJalan
                            WHERE b.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(a.Tanggal)='" . $_GET['tahun'] . "'  AND MONTH(a.Tanggal)='" . $bln . "' 
                            AND a.Batal ='0'
                            AND a.NoReg IN (
                                SELECT x.NoReg FROM ms_sales_order x
                                LEFT JOIN tr_sales_order y on y.NoReg = x.NoReg
                                WHERE x.Jenis ='non po' AND y.ProdukID ='" . $_GET["materialid"] . "' AND YEAR(x.Tanggal)='" . $_GET['tahun'] . "' 
                            )) as PenggantiReject
                        ";
            $data = $sqlLib->select($sql);
            if ($_GET["materialid"] != '810V3') {
                $data[0]['Stock'] = 0;
            } else {
                $data[0]['Stock'] = $data[0]['Stock'];
            }

            $t_stock += $data[0]['Stock'];
            $t_produksi += $data[0]['Produksi'];
            $t_spb += $data[0]['SPB'];
            $t_kirim += $data[0]['Kirim'];
            $t_bukafaktur += $data[0]['SudahKirimBukaFaktur'];
            $t_belumfaktur += $data[0]['SudahKirimBelumFaktur'];
            $t_penggantireject += $data[0]['PenggantiReject'];

        ?>
            <tr>
                <td style="text-align: left; padding:3px;"><?php echo $bulan; ?> <?php if ($bln == '1') {
                                                                                        echo $_GET['tahun'];
                                                                                    } ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['Stock']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['Produksi']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['SPB']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['Kirim']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['SudahKirimBukaFaktur']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['SudahKirimBelumFaktur']) ?></td>
                <td style="text-align: right;"><?php echo number_format($data[0]['PenggantiReject']) ?></td>
            </tr>
        <?php }

        $gt_stock = $t_stock + $data_tahunan[0]['Stock'];
        $gt_produksi = $t_produksi + $data_tahunan[0]['Produksi'];
        $gt_spb = $t_spb + $data_tahunan[0]['SPB'];
        $gt_kirim = $t_kirim + $data_tahunan[0]['Kirim'];
        $gt_bukafaktur = $t_bukafaktur + $data_tahunan[0]['SudahKirimBukaFaktur'];
        $gt_belumfaktur = $t_belumfaktur + $data_tahunan[0]['SudahKirimBelumFaktur'];
        $gt_penggantireject = $t_penggantireject + $data_tahunan[0]['PenggantiReject'];

        ?>

        <tr>
            <td style="text-align: center; padding:3px;">TOTAL</td>
            <td style="text-align: right;"><?php echo number_format($gt_stock) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_produksi) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_spb) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_kirim) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_bukafaktur) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_belumfaktur) ?></td>
            <td style="text-align: right;"><?php echo number_format($gt_penggantireject) ?></td>
        </tr>


    </table>
    <table>
        <tr>
            <td>Note</td>
            <td>:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Stock</td>
            <td>:</td>
            <td>Berdasarkan Penerimaan MCU (810V3SMT60) oleh Gudang.</td>
        </tr>
        <tr>
            <td>Produksi</td>
            <td>:</td>
            <td>Hasil Produk Jadi</td>
        </tr>
        <tr>
            <td>SPB</td>
            <td>:</td>
            <td>Berdasarkan SPB PLN, Pengganti Reject, Sample dan Pengujian. </td>
        </tr>
        <tr>
            <td>Kirim</td>
            <td>:</td>
            <td>Pengiriman SPB PLN, Pengganti Reject, Sample dan Pengujian. </td>
        </tr>
    </table>
</body>

</html>

<?php
$filename = "Rekap Stock Meter " . date("d F Y") . ".pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya
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