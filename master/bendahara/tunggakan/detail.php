
<div class="header">
  <h1>
	<?php echo $_GET["p"] ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active"><?php echo $_GET["p"] ?></li>
  </ol>
</div>
<?php 

$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");

if($_GET['bulan']<10) $month = "0".$_GET['bulan'];
	else $month = $_GET['bulan'];
?>


<div class="row">
      	<div class="col-sm-12">
      		<div class="box box-primary">
            	<div class="box-header">
            		<div class="form-group row">
            			 
							<div class="col-md-2">
								Periode : <?php echo ucwords($bulan[$_GET["bulan"]])  ?>  <?php echo $_GET["tahun"] ?>
							</div>
							<div class="col-md-2">
								Koordinator : <?php echo ucwords($_GET["userid"]) ?>
							</div>
							<div class="col-md-2">
								Jenis Iuaran : <?php echo $_GET["jenis"] ?> 
							</div>
							<div class="col-md-2">
							<a href="download/excel/detailtunggakan.php?userid=<?php echo $_GET["userid"]; ?>&tahun=<?php echo $_GET["tahun"]; ?>&bulan=<?php echo $_GET["bulan"]; ?>&jenis=<?php echo $_GET["jenis"]; ?>" target="_blank">
							<button type="button" name="cari" class="btn btn-success"><i class="fa fa-download"> </i> Excel</button></a>
							</div>
				    </div>
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example5" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                 
		                  <th>BLOK/NO</th>
		                  <th>NOMINAL</th>
		                  
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
		                	$tahun = $_GET["tahun"];
		                	$bulan = $_GET["bulan"];
		                	$jenis = $_GET["jenis"];
		                	
		                	$sql = "SELECT a.Blok, a.No, a.Pemilik, a.Koordinator
											FROM ms_rumah a	
											WHERE a.Blok != ''  AND a.Koordinator ='".$_GET['userid']."' AND a.Status!='Kosong' AND	
											CONCAT(a.Blok,'/',a.No) NOT IN (
												SELECT CONCAT(b.Blok,'/',b.NoRumah) 
												FROM ms_pemasukan b 
												WHERE b.Tahun ='".$tahun."' AND b.Bulan ='".$month."'  AND b.Jenis='".$jenis."' )";									
							$sql.=" Order By a.Urut asc";		
							$data = $sqlLib->select($sql);
							//echo $sql;
							foreach($data as $row)
							{ 	
								
								$sql_2 = "SELECT Nominal FROM ms_nominal WHERE Jenis = '".$jenis."'";
								$data_2=$sqlLib->select($sql_2);
								$t_nominal += $data_2[0]['Nominal'];
								?>
		                		<tr>
									<td style="text-align: left;"><?php echo $row['Blok'] ?>/<?php echo $row['No'] ?><br><?php echo $row['Pemilik'] ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($data_2[0]['Nominal']) ?></td>
								</tr>
            						
		                		<?php
		                		$no++;
		                	}
		                	?>

		                </tbody>

		                <tfoot>
		                	<tr>
		                		<th>GRAND TOTAL</th>
		                		<th style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($t_nominal);?></th>
		                	</tr>	
		                </tfoot>
		                
		            	</table>
		            </div>
		        </div>
		    </div>
		</div>
</div>
