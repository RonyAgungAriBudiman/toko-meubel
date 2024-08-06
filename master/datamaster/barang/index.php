
<div class="header">
  <h1>
	<?php echo acakacak("decode",$_GET["p"]) ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> dashboard</a></li>
	<li class="active"><?php echo acakacak("decode",$_GET["p"]) ?></li>
	<li><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Info </button>  &nbsp; 
		<a href="index.php?m=<?php echo acakacak("encode","datamaster/barang")?>&sm=<?php echo acakacak("encode","add")?>&p=<?php echo acakacak("decode",$_GET["p"]) ?>">
			<button type="button" class="btn btn-primary"><i class="fa fa-plus"> </i> Barang</button></a>
		<a href="download/excel/databarang.php" target="_blank">
			<button type="button" name="cari" class="btn btn-success"><i class="fa fa-download"> </i> Excel</button></a>	
		</li>
  </ol>
</div>


	<div class="row">
      	<div class="col-sm-12">
      		<?php
				if($alert=="0")
				{
					?><div class="form-group">						
						<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Alert!</h4>
						<?php echo $note?>		
						</div>
				  	  </div><?php 
				}
				else if($alert=="1")
				{
					?><div class="form-group">
						<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-warning"></i> Alert!</h4>
						<?php echo $note?>
						</div>
				    	</div><?php
				}
				?>

          	<div class="box box-primary">
            	<div class="box-header">
            		
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example1" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                    <th>Blok/No</th>
		                    <th>Nama</th>
		                    <th>Jenis Kelamin</th>
		                    <th>Umur</th>
							<?php if($_SESSION["level"] =="9") { ?>
		                    <th>Edit</th>
							<?php } ?>
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
		                	$sql = "SELECT a.SeqWarga, a.Blok, a.No, a.Nama, a.JenisKelamin, a.TanggalLahir, concat(a.Blok,'/',a.No) as BlokNo 
									FROM ms_warga a	
									WHERE a.Nama != ''  ";			
							$data = $sqlLib->select($sql);
							foreach($data as $row)
							{ 	
								$datenow = date('Y-m-d');
								$day     = ceil((abs(strtotime($row["TanggalLahir"]) - strtotime($datenow))) / (60 * 60 * 24));
								$umur    = floor($day / 365);
								
								?>
		                		<tr>
									<td style="text-align: center;"><?php echo $row['BlokNo'] ?></td>
									<td style="text-align: left;"><?php echo $row['Nama'] ?></td>
									<td style="text-align: left;"><?php echo $row['JenisKelamin'] ?></td>
									<td style="text-align: left;"><?php echo $umur ?> Thn</td>
									<?php if($_SESSION["level"] =="9") { ?>
									<td style="text-align: center;">
										<a href="index.php?m=<?php echo acakacak("encode","database/warga")?>&sm=<?php echo acakacak("encode","edit")?>&seqwarga=<?php echo $row["SeqWarga"]?>&p=<?php echo acakacak("decode",$_GET["p"]) ?>">
											<button type="button" class="btn btn-success"><i class="fa fa-edit"> </i> Edit</button>
										</a>
									</td>
									<?php } ?>
								</tr>	
		                		<?php
		                		$no++;
		                	}
		                	?>

		                </tbody>
		                
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
        Berisi data barang, dapat melakukan input data barang dan update data barang
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>