<?php 

$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
if ($_POST["tahun"] == "") $_POST["tahun"] = date("Y");
if ($_POST["bulan"] == "") $_POST["bulan"] = date("m")*1;
if ($_POST["jenis"] == "") $_POST["jenis"] = "Bulanan";

if(isset($_POST['Update']))
{
	$alamat = explode("/", $_POST['rumah']);
	if($_POST['bulan']<10) $month = "0".$_POST['bulan'];
	else $month = $_POST['bulan'];
	$sql_upd = "UPDATE ms_pemasukan set Jenis = '".$_POST['jenis']."', 
									Tahun = '".$_POST['tahun']."', 
									Bulan = '".$month."', 
									Blok = '".$alamat[0]."', 
									NoRumah = '".$alamat[1]."', 
									Nominal = '".$_POST['nominal']."'	
				WHERE PemasukanID ='".$_POST['pemasukanid']."'  ";
	$run_upd = $sqlLib->update($sql_upd);
	if($run_upd=="1")
    {
      $alert = '0'; 
      $note = "Proses update berhasil";
    }
    else
    {
      $alert = '1'; 
      $note = "Proses update gagal";
    }			
}

if(isset($_POST['Hapus']))
{
	$sql_del="DELETE FROM ms_pemasukan WHERE PemasukanID ='".$_POST['pemasukanid']."'	";
	$run_del=$sqlLib->delete($sql_del);
	if($run_del=="1")
    {
      $alert = '0'; 
      $note = "Proses hapus berhasil";
    }
    else
    {
      $alert = '1'; 
      $note = "Proses hapus gagal";
    }

}		

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
      		<?php
				if($alert=="0")
				{
					?><div class="form-group">						
						<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Success!</h4>
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
							<div class="col-md-2">
								<select class="form-control" name="bulan" id="bulan" required="required">
						            	<?php
						                    for ($i = 1; $i <= 12; $i++) { ?>
						                        <option value="<?php echo $i ?>" <?php if ($_POST["bulan"] == $i) {
						                                                                echo "selected";
						                                                            } ?>>
						                            <?php echo ucwords($bulan[$i]) ?></option>
						                    <?php } ?>                
						            </select>
							</div>

							<div class="col-md-2">
								<select class="form-control" name="jenis" id="jenis" required="required">
			                        <!-- <option value="">-Pilih Iuran-</option> -->
            						<option value="Bulanan" <?php if($_POST['jenis']=="Bulanan") { echo "selected" ; } ?>>Bulanan</option>
            						<option value="THR" <?php if($_POST['jenis']=="THR") { echo "selected" ; } ?>>THR</option>
            						<option value="PHBI" <?php if($_POST['jenis']=="PHBI") { echo "selected" ; } ?>>PHBI</option>
            						<option value="Lainnya" <?php if($_POST['jenis']=="Lainnya") { echo "selected" ; } ?>>Lainnya</option>
            					</select>
							</div>
							
							<div class="col-md-2">
								<button type="submit" name="cari" class="btn btn-primary">Cari</button>
							</div>
						</form>
				    </div>
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example4" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                 
		                  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BLOK/NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                  <th>NOMINAL</th>
		                  <?php if($_SESSION["level"]=="1" OR $_SESSION["level"]=="9"){?>
		                  <th>EDIT</th>
		                  <?php } ?>
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
							if($_POST['bulan']<10) $month = "0".$_POST['bulan'];
							else $month = $_POST['bulan'];
		                	$no=1;
		                	$sql = "SELECT 	a.Blok, a.No, a.Pemilik, a.Koordinator,
										(SELECT x.Nominal FROM ms_pemasukan x 
											WHERE x.Blok = a.Blok AND x.NoRumah = a.No AND x.Tahun='".$_POST["tahun"]."' 
												AND x.Bulan='".$month."' AND x.Jenis='".$_POST["jenis"]."' ) AS Nominal,
										(SELECT x.PemasukanID FROM ms_pemasukan x
											WHERE x.Blok = a.Blok AND x.NoRumah = a.No AND x.Tahun='".$_POST["tahun"]."' 
												AND x.Bulan='".$month."' AND x.Jenis='".$_POST["jenis"]."' ) AS PemasukanID		
									FROM ms_rumah a	
									WHERE a.Blok != '' AND a.Status!='Kosong' ";
									if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";										
									$sql.="Order By a.Blok Asc, a.Urut asc";		
							$data = $sqlLib->select($sql);
							//echo $sql;
							foreach($data as $row)
							{ 	
								$t_nominal += $row['Nominal'];
								?>
		                		<tr>
									<td style="text-align: center;"><?php echo $row['Blok'] ?>/<?php echo $row['No'] ?><br><?php echo $row['Pemilik'] ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($row['Nominal']) ?></td>
									<?php if($_SESSION["level"]=="1" OR $_SESSION["level"]=="9"){?>
									<td style="text-align: center;">
										<?php 
										if($row['PemasukanID']!='')
											{?>
												<button type="button" class="btn btn-success" data-toggle="modal"
														data-target="#Modaledit<?php echo $row['PemasukanID']; ?>">
															<i class="fa fa-edit"> </i> Edit</button>
											<?php } ?>				
										
									</td>
									<?php } ?>
									
								</tr>

								<!--modal edit -->
								<div class="modal fade" id="Modaledit<?php echo $row['PemasukanID']; ?>" tabindex="-1" role="dialog" 
            						aria-labelledby="exampleModalLabel" aria-hidden="true">
            						<div class="modal-dialog" role="document">
            						    <div class="modal-content">
            						      <div class="modal-header">
            						        <h5 class="modal-title" id="exampleModalLabel">PEMASUKAN</h5>
            						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            						          <span aria-hidden="true">&times;</span>
            						        </button>
            						      </div>
            						      <?php 
            						      	$sql = "SELECT * FROM ms_pemasukan WHERE PemasukanID = '".$row['PemasukanID']."' ";
            						      	$data= $sqlLib->select($sql);
            						      	$_POST['pemasukanid'] = $data[0]['PemasukanID'];
            						      	$_POST['jenis'] = $data[0]['Jenis'];
            						      	$_POST['tahun'] = $data[0]['Tahun'];
            						      	$_POST['bulan'] = $data[0]['Bulan'];
            						      	$_POST['nominal'] = $data[0]['Nominal'];
            						      	$_POST['rumah'] = $data[0]['Blok'].'/'.$data[0]['NoRumah'];

            						      ?>
            						      	<form method="post">
	            						    <div class="modal-body">
	            						      
	            						      	<div class="form-group">
	            						            <label for="status" class="col-form-label">JENIS IURAN</label>
	            						              <div >
	            						               <select class="form-control" name="jenis" id="jenis" required="required">
	            						               	<option value="Bulanan" <?php if($_POST['jenis']=="Bulanan") { echo "selected" ; } ?>>Bulanan</option>
					            						<option value="THR" <?php if($_POST['jenis']=="THR") { echo "selected" ; } ?>>THR</option>
					            						<option value="PHBI" <?php if($_POST['jenis']=="PHBI") { echo "selected" ; } ?>>PHBI</option>
					            						<option value="Lainnya" <?php if($_POST['jenis']=="Lainnya") { echo "selected" ; } ?>>Lainnya</option>
					            						</select>
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">TAHUN</label>
	            						              <div >
	            						               <select class="form-control" name="tahun" id="tahun" required="required">
											            	<?php
											                    for ($i = 2022; $i <= (date("Y") + 1); $i++) { ?>
											                        <option value="<?php echo $i ?>" <?php if ($_POST["tahun"] == $i) {
											                                                                echo "selected";
											                                                            } ?>><?php echo $i ?></option>
											                    <?php } ?>                
											            </select>
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">BULAN</label>
	            						              <div >
	            						               <select class="form-control" name="bulan" id="bulan" required="required">
											            	<?php
										                    for ($i = 1; $i <= 12; $i++) { ?>
										                        <option value="<?php echo $i ?>" <?php if ($_POST["bulan"] == $i) {
										                                                                echo "selected";
										                                                            } ?>>
										                            <?php echo ucwords($bulan[$i]) ?></option>
										                    <?php } ?>                 
											            </select>
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">RUMAH</label>
	            						              <div >
	            						               <select class="form-control" name="rumah" id="rumah" required="required">
											            	<option value="">-Pilih Blok-</option>	
																<?php 
															       	$sql_kat = "SELECT CONCAT(Blok,'/',No) as Rumah FROM ms_rumah 
															       					WHERE Blok !='' AND Koordinator = '".$_SESSION["userid"]."'";
															       	$data_kat= $sqlLib->select($sql_kat); 
															       	foreach ($data_kat as $row_kat)
															       	{ ?>
															            <option value="<?php echo $row_kat['Rumah'] ?>" 
															           	<?php if($_POST['rumah']== $row_kat['Rumah']) { echo "selected"; }?>>
															           	<?php echo $row_kat['Rumah'] ?></option>
															        <?php } ?>             
											            </select>
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">NOMINAL</label>
	            						              <div >
	            						               <input type="number" class="form-control" name="nominal" id="nominal" 
	            						               		value="<?php echo $_POST["nominal"] ?>" required="required">
	            						             </div>
	            						        </div>

	            						          
	            						        
	            						    </div>    

	            						    <div class="modal-footer">
	            						    	<input type="hidden" class="form-control" name="pemasukanid" id="pemasukanid" value="<?php echo $_POST["pemasukanid"] ?>">
	            						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	            						          <input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
	            						          <input type="submit" name="Update" value="Update" class="btn btn-primary">
	            						    </div>
            						      </form>
            						    </div>
            						  </div>
            						</div>
            					</div>

            						
		                		<?php
		                		$no++;
		                	}
		                	?>

		                </tbody>

		                <tfoot>
		                	<tr>
		                		<th>GRAND TOTAL</th>
		                		<th style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($t_nominal);?></th>
		                		<?php if($_SESSION["level"]=="1" OR $_SESSION["level"]=="9"){?>
		                		<th>&nbsp;</th>
		                		<?php } ?>
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
        Kumpulan data pemasukan.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>