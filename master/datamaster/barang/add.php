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
					<div class="form-group">							  
						<div class="col-sm-6">
							<label>Nama Barang</label>
							<input type="text" name="namabarang" required="required" value="<?php echo $_POST["namabarang"]?>" class="form-control" placeholder="" >
						</div>

						<div class="col-sm-6">
							&nbsp;
						</div>
					</div> 
				</div>
				<div class="col-md-12">
					<div class="form-group">							  
						<div class="col-sm-6">
							<label>Spesifikasi</label>
							<input type="text" name="spesifikasi" required="required" value="<?php echo $_POST["spesifikasi"]?>" class="form-control" placeholder="" >
						</div>

						<div class="col-sm-6">
							&nbsp;
						</div>
					</div> 
				</div>
				<div class="col-md-12">
					<div class="form-group">							  
						<div class="col-sm-6">
							<label>Merk</label>
							<input type="text" name="merk" required="required" value="<?php echo $_POST["merk"]?>" class="form-control" placeholder="" >
						</div>

						<div class="col-sm-6">
							&nbsp;
						</div>
					</div> 
				</div>
						
				<div class="col-md-12">
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