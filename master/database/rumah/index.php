<?php
if(isset($_POST['Update']))
{
	$sql_upd = "UPDATE ms_rumah set Status = '".$_POST['status']."', 
									Koordinator = '".$_POST['koordinator']."'	, 
									Pemilik = '".$_POST['pemilik']."'	, 
									NoTelpPemilik	 = '".$_POST['notelp']."'	, 
									DateLog	 = '".date("Y-m-d H:i:s")."'	, 
									UserLog	 = '".$_SESSION["userid"]."'	
				WHERE Blok ='".$_POST['blok']."' AND No = '".$_POST['no']."' ";
	$run_upd = $sqlLib->update($sql_upd);
	if($run_upd=="1")
    {
      $alert = '0'; 
      $note = "Proses update berhasil";
    }
    else
    {
      $alert = '1'; 
      $note = "Proses update gagal";
    }	
    unset($_POST);
				
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
		</li>
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
						<h4><i class="icon fa fa-check"></i> Success!</h4>
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
            		<div class="form-group row">
						<form method="post">
							<div class="col-md-2">
								<select name="blok"  class="form-control">
							  		<option value="">-Pilih Blok-</option>	
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
							<div class="col-md-2">
								<select name="status" class="form-control">
							  		<option value="">-Pilih Status-</option>	
							  		<?php 
				                      	$sql_st = "SELECT DISTINCT Status FROM ms_rumah WHERE Status is not null";
				                      	$data_st= $sqlLib->select($sql_st); 
				                      	foreach ($data_st as $row_st)
				                      	{ ?>
				                        <option value="<?php echo $row_st['Status'] ?>" 
				                        	<?php if($_POST['status']== $row_st['Status']) { echo "selected"; }?>>
				                        	<?php echo $row_st['Status'] ?></option>
				                    <?php } ?>
							  	</select>
							</div>
							
							<div class="col-md-2">
								<button type="submit" name="cari" class="btn btn-primary">Cari</button>
							</div>
						</form>
				    </div>
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example2" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Blok/No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		                  <th>Status</th>
						  <?php if($_SESSION["level"]=="1" OR $_SESSION["level"]=="9"){?>
		                  <th>Edit</th>
						  <?php } ?>
		                  <th>Detail</th>
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
		                	$sql = "SELECT 	a.Blok, a.No, a.Status,a.Pemilik,  a.Koordinator
									FROM ms_rumah a	
									WHERE a.Blok != ''  ";
									if($_POST['blok']!='') $sql.=" AND a.Blok ='".$_POST['blok']."' ";
									if($_POST['status']!='') $sql.=" AND a.Status ='".$_POST['status']."' ";	
									if($_SESSION["level"]=="1") $sql.=" AND a.Koordinator ='".$_SESSION["userid"]."' ";	
									$sql.="Order By a.Blok Asc, a.Urut asc";		
							$data = $sqlLib->select($sql);
							foreach($data as $row)
							{ 	
								$blokno = $row['Blok'].''.$row['No'];
								?>
		                		<tr>
									<td style="text-align: center;"><?php echo $row['Blok'] ?>/<?php echo $row['No'] ?><br><?php echo $row['Pemilik'] ?></td>
									<td style="text-align: center;"><?php echo $row['Status'] ?></td>
									
									<?php if($_SESSION["level"]=="1" OR $_SESSION["level"]=="9"){?>
									<td style="text-align: center;">
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modaledit<?php echo $blokno; ?>"><i class="fa fa-edit"> </i> Edit</button>										
									</td>
									<?php } ?>
									
									<td style="text-align: center;">
										<button type="button" class="btn btn btn-info" data-toggle="modal" data-target="#modal-default<?php echo $blokno; ?>">
												<i class="fa fa-eye"> </i> Lihat
										</button>
									</td>
									
								</tr>

								<!--modal edit -->
								<div class="modal fade" id="Modaledit<?php echo $blokno; ?>" tabindex="-1" role="dialog" 
            						aria-labelledby="exampleModalLabel" aria-hidden="true">
            						<div class="modal-dialog" role="document">
            						    <div class="modal-content">
            						      <div class="modal-header">
            						        <h5 class="modal-title" id="exampleModalLabel">Status Rumah</h5>
            						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            						          <span aria-hidden="true">&times;</span>
            						        </button>
            						      </div>
            						      <?php 
            						      	$sql = "SELECT CONCAT(Blok,'/',No) as BlokNo, Status, Koordinator, Pemilik, NoTelpPemilik, Blok, No 
            						      			FROM ms_rumah WHERE CONCAT(Blok,'',No) = '".$blokno."' ";
            						      	$data= $sqlLib->select($sql);
            						      	$_POST['userid'] = $data[0]['Koordinator'];
            						      	$_POST['pemilik'] = $data[0]['Pemilik'];
            						      	$_POST['notelp'] = $data[0]['NoTelpPemilik'];

            						      ?>
            						      	<form method="post">
	            						    <div class="modal-body">
	            						      
	            						      	<div class="form-group">
	            						            <label for="produk" class="col-form-label">Blok/No</label>
	            						            <input type="text" class="form-control" id="blokno" name="blokno" value="<?php echo $data[0]['BlokNo'] ?>" 
	            						            readonly="readonly">
	            						            <input type="hidden" class="form-control" id="blok" name="blok" value="<?php echo $data[0]['Blok'] ?>" 
	            						            readonly="readonly">
	            						            <input type="hidden" class="form-control" id="no" name="no" value="<?php echo $data[0]['No'] ?>" 
	            						            readonly="readonly">
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">Pemilik</label>
	            						              <div >
	            						              	<input type="text" name="pemilik" class="form-control" value="<?php echo $_POST['pemilik'] ?>">
	            						                
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">No Telp</label>
	            						              <div >
	            						              	<input type="text" name="notelp" class="form-control" value="<?php echo $_POST['notelp'] ?>">
	            						                
	            						              </div>
	            						        </div>
	            						          
	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">Status</label>
	            						              <div >
	            						                <select class="form-control" name="status">
				                                          <?php if($blokno != "")
				                                          { ?> <option value="<?php echo $data[0]['Status'] ?>"><?php echo $data[0]['Status'] ?></option> <?php } ?>
	            						                  <option value="Dihuni">Dihuni</option>
	            						                  <option value="Dikontrak">Dikontrak</option>
	            						                  <option value="Kosong">Kosong</option>
	            						                </select>
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="koordinator" class="col-form-label">Koodinator</label>
	            						              <div >
	            						                <select class="form-control" name="koordinator">
				                                          <option value="">Pilih Koordinator</option>	
													  		<?php 
										                      	$sql_user = "SELECT UserID, Nama FROM ms_user WHERE Aktif ='1' AND Level ='1'";
										                      	$data_user= $sqlLib->select($sql_user); 
										                      	foreach ($data_user as $row)
										                      	{ ?>
										                        	<option value="<?php echo $row['UserID'] ?>" <?php if($_POST['userid']== $row['UserID']) { echo "selected"; }?>>
										                        	<?php echo $row['Nama'] ?>									                        		
										                        	</option>
										                    	<?php } ?>
	            						                </select>
	            						              </div>
	            						        </div>
	            						    </div>    

	            						    <div class="modal-footer">
	            						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	            						          <input type="submit" name="Update" value="Update" class="btn btn-primary">
	            						    </div>
            						      </form>
            						    </div>
            						  </div>
            						</div>
            					</div>

            					<div class="modal fade" id="modal-default<?php echo $blokno ?>">
									<?php
										$sql_d = "SELECT CONCAT(Blok,'/',No) as BlokNo, Status, Koordinator, Pemilik, NoTelpPemilik FROM ms_rumah WHERE CONCAT(Blok,'',No) = '".$blokno."' ";
            						    $data_d= $sqlLib->select($sql_d);
									?>
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Rumah Blok <?php echo $data_d[0]['BlokNo']?></h4>
											</div>
											<div class="modal-body">

												<div class="box-body">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<div class="col-sm-6">
																	<p>Pemilik : <?php echo $data_d[0]['Pemilik'] ?></p>
																	<p>No Telp : <?php echo $data_d[0]['NoTelpPemilik'] ?></p>
																	<p>Koordinator : <?php echo ucwords($data_d[0]['Koordinator']) ?></p>
																</div>
															</div>
														</div>
													</div>

												</div>

												<div class="modal-footer">
													<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
								</div>		
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
        Kumpulan data rumah, dapat melihat status rumah dan penghuni rumah.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>