<?php

if($_POST["tanggal"]=="") $_POST["tanggal"] = date("d-M-Y");
$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
if ($_POST["tahun"] == "") $_POST["tahun"] = date("Y");
if ($_POST["bulan"] == "") $_POST["bulan"] = date("m")*1;


if(isset($_POST['Update']))
{
	
	$sql_upd = "UPDATE ms_masuk set Tanggal = '".date("Y-m-d",strtotime($_POST['tanggal']))."', 
									Keterangan = '".$_POST['keterangan']."',
									Nominal = '".$_POST['nominal']."'	
				WHERE MasukID ='".$_POST['masukid']."'  ";
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
}

if(isset($_POST['Hapus']))
{
	$sql_del="DELETE FROM ms_masuk WHERE MasukID ='".$_POST['masukid']."'	";
	$run_del=$sqlLib->delete($sql_del);
	if($run_del=="1")
    {
      $alert = '0'; 
      $note = "Proses hapus berhasil";
    }
    else
    {
      $alert = '1'; 
      $note = "Proses hapus gagal";
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
								<select class="form-control" name="tahun" id="tahun" required="required">
						            	<?php
						                    for ($i = 2022; $i <= (date("Y") + 1); $i++) { ?>
						                        <option value="<?php echo $i ?>" <?php if ($_POST["tahun"] == $i) {
						                                                                echo "selected";
						                                                            } ?>><?php echo $i ?></option>
						                    <?php } ?>                
						        </select>
							</div>
							<div class="col-md-2">
								<select class="form-control" name="bulan" id="bulan" required="required">
						            	<?php
						                    for ($i = 1; $i <= 12; $i++) { ?>
						                        <option value="<?php echo $i ?>" <?php if ($_POST["bulan"] == $i) {
						                                                                echo "selected";
						                                                            } ?>>
						                            <?php echo ucwords($bulan[$i]) ?></option>
						                    <?php } ?>                
						            </select>
							</div>

							<div class="col-md-4">
								<button type="submit" name="cari" class="btn btn-primary">Cari</button>
								
								<?php if($_SESSION["level"]=="4" OR $_SESSION["level"]=="9"){?>
									<a href="index.php?m=<?php echo acakacak("encode","bendahara/pemasukan")?>&sm=<?php echo acakacak("encode","add")?>&p=<?php echo acakacak("decode",$_GET["p"]) ?>">
									<button type="button" class="btn btn-success"><i class="fa fa-plus"> </i> Input</button></a>
								<?php }?>	
							</div>
							
							
									
						</form>
				    </div>
            	</div>
            	<!-- /.box-header -->
            	<div class="box-body">
              		<div class="table-responsive">  
              			<table id="example6" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                 
		                  <th>&nbsp;&nbsp;&nbsp;TANGGAL&nbsp;&nbsp;&nbsp;</th>
		                  <th>KETERANGAN</th>
		                  <th>&nbsp;&nbsp;&nbsp;NOMINAL&nbsp;&nbsp;&nbsp;</th>
						  <?php if($_SESSION["level"]=="4" OR $_SESSION["level"]=="9"){?>
		                  <th>EDIT</th>
						  <?php } ?>
		                  
		                </tr>
		                </thead>
		                <tbody>
		                	<?php
		                	$no=1;
		                	$sql = "SELECT a.MasukID,	a.Tanggal, a.Keterangan, a.Nominal	
									FROM ms_masuk a	
									WHERE a.Nominal != ''  ";									
									if($_POST["tahun"]!="") $sql.=" AND YEAR(a.Tanggal) ='".$_POST["tahun"]."' ";
									if($_POST["bulan"]!="") $sql.=" AND MONTH(a.Tanggal) ='".$_POST["bulan"]."' ";										
									$sql.="Order By a.Tanggal asc";		
							$data = $sqlLib->select($sql);
							//echo $sql;
							foreach($data as $row)
							{ 	
								$t_nominal += $row['Nominal'];
								?>
		                		<tr>
									<td style="text-align: left;"><?php echo date("d-M-Y", strtotime($row['Tanggal'])) ?></td>
									<td style="text-align: left;"><?php echo $row['Keterangan'] ?></td>
									<td style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($row['Nominal']) ?></td>
									<?php if($_SESSION["level"]=="4" OR $_SESSION["level"]=="9"){?>
									<td style="text-align: center;">
										<button type="button" class="btn btn-success" data-toggle="modal"
														data-target="#Modaledit<?php echo $row['MasukID']; ?>">
										<i class="fa fa-edit"> </i> Edit</button>
									</td>
									<?php } ?>
								</tr>

								<!--modal edit -->
								<div class="modal fade" id="Modaledit<?php echo $row['MasukID']; ?>" tabindex="-1" role="dialog" 
            						aria-labelledby="exampleModalLabel" aria-hidden="true">
            						<div class="modal-dialog" role="document">
            						    <div class="modal-content">
            						      <div class="modal-header">
            						        <h5 class="modal-title" id="exampleModalLabel">PEMASUKAN</h5>
            						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            						          <span aria-hidden="true">&times;</span>
            						        </button>
            						      </div>
            						      <?php 
            						      	$sql = "SELECT * FROM ms_masuk WHERE MasukID = '".$row['MasukID']."' ";
            						      	$data= $sqlLib->select($sql);
            						      	$_POST['masukid'] = $data[0]['MasukID'];
            						      	$_POST['tanggal'] = date("d-M-Y",strtotime($data[0]['Tanggal']));
            						      	$_POST['keterangan'] = $data[0]['Keterangan'];
            						      	$_POST['nominal'] = $data[0]['Nominal'];

            						      ?>
            						      	<form method="post">
	            						    <div class="modal-body">
	            						      
	            						      	<div class="form-group">
	            						            <label for="status" class="col-form-label">TANGGAL</label>
	            						              <div >
													  <input type="text" name="tanggal" value="<?php echo $_POST["tanggal"]?>" class="form-control tgl pull-right" >
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">KETERANGAN</label>
	            						              <div >
													  <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo $_POST["keterangan"]?>" required="required">	
	            						              </div>
	            						        </div>

	            						        <div class="form-group">
	            						            <label for="status" class="col-form-label">NOMINAL</label>
	            						              <div >
													  <input type="number" class="form-control" name="nominal" id="nominal" value="<?php echo $_POST["nominal"]?>" required="required">
	            						              </div>
	            						        </div>
	            						        
	            						    </div>    

	            						    <div class="modal-footer">
	            						    	<input type="hidden" class="form-control" name="masukid" id="masukid" value="<?php echo $_POST["masukid"] ?>">
	            						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	            						          <input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
	            						          <input type="submit" name="Update" value="Update" class="btn btn-primary">
	            						    </div>
            						      </form>
            						    </div>
            						  </div>
            						</div>
            					</div>

            						
		                		<?php
		                		$no++;
		                	}
		                	?>

		                </tbody>

		                <tfoot>
		                	<tr>
		                		<th colspan="2">GRAND TOTAL</th>
		                		<th style="text-align: right;"><div style="float: left">Rp.</div><?php echo number_format($t_nominal);?></th>
		                		<?php if($_SESSION["level"]=="4" OR $_SESSION["level"]=="9"){?>
		                		<th>&nbsp;</th>
		                		<?php } ?>
		                	</tr>	
		                </tfoot>
		                
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
        Kumpulan data pengeluaran.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>