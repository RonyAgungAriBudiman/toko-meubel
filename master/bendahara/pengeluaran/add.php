<?php

if($_POST["tanggal"]=="") $_POST["tanggal"] = date("d-M-Y");


if(isset($_POST['simpan']))
{
	$sql_save = "INSERT INTO ms_pengeluaran (Tanggal, Keterangan, Nominal, Approve, DateLog, UserLog)
					VALUES ('".date("Y-m-d", strtotime($_POST['tanggal']))."', '".$_POST['keterangan']."', '".$_POST['nominal']."', '1','".date("Y-m-d H:i:s")."', '".$_SESSION["userid"]."')";
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
							  <label class="col-sm-2 control-label">TANGGAL</label>
							  <div class="col-sm-5">
							  	<input type="text" name="tanggal" value="<?php echo $_POST["tanggal"]?>" class="form-control tgl pull-right" >
								
							  </div>
							</div> 

							<div class="form-group">
						        <label class="col-sm-2 control-label">KETERANGAN</label>
						        <div class="col-sm-5">
						        	<input type="text" class="form-control" name="keterangan" id="keterangan" required="required">						            
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
        Form ini digunakan untuk input pengeluaran.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>