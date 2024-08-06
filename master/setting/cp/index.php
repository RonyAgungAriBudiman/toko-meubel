<?php

if(isset($_POST['Simpan']))
{
 	$password 		= substr(md5($_POST['old_password']), 1,11); 
 	$new_password   = substr(md5($_POST['new_password']), 1,11); 

 	$sql = "SELECT Password FROM ms_user 
 			WHERE UserID = '".$_SESSION['userid']."' AND Password = '".$password."' ";
 	$data= $sqlLib->select($sql);

 	if (count($data)=="1")
 	{
 		$sql_up = "UPDATE ms_user 
 					SET Password = '".$new_password."' 
 					WHERE UserID = '".$_SESSION['userid']."'  ";
 		$run    = $sqlLib->update($sql_up);
 		if($run=="1"){
 			echo '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Password berhasil di ubah</h4>
			  </div>';
 		}else{
 			echo '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-warning"></i> Password gagal di ubah</h4>
			  </div>';
 		}
 	}
 	else
 	{
		echo '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-warning"></i> Proses Gagal Password tidak sesuai</h4>
			  </div>';
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
  </ol>
</div>	



<div class="row">
    <div class="col-xs-12">
         <div class="box box-primary">
            <div class="box-header">
              	<div class="col-md-5">		
			        <form method="post">
					<div class="box-body">
				  
						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">Password Lama</label>
						   <input name="old_password"  class="form-control" type="password" required="required"/>
						</div> 
						
						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">Password Baru</label>
						   <input name="new_password"  class="form-control" type="password" required="required"/>
						</div> 
						
						<div class="box-footer"> 
							<input type="submit" class="btn btn-primary" name="Simpan"   Value="Simpan" />
						</div>
			
             		</div>
					</form>
   				</div>
  		  	</div>
        </div>   
    </div>
</div> 