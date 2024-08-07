<?php

if($_POST["tgllahir"]=="") $_POST["tgllahir"] = date("d-M-Y");
if(isset($_POST["simpan"]))
{
	$sql_1="SELECT SUBSTRING(SupplierID,4,5) SupplierID FROM ms_supplier
        	Order By SUBSTRING(SupplierID,4,5) Desc Limit 1";
	$data_1=$sqlLib->select($sql_1);
	$urut = strtok($data_1[0]['SupplierID'], "0")+ 1;
	$supplierid = "SUP".str_pad($urut, 5, '0', STR_PAD_LEFT);

	//echo $supplierid.'-'.$urut;

	//cek nama barang
	$sql_2="SELECT NamaSupplier FROM ms_supplier WHERE NamaSupplier = '".$_POST['namasupplier']."' ";
	$data_2=$sqlLib->select($sql_2);
	if(COUNT($data_2)<1)
	{
		$sql ="INSERT INTO ms_supplier (SupplierID, NamaSupplier, Alamat, NoTelp, RecUser, CreateTime)
			VALUES ('".$supplierid."', '".$_POST['namasupplier']."', '".$_POST['alamat']."', '".$_POST['notelp']."','".$_SESSION['userid']."','".date("Y-m-d H:i:s")."' )";
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

	}else{
		$alert = '1'; 
	    $note = "Proses simpan gagal, nama supplier sudah ada";
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
							<label>Nama Supplier</label>
							<input type="text" name="namasupplier" required="required" value="<?php echo $_POST["namasupplier"]?>" class="form-control" placeholder="" >
						</div>

						<div class="col-sm-6">
							&nbsp;
						</div>
					</div> 
				</div>
				<div class="col-md-12">
					<div class="form-group">							  
						<div class="col-sm-6">
							<label>Alamat</label>
							<input type="text" name="alamat" required="required" value="<?php echo $_POST["alamat"]?>" class="form-control" placeholder="" >
						</div>

						<div class="col-sm-6">
							&nbsp;
						</div>
					</div> 
				</div>
				<div class="col-md-12">
					<div class="form-group">							  
						<div class="col-sm-6">
							<label>No Telp</label>
							<input type="text" name="notelp" required="required" value="<?php echo $_POST["notelp"]?>" class="form-control" placeholder="" >
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