<?php

if(isset($_POST["simpan"]))
{

	$sql = "UPDATE ms_user SET Nama = '".$_POST['nama']."',
								Level = '".$_POST['level']."'
							WHERE UserID = '".$_POST['userid']."'	 ";
	$run =$sqlLib->update($sql); 

		if($run=="1")
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


if($_GET["userid"] != "")
{
	$sql_user = "SELECT a.* FROM ms_user a WHERE a.UserID = '".$_GET['userid']."' ";
	$data_user= $sqlLib->select($sql_user);
	$_POST['userid'] = $data_user[0]['UserID'];
	$_POST['nama']   = $data_user[0]['Nama'];
	$_POST['level']  = $data_user[0]['Level'];	
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
							  <label class="col-sm-2 control-label">UserID</label>
							  <div class="col-sm-5">
								<input type="text" name="userid" required="required" value="<?php echo $_POST["userid"]?>" class="form-control" placeholder="" readonly >
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
