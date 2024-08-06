<?php

if($_POST["tgllahir"]=="") $_POST["tgllahir"] = date("d-M-Y");
if(isset($_POST["simpan"]))
{
	$sql ="INSERT INTO ms_warga (Blok, No, Nama, JenisKelamin, TanggalLahir)
			VALUES ('".$_POST['blok']."', '".$_POST['no']."', '".$_POST['nama']."', '".$_POST['jeniskelamin']."','".date("Y-m-d", strtotime($_POST['tgllahir']))."')";
	$run =$sqlLib->insert($sql); 
	if($run=="1")
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
	<?php echo $_GET["p"] ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active"><?php echo $_GET["p"] ?></li>
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
				<form method="post" id="form" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
		  		<div class="box-body">
		  			<div class="col-md-12">
							
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama</label>
							  <div class="col-sm-5">
								<input type="text" name="nama" required="required" value="<?php echo $_POST["nama"]?>" class="form-control" placeholder="" >
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">Blok</label>
							  <div class="col-sm-5">
							  	<select name="blok" required="required" class="form-control" >
							  		<option value="">Pilih Blok</option>	
							  		<?php 
				                      	$sql_kat = "SELECT DISTINCT Blok FROM ms_rumah WHERE Blok !=''";
				                      	$data_kat= $sqlLib->select($sql_kat); 
				                      	foreach ($data_kat as $row_kat)
				                      	{ ?>
				                        <option value="<?php echo $row_kat['Blok'] ?>" 
				                        	<?php if($_POST['blok']== $row_kat['Blok']) { echo "selected"; }?>>
				                        	<?php echo $row_kat['Blok'] ?></option>
				                    <?php } ?>	
							  	</select>								
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">No</label>
							  <div class="col-sm-5">
							  	<select name="no" required="required" class="form-control" >
							  		<option value="">Pilih Nomor</option>	
							  		<?php 
				                      	$sql_no = "SELECT DISTINCT No FROM ms_rumah WHERE No !='' Order By Urut asc";
				                      	$data_no= $sqlLib->select($sql_no); 
				                      	foreach ($data_no as $row_no)
				                      	{ ?>
				                        <option value="<?php echo $row_no['No'] ?>" 
				                        	<?php if($_POST['no']== $row_no['No']) { echo "selected"; }?>>
				                        	<?php echo $row_no['No'] ?></option>
				                    <?php } ?>	
							  	</select>								
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">Jenis Kelamin</label>
							  <div class="col-sm-5">
							  	<select name="jeniskelamin" required="required" class="form-control" >
							  		<option value="">Jenis Kelamin</option>	
							  		<option value="Laki-laki" <?php if($_POST['jeniskelamin']=="Laki-laki") { echo "selected";} ?>>Laki-laki</option>	
							  		<option value="Perempuan" <?php if($_POST['jeniskelamin']=="Perempuan") { echo "selected";} ?>>Perempuan</option>	
							  	</select>
								
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">Tanggal Lahir</label>
							  <div class="col-sm-5">
							  <input type="text" name="tgllahir" value="<?php echo $_POST["tgllahir"]?>" class="form-control tgl pull-right" >
							  </div>
							</div>

							

							

							<div class="form-group">
							  <label class="col-sm-2 control-label"></label>
							  <div class="col-sm-3">
							  	<input type="submit" class="btn btn-primary" name="simpan" Value="Simpan">
								<button type="reset" name="batal" class="btn btn-danger">Batal</button>
							  </div>
							</div> 
					</div>	
		  		</div>
		  	    </form>
		  	</div>
		</div>
</div>