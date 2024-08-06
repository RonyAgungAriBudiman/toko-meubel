<?php 

$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
if ($_POST["tahun"] == "") $_POST["tahun"] = date("Y");
if ($_POST["bulan"] == "") $_POST["bulan"] = date("m")*1;
if ($_POST["jenis"] == "") $_POST["jenis"] = "Bulanan";

?>

<div class="header">
  <h1>
	<?php echo acakacak("decode",$_GET["p"]) ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active"><?php echo acakacak("decode",$_GET["p"]) ?></li>
	<li><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Info </button> &nbsp; 
		</li>
  </ol>
</div>



<div class="row">
      	<div class="col-sm-12">
      		<div class="box box-primary">
            	<div class="box-header">
            		<div class="form-group row">
						<form method="post">
							<div class="col-md-2">
								<select class="form-control" name="tahun" id="tahun" required="required">
						            	<?php
						                    for ($i = 2022; $i <= (date("Y") + 1); $i++) { ?>
						                        <option value="<?php echo $i ?>" <?php if ($_POST["tahun"] == $i) {
						                                                                echo "selected";
						                                                            } ?>><?php echo $i ?></option>
						                    <?php } ?>                
						        </select>
							</div>
							
							<div class="col-md-4">
								<button type="submit" name="cari" class="btn btn-primary">Cari</button>
								<a href="download/excel/laporankeuangan.php?tahun=<?php echo $_POST["tahun"]; ?>" target="_blank">
							    <button type="button" name="cari" class="btn btn-success"><i class="fa fa-download"> </i> Excel</button></a>
								<a href="download/pdf/laporankeuangan.php?tahun=<?php echo $_POST["tahun"]; ?>" target="_blank">
							    <button type="button" name="cari" class="btn btn-warning"><i class="fa fa-download"> </i> Pdf</button></a>
							</div>
						</form>
				    </div>
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example6" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                 
		                  <th>&nbsp;&nbsp;&nbsp;TANGGAL&nbsp;&nbsp;&nbsp;</th>
		                  <th>KETERANGAN</th>
		                  <th>SALDO&nbsp;&nbsp;AWAL</th>
		                  <th>&nbsp;&nbsp;&nbsp;&nbsp;MASUK&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                  <th>&nbsp;&nbsp;&nbsp;&nbsp;KELUAR&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                  <th>SALDO&nbsp;&nbsp;AKHIR</th>
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
                            //saldo awal
		                	$sql = "SELECT Tanggal, Keterangan, SaldoAwal, Masuk, Keluar
                                    FROM(
                                            SELECT a.Tanggal, 'Saldo Awal' as Keterangan, a.Nominal as SaldoAwal, '0' as Masuk, '0' as Keluar
                                            FROM ms_opname a
                                        
                                            UNION ALL
                                            SELECT CONCAT(YEAR(Tanggal),'-',SUBSTRING(Tanggal,6,2),'-10') as Tanggal, CONCAT('Iuran ',Jenis,' ',UserLog) as Keterangan, '0' as SaldoAwal, SUM(Nominal) as Masuk, '0' as Keluar
                                            FROM ms_pemasukan 
                                            GROUP BY Jenis, YEAR(Tanggal), SUBSTRING(Tanggal,6,2), UserLog
                                            
                                            UNION ALL
                                            SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, '0' as Masuk, a.Nominal as Keluar
                                            FROM ms_pengeluaran a
                                        
                                        
                                        ) as Tbl ";
									//if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";	
                                    $sql.="WHERE YEAR(Tbl.Tanggal)='".$_POST['tahun']."'  AND Tbl.Keterangan ='Saldo Awal' ";										
									$sql.="Order By Tbl.Tanggal Asc";		
							$data = $sqlLib->select($sql);
							//echo $sql;
							foreach($data as $row)
							{ 	
								$sisa      = $row['SaldoAwal'];?>
		                		<tr>
									<td style="text-align: center;"><?php echo date("d-M-Y",strtotime($row['Tanggal'])) ?></td>
									<td style="text-align: left;"><?php echo $row['Keterangan'] ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($row['SaldoAwal']) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format(0) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format(0) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($sisa) ?></td>									
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
                                            SELECT CONCAT(YEAR(Tanggal),'-',SUBSTRING(Tanggal,6,2),'-10') as Tanggal, CONCAT('Iuran ',Jenis,' ',UserLog) as Keterangan, '0' as SaldoAwal, SUM(Nominal) as Masuk, '0' as Keluar
                                            FROM ms_pemasukan 
                                            GROUP BY Jenis, YEAR(Tanggal), SUBSTRING(Tanggal,6,2), UserLog
                                            
                                            UNION ALL
                                            SELECT a.Tanggal, a.Keterangan, '0' as SaldoAwal, '0' as Masuk, a.Nominal as Keluar
                                            FROM ms_pengeluaran a
                                        
                                        
                                        ) as Tbl ";
									//if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";	
                                    $sql_t.="WHERE YEAR(Tbl.Tanggal)='".$_POST['tahun']."'  AND Tbl.Keterangan !='Saldo Awal' ";										
									$sql_t.="Order By Tbl.Tanggal Asc";		
							$data_t = $sqlLib->select($sql_t);
							//echo $sql_t;
							foreach($data_t as $row_t)
							{ 	
								$in = "0";
                                $out = "0";

                                if($row_t["Masuk"]>"0") $in = $row_t["Masuk"];
                                if($row_t["Keluar"]>"0") $out =$row_t["Keluar"];

                                $sisa_sebelum = $sisa;
                                $sisa         =  $sisa_sebelum + ($in-$out);            		
                                $tot_in += $in;
                                $tot_out += $out;?>
		                		<tr>
									<td style="text-align: center;"><?php echo date("d-M-Y",strtotime($row_t['Tanggal'])) ?></td>
									<td style="text-align: left;"><?php echo $row_t['Keterangan'] ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($sisa_sebelum) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($in) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($out) ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($sisa) ?></td>									
								</tr>									
		                		<?php
		                		//$no++;
		                	}
		                	?>

		                </tbody>

		                <tfoot>
		                	<tr>
		                		<th colspan="5" style="text-align: center;">SALDO AKHIR</th>
		                		<th style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($sisa);?></th>
		                		
		                	</tr>	
		                </tfoot>
		                
		            	</table>
		            </div>
		        </div>
		    </div>
		</div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modul <?php echo acakacak("decode",$_GET["p"]) ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Kumpulan data pemasukan dan pengeluaran uang kas RT.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>