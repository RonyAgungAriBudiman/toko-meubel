<?php 
if($_POST['nonaktif'])
{
  $sql = "UPDATE ms_user SET Aktif = '0'
              WHERE UserID = '".$_POST['userid']."'  ";
  $run =$sqlLib->update($sql); 

    if($run=="1")
    {
        $alert = '0'; 
        $note = "Proses update berhasil";
    }
    else
    {
        $alert = '1'; 
        $note = "Maaf, Proses update gagal";
    }
}
if($_POST['aktifkan'])
{
  $sql = "UPDATE ms_user SET Aktif = '1'
              WHERE UserID = '".$_POST['userid']."'  ";
  $run =$sqlLib->update($sql); 

    if($run=="1")
    {
        $alert = '0'; 
        $note = "Proses update berhasil";
    }
    else
    {
        $alert = '1'; 
        $note = "Maaf, Proses update gagal";
    }
}

if($_POST['reset'])
{
  $sql = "UPDATE ms_user SET Password = '4ca4238a0b9'
              WHERE UserID = '".$_POST['userid']."'  ";
  $run =$sqlLib->update($sql); 

    if($run=="1")
    {
        $alert = '0'; 
        $note = "Proses reset berhasil";
    }
    else
    {
        $alert = '1'; 
        $note = "Maaf, Proses reset gagal";
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
		<a href="index.php?m=<?php echo acakacak("encode","setting/user")?>&sm=<?php echo acakacak("encode","add")?>&p=<?php echo acakacak("decode",$_GET["p"]) ?>">
			<button type="button" class="btn btn-primary"><i class="fa fa-plus"> </i> User</button></a></li>
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
		                  <th>No</th>
		                  <th>UserID</th>
		                  <th>Nama</th>
		                  <th>Aktif</th>
		                  <th>Edit</th>
		                  <th>Aksi</th>
		                  <th>Reset</th>
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
		                	$sql = "SELECT 	a.*
									FROM ms_user a	
									WHERE a.UserID != ''  ";			
							$data = $sqlLib->select($sql);
							foreach($data as $row)
							{ 	
								if($row["Aktif"]=="1")
									{
										$row["Aktif"] = "Ya";
									}
									else
									{
										$row["Aktif"] = "Tidak";
									}
									?>
		                		<tr>
									<td style="text-align: center;"><?php echo $no ?></td>
									<td style="text-align: center;"><?php echo $row['UserID'] ?></td>
									<td style="text-align: center;"><?php echo $row['Nama'] ?></td>
									<td style="text-align: center;"><?php echo $row['Aktif'] ?></td>
									
									<td style="text-align: center;">
										<a href="index.php?m=<?php echo acakacak("encode","setting/user")?>&sm=<?php echo acakacak("encode","edit")?>&userid=<?php echo $row["UserID"]?>&p=<?php echo acakacak("decode",$_GET["p"]) ?>">
											<button type="button" class="btn btn-success"><i class="fa fa-edit"> </i> Edit</button>
										</a>	

									</td>
									<td style="text-align: center;">
										<form method="post">											
			                                <?php if($row['Aktif']=="Ya") {?>
			                                <input type="submit" class="btn btn-danger" name="nonaktif" Value="Non Aktif">
			                                <input type="hidden"  name="userid"   Value="<?php echo $row['UserID'] ?>">
			                                <?php } 
											
											else if ($row['Aktif']=="Tidak")  {?>
			                                <input type="submit" class="btn btn-primary" name="aktifkan"   Value="Aktifkan">
			                                <input type="hidden" name="userid"   Value="<?php echo $row['UserID'] ?>">
			                                <?php } ?>

			                            </form> 

									</td>
									<td style="text-align: center;">
										<form method="post">
											<input type="submit" class="btn btn-warning" name="reset"   Value="Reset">
			                                <input type="hidden" name="userid"   Value="<?php echo $row['UserID'] ?>">
			                            </form> 

									</td>

									
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
        Kumpulan data User, untuk membuat User baru klik tombol +User.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>