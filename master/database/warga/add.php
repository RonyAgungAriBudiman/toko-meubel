<?php

if($_POST["tgllahir"]=="") $_POST["tgllahir"] = date("d-M-Y");
if(isset($_POST["simpan"]))
{
	$sql ="INSERT INTO ms_warga (Blok, No, Nama, JenisKelamin, TanggalLahir, Agama, Pekerjaan, HubunganKeluarga, NoKTP, UrutKel)
			VALUES ('".$_POST['blok']."', '".$_POST['no']."', '".$_POST['nama']."', '".$_POST['jeniskelamin']."','".date("Y-m-d", strtotime($_POST['tgllahir']))."' , '".$_POST['agama']."', '".$_POST['pekerjaan']."'
					, '".$_POST['hubkel']."', '".$_POST['noktp']."', '".$_POST['urutkel']."')";
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
							
							<div class="col-md-12">							
							<div class="form-group">							  
							  <div class="col-sm-6">
							  	<label>Nama</label>
								<input type="text" name="nama" required="required" value="<?php echo $_POST["nama"]?>" class="form-control" placeholder="" >
							  </div>

							  <div class="col-sm-3">
							  	<label>Hubungan Keluarga</label>
								<select class="form-control"  name="hubkel" >
			                      	<option value="">Pilih</option>
			                      	<option value="KEPALA KELUARGA" <?php if($_POST['hubkel']=="KEPALA KELUARGA") { echo "selected"; }?> >KEPALA KELUARGA</option>
			                      	<option value="ISTRI" <?php if($_POST['hubkel']=="ISTRI") { echo "selected"; }?> >ISTRI</option>
			                      	<option value="ANAK" <?php if($_POST['hubkel']=="ANAK") { echo "selected"; }?> >ANAK</option>
			                      	<option value="ORANG TUA" <?php if($_POST['hubkel']=="ORANG TUA") { echo "selected"; }?> >ORANG TUA</option>
			                        
			                    </select>
							  </div>
							  <div class="col-sm-3">
							  	<label>Urutan Keluarga</label>
								<select name="urutkel"  class="form-control" >
							  		<option value="">Urut Keluarga</option>	
							  		<option value="1" <?php if($_POST['urutkel']=="1") { echo "selected";} ?>>1</option>	
							  		<option value="2" <?php if($_POST['urutkel']=="2") { echo "selected";} ?>>2</option>	
							  		<option value="3" <?php if($_POST['urutkel']=="3") { echo "selected";} ?>>3</option>	
							  		<option value="4" <?php if($_POST['urutkel']=="4") { echo "selected";} ?>>4</option>	
							  		<option value="5" <?php if($_POST['urutkel']=="5") { echo "selected";} ?>>5</option>	
							  		<option value="6" <?php if($_POST['urutkel']=="6") { echo "selected";} ?>>6</option>	
							  		<option value="7" <?php if($_POST['urutkel']=="7") { echo "selected";} ?>>7</option>	
							  	</select>
							  </div>
							</div> 
					</div>
					<div class="col-md-12">							
						<div class="form-group">							  
						  <div class="col-sm-3">
						  	<label>Blok</label>
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
						  <div class="col-sm-3">
						  	<label>No</label>
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

						  <div class="col-sm-6">
						  	<label>Agama</label>
							<select class="form-control"  name="agama" >
		                      	<option value="">Pilih</option>
		                      	<option value="ISLAM" <?php if($_POST['agama']=="ISLAM") { echo "selected"; }?> >ISLAM</option>
		                      	<option value="KRISTEN" <?php if($_POST['agama']=="KRISTEN") { echo "selected"; }?> >KRISTEN</option>
		                      	<option value="HINDU" <?php if($_POST['agama']=="HINDU") { echo "selected"; }?> >HINDU</option>
		                      	<option value="BUDHA" <?php if($_POST['agama']=="BUDHA") { echo "selected"; }?> >BUDHA</option>
		                      	<option value="KHATOLIK" <?php if($_POST['agama']=="KHATOLIK") { echo "selected"; }?> >KHATOLIK</option>
		                        
		                    </select>
						  </div>
						</div> 
					</div>

					<div class="col-md-12">							
							<div class="form-group">							  
							  <div class="col-sm-6">
							  	<label>Tanggal Lahir</label>
								<input type="text" name="tgllahir" value="<?php echo $_POST["tgllahir"]?>" class="form-control tgl pull-right" >
							  </div>

							  <div class="col-sm-6">
							  	<label>Jenis Kelamin</label>
								<select name="jeniskelamin" required="required" class="form-control" >
							  		<option value="">Jenis Kelamin</option>	
							  		<option value="Laki-laki" <?php if($_POST['jeniskelamin']=="Laki-laki") { echo "selected";} ?>>Laki-laki</option>	
							  		<option value="Perempuan" <?php if($_POST['jeniskelamin']=="Perempuan") { echo "selected";} ?>>Perempuan</option>	
							  	</select>
							  </div>
							</div> 
					</div>

					<div class="col-md-12">							
							<div class="form-group">							  
							  <div class="col-sm-6">
							  	<label>Pekerjaan</label>
								<input type="text" name="pekerjaan" value="<?php echo $_POST["pekerjaan"]?>" class="form-control" >
							  </div>
							  <div class="col-sm-6">
							  	<label>No KTP</label>
								<input type="text" name="noktp" value="<?php echo $_POST["noktp"]?>" class="form-control" >
							  </div>

							  
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