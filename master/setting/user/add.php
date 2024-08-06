<?php

if(isset($_POST["simpan"]))
{
	$sql_cek ="SELECT UserID FROM ms_user WHERE UserID = '".$_POST["userid"]."' ";
	$data_cek=$sqlLib->select($sql_cek);
	if(count($data_cek)>0) //jika sudah ada
	{
		//gagal simpan
		$alert = '1'; 
	    $note = "Proses simpan gagal, UserID sudah digunakan";

	}
	else
	{

	  	$password = $_POST["userid"];
	  	$password = substr(md5($password), 1, 11);
	  	$sql ="INSERT INTO ms_user (UserID, Password, Nama, Level)
								VALUES ('".$_POST['userid']."', '".$password."', '".$_POST['nama']."', '".$_POST['level']."')";
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

	  	// Ambil Data yang Dikirim dari Form
	  	/*
		$nama = $_FILES['foto']['name'];
		$size = $_FILES['foto']['size'];
		$tipe = $_FILES['foto']['type'];
		$asal = $_FILES['foto']['tmp_name'];

		if (!empty($nama)) {
			$foto = $_POST["userid"] . '.jpg';
		}

		// Set path folder tempat menyimpan gambarnya
		$path = "images/user/" . $foto;		

			if ($tipe == "image/jpeg" || $tipe == "image/jpg") 
	 		{
		 		if ($size <= 10000000) 
			 	{
			 		if (move_uploaded_file($asal, $path)) 
			 		{
						$sql ="INSERT INTO ms_user (UserID, Password, Nama, Level, Image)
								VALUES ('".$_POST['userid']."', '".$password."', '".$_POST['nama']."', '".$_POST['level']."', '".$foto."')";
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
					else 
			 		{
			 			$alert = 1;
			 			$note  = "Maaf, Gambar gagal untuk diupload.";
			 		}
			 	} 
			 	else
			 	{
		 			$alert = 1;
		 		    $note  = "Maaf, Ukuran gambar yang diupload tidak boleh lebih dari 10MB.";
		 		}
	 		} 
	 		else
	 		{
	 			$alert = 1;
	 			$note  = "Maaf, Tipe gambar yang diupload harus JPG / JPEG.";
	 		}	
	 		*/
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
							  <label class="col-sm-2 control-label">UserID</label>
							  <div class="col-sm-5">
								<input type="text" name="userid" required="required" value="<?php echo $_POST["userid"]?>" class="form-control" placeholder="" >
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama</label>
							  <div class="col-sm-5">
								<input type="text" name="nama" required="required" value="<?php echo $_POST["nama"]?>" class="form-control" placeholder="" >
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-2 control-label">Level</label>
							  <div class="col-sm-5">
							  	<select name="level" required="required" class="form-control" >
							  		<option value="">Pilih Level</option>	
							  		<option value="0" <?php if($_POST['level']=="0") { echo "selected";} ?>>Pengguna</option>	
							  		<option value="1" <?php if($_POST['level']=="1") { echo "selected";} ?>>Petugas</option>	
							  	</select>
								
							  </div>
							</div> 

							<!-- <div class="form-group">
								<label class="col-sm-2 control-label">Foto</label>
								<div class="col-sm-5">
									<input type="file" name="foto" accept="image/png, image/jpeg">
									<p style="color: red">Ekstensi yang diperbolehkan .jpg | .jpeg</p>
								</div>
							</div> -->

							

							<div class="form-group">
							  <label class="col-sm-2 control-label"></label>
							  <div class="col-sm-3">
							  	<input type="submit" class="btn btn-primary" name="simpan"   Value="Simpan">
								<button type="reset" name="batal" class="btn btn-danger">Batal</button>
							  </div>
							</div> 
					</div>	
		  		</div>
		  	    </form>
		  	</div>
		</div>
</div>

