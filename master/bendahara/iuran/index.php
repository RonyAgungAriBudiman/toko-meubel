<?php

$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
if ($_POST["tahun"] == "") $_POST["tahun"] = date("Y");
if ($_POST["bulan"] == "") $_POST["bulan"] = date("m");


if($_POST['bulan']<10) $month = "0".$_POST['bulan'];
	else $month = $_POST['bulan'];

if(isset($_POST['simpan']))
{
	$alamat = explode("/", $_POST['rumah']);

	if($_POST['bulan']<10) $month = "0".$_POST['bulan'];
	else $month = $_POST['bulan'];
	
	$sql_save = "INSERT INTO ms_pemasukan (Jenis, Tanggal, Tahun, Bulan, Blok, NoRumah, Nominal, DateLog, UserLog)
					VALUES ('".$_POST['jenis']."', '".date("Y-m-d")."', '".$_POST['tahun']."', '".$month."', '".$alamat[0]."', '".$alamat[1]."', 
							'".$_POST['nominal']."', '".date("Y-m-d H:i:s")."', '".$_SESSION["userid"]."')";
	$run_save = $sqlLib->insert($sql_save);
	if($run_save=="1")
    {
      $alert = '0'; 
      $note = "Proses simpan berhasil";
    }
    else
    {
      $alert = '1'; 
      $note = "Proses simpan gagal";
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
						<h4><i class="icon fa fa-check"></i>Success!</h4>
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
				<form method="post" id="form" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
		  		<div class="box-body">
		  			<div class="col-md-12">
							
							<div class="form-group">
							  <label class="col-sm-2 control-label">JENIS IURAN</label>
							  <div class="col-sm-5">
								<select class="form-control" name="jenis" id="jenis" required="required" onchange="submit();">
			                        <option value="">-Pilih Iuran-</option>
            						<option value="Bulanan" <?php if($_POST['jenis']=="Bulanan") { echo "selected" ; } ?>>Bulanan</option>
            						<option value="THR" <?php if($_POST['jenis']=="THR") { echo "selected" ; } ?>>THR</option>
            						<option value="PHBI" <?php if($_POST['jenis']=="PHBI") { echo "selected" ; } ?>>PHBI</option>
            						<option value="Lainnya" <?php if($_POST['jenis']=="Lainnya") { echo "selected" ; } ?>>Lainnya</option>
            					</select>
							  </div>
							</div> 

							<div class="form-group">
						        <label class="col-sm-2 control-label">TAHUN</label>
						        <div class="col-sm-5">
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
						        <label class="col-sm-2 control-label">BULAN</label>
						        <div class="col-sm-5">
						            <select class="form-control" name="bulan" id="bulan" required="required" onchange="submit();">
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
						        <label class="col-sm-2 control-label">RUMAH</label>
						        <div class="col-sm-5">
						            <select class="form-control" name="rumah" id="rumah" required="required">
						            	<option value="">-Pilih Blok-</option>	
											<?php 
										       	$sql_kat = "SELECT CONCAT(a.Blok,'/',a.No) as Rumah FROM ms_rumah a
										       				WHERE a.Blok !='' AND a.Status !='Kosong' AND a.Koordinator = '".$_SESSION["userid"]."' AND
																CONCAT(a.Blok,'/',a.No) NOT IN (
																		SELECT CONCAT(b.Blok,'/',b.NoRumah) 
																		FROM ms_pemasukan b 
																		WHERE b.Tahun ='".$_POST["tahun"]."' AND b.Bulan ='".$month."' AND b.Jenis ='".$_POST["jenis"]."'  )";
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
						        <label class="col-sm-2 control-label">NOMINAL</label>
						        <div class="col-sm-5">
						        	<input type="number" class="form-control" name="nominal" id="nominal" required="required">
						            
						        </div>
						    </div>

							

							<div class="form-group">
							  <label class="col-sm-2 control-label"></label>
							  <div class="col-sm-3">
							  	 <?php
							        if ($_GET["pemasukanid"] != "") {
							        ?>
							            <input type="submit" class="btn btn-info" name="update" Value="Update">
							            <input type="submit" class="btn btn-danger" name="delete" Value="Delete">
							        <?php
							        } else {
							        ?>

							            <input type="submit" class="btn btn-primary" name="simpan" Value="Simpan">
							            <button type="reset" name="batal" class="btn btn-danger">Batal</button>
							        <?php
							        } ?>
								

							  </div>
							</div>
					</div>	
		  		</div>

		  		
		  	    </form>
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
        Form ini digunakan untuk input uang masuk seperti iuran bulan, THR, PHBI, dan lain-lain.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>