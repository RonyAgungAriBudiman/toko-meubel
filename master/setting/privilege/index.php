
<?php
if(isset($_POST['simpan']))
{
    
    $cekbox     = $_POST["cekbox"]; 
    $sql_del    ="DELETE FROM ms_privilege WHERE UserID ='".$_POST['user']."'  AND Nav1 ='".$_POST['module']."'  ";
    $run_del    = $sqlLib->delete($sql_del);

    $sukses = false;    
    for($i=1;$i<=$cekbox;$i++)
    {
        $cb = $_POST['chk'.$i];
        if ($cb !="")
        {
            
            $navid      = $_POST["navid".$i];

            $sql_save = "INSERT INTO ms_privilege (NavID, UserID, Nav1) VALUES ('".$navid."','".$_POST['user']."' ,'".$_POST['module']."' )";
            $run      = $sqlLib->insert($sql_save);
        }
    }
    $sukses = true; 

    if($sukses)
    {
        $alert = '0'; 
        $note = "Proses simpan berhasil";
    }
    else
    {
        $alert = '1'; 
        $note = "Maaf, Proses simpan gagal";
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
	<li><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Info </button> &nbsp; </li>
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
							  	<label>User ID</label>
								<select name="userid" required="required" class="form-control" onchange="submit();">
							  		<option value="">Pilih User</option>	
							  		<?php 
				                      	$sql_user = "SELECT UserID FROM ms_user WHERE Aktif ='1'";
				                      	$data_user= $sqlLib->select($sql_user); 
				                      	foreach ($data_user as $row)
				                      	{ ?>
				                        <option value="<?php echo $row['UserID'] ?>" <?php if($_POST['userid']== $row['UserID']) { echo "selected"; }?>>
				                        	<?php echo $row['UserID'] ?></option>
				                    <?php } ?>
							  	</select>

							  </div>

							  <div class="col-sm-6">
							  	<label>Modul</label>
								<select class="form-control"  name="nav" onchange="submit();">
			                      	<option value="">Pilih Modul</option>
			                      	<?php 
			                      	$sql_modul = "SELECT DISTINCT Nav1 FROM ms_nav";
			                      	$data_modul= $sqlLib->select($sql_modul); 
			                      	foreach ($data_modul as $nav)
			                      	{ ?>
			                        <option value="<?php echo $nav['Nav1'] ?>" <?php if($_POST['nav']==$nav['Nav1']) { echo "selected"; }?> ><?php echo $nav['Nav1'] ?></option>
			                        <?php } ?>
			                    </select>
							  </div>
							</div> 
					</div>


		  			<div class="col-md-12">	
		  				<div class="table-responsive">
	                      <table class="table table-sm">
	                        <thead>
	                          <tr>
	                            <th scope="col">#</th>
	                            <th scope="col">Module</th>
	                            <th scope="col">Menu</th>
	                            <th scope="col">Aktif</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        	<?php
	                        	$no=1;
	                        	$sql_1 = "SELECT a.NavID, a.Nav1, a.Nav2 FROM ms_nav a WHERE a.Nav1 ='".$_POST['nav']."' ";
	                        	$data_1= $sqlLib->select($sql_1);
	                        	foreach ($data_1 as $row) { 
	                        		$sql_2 ="SELECT a.NavID, a.UserID FROM ms_privilege a WHERE a.NavID = '".$row['NavID']."' AND a.UserID = '".$_POST['userid']."' ";
	                        		$data_2=$sqlLib->select($sql_2);
	                        		?>

	                        		<tr>
			                            <th scope="row"><?php echo $no ?></th>
			                            <td><?php echo $row['Nav1'] ?></td>
			                            <td><?php echo $row['Nav2'] ?></td>
			                            <td><input type="checkbox" name="chk<?php echo $no ?>" <?php if($data_2[0]['NavID']!=""){ echo "checked"; } ?>>
			                            	<input type="hidden" name="navid<?php echo $no ?>" value="<?php echo $row['NavID'] ?>">
			                            	</td>
			                          </tr>

	                        		<?php
	                        		$no++;
	                        	}
	                        	?>  
	                        	<input type="hidden" name="cekbox" value="<?php echo $no; ?>">  
	                        	<input type="hidden" name="module" value="<?php echo $_POST['nav']; ?>">  
	                            <input type="hidden" name="user" value="<?php echo $_POST['userid']; ?>">                        
	                        </tbody>

	                      </table>
                    	</div>
		  			</div>	
					
		  			<div class="col-md-12">	
							<div class="form-group">
							  
							  <div class="col-sm-12">
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
        Hak akses untuk setiap user berbeda-beda, beri tanda checklist untuk membuka akses kepada user.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>