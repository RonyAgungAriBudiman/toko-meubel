
<?php

if($_POST["tanggal"]=="") $_POST["tanggal"] = date("d-M-Y");
if($_POST["estimasi"]=="") $_POST["estimasi"] = date("d-M-Y"); 
if($_POST["nopo"]=="")
{
    $sql_1="SELECT SUBSTRING(NoPO,9,5) NoPO FROM ms_po 
            WHERE YEAR(TanggalPO) = '".date("Y")."'
        	Order By SUBSTRING(NoPO,9,5) Desc Limit 1";
	$data_1=$sqlLib->select($sql_1);
	$urut = strtok($data_1[0]['ms_po'], "0")+ 1;
	$_POST["nopo"] = "PO/".date("Y")."/".str_pad($urut, 5, '0', STR_PAD_LEFT);



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
		


        <div class="col-sm-6">	  		
			<div class="box box-primary">
				<form method="post" id="form" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
		  		<div class="box-body">
		  			<div class="col-md-12">	
		  					
							<div class="form-group">
							    <label class="col-sm-3 control-label">Nama Barang</label>
							    <div class="col-sm-6">
                                    <select name="barangid" id="barangid" class="form-control">
                                    <option value="">Pilih Barang</option>
                                    <?php
                                    $sql_2 = "SELECT DISTINCT BarangID, NamaBarang, Spesifikasi FROM ms_barang ";
                                    $data_2 = $sqlLib->select($sql_2);
                                    foreach ($data_2 as $row_2) {
                                    ?><option value="<?php echo $row_2['BarangID'] ?>" <?php if ($_POST['barangid'] == $row_2['BarangID']) {
                                                                                        echo "selected";
                                                                                    } ?>><?php echo $row_2['NamaBarang'] ?> <?php echo $row_2['Spesifikasi'] ?></option> <?php
                                                                                                                            }
                                                                                                                                ?>
                                    </select>
							    </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-3 control-label">Qty</label>
							  <div class="col-sm-6">
								<input type="number" name="qty" id="Qty" required="required" value="<?php echo $_POST["qty"]?>" class="form-control" placeholder="0" >
								<input type="hidden" name="nopo_tmp" value="<?php echo $_POST["nopo"]?>"  class="form-control" placeholder="" readonly>
							  </div>
							</div> 

                            <div class="form-group">
							  <label class="col-sm-3 control-label">Harga Barang</label>
							  <div class="col-sm-6">
								<input type="number" name="harga" id="harga" required="required" value="<?php echo $_POST["harga"]?>" class="form-control" placeholder="0" >
							  </div>
							</div> 
							
							<div class="form-group">
							  <label class="col-sm-3 control-label"></label>
							  <div class="col-sm-6">
							  	<input type="submit" class="btn btn-primary" name="tambah" Value="Tambah">
								<button type="reset" name="batal" class="btn btn-danger">Batal</button>
							  </div>
							</div> 
					</div>	
		  		</div>
		  	    </form>
		  	</div>
		</div>

		<div class="col-sm-6">	  		
			<div class="box box-primary">
				<form method="post" id="form" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
		  		<div class="box-body">
		  			<div class="col-md-12">
		  					<div class="form-group">
							  <div class="col-sm-6">
								  <label class="col-sm-4 control-label">No PO</label>
								  <div class="col-sm-8">
									<input type="text" name="nopo" value="<?php echo $_POST["nopo"]?>"  class="form-control" placeholder="" readonly>
									<input type="hidden" name="urut" value="<?php echo $_POST["urut"]?>"  class="form-control" placeholder="" readonly>
								  </div>
							   </div>  
							   <div class="col-sm-6">
								  <label class="col-sm-4 control-label">Due Date</label>
								  <div class="col-sm-8">
									<input type="text" name="estimasi" value="<?php echo $_POST["estimasi"]?>" class="form-control tgl pull-right" >
								  </div>
							   </div>  
                               
							</div> 
							</div>

							<div class="form-group">								
							    <div class="col-sm-6">
								  <label class="col-sm-4 control-label">Nama</label>
								  <div class="col-sm-8">
									<input type="text" name="nama" required="required" value="<?php echo $_POST["nama"]?>" class="form-control" placeholder="" >
								  </div>
								</div>  
							    <div class="col-sm-6">
								  <label class="col-sm-4 control-label">NoHp</label>
								  <div class="col-sm-8">
									<input type="number" name="nohp" required="required" value="<?php echo $_POST["nohp"]?>" class="form-control" placeholder="" >
								  </div>
								</div>  
							</div> 

							<div class="table-responsive">
							<table class="table table-hover">
							  <thead>
							    <tr>
							      <th scope="col" width="5%">#</th>
							      <th scope="col" width="15%">Paket</th>
							      <th scope="col" width="15%">Harga</th>
							      <th scope="col" width="10%">Qty</th>
							      <th scope="col" width="15%">Total</th>
							      <th scope="col" width="5%"></th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php
							  		$no=1;
							  		$sql_dt="SELECT a.*, b.Paket, a.Harga*a.Qty as Total
							  				 FROM tr_order_tmp a 
							  					LEFT JOIN ms_paket	b on b.PaketID = a.PaketID
							  					WHERE a.OrderNo = '".$_POST['orderno']."'		";
							  		$data_dt=$sqlLib->select($sql_dt);
							  		foreach ($data_dt as $row_dt) {
							  			?>
									    <tr>
									      <th scope="row"><?php echo $no ?></th>
									      <td><?php echo $row_dt['Paket'] ?></td>
									      <td><?php echo number_format($row_dt['Harga']) ?></td>
									      <td><?php echo $row_dt['Qty'] ?></td>
									      <td><?php echo number_format($row_dt['Total']) ?></td>
									      <td>
									      	<form method="post">
									      		<button type="submit" name="delete" class="btn btn-danger"><i class="fa fa-trash-o"> </i></button>
									      		<input type="hidden" name="seq" value="<?php echo $row_dt['Seq'] ?>">
									      	</form>
									      </td>
									    </tr> <?php $no++;
									    $gt += $row_dt['Total'];
							  		}			
							  	?>
							    
							  </tbody>
							  <tfoot>
							  	<tr>
							      <th scope="col" colspan="4">Grand Total</th>
							      <th scope="col"><?php echo number_format($gt) ?>
							      	<input type="hidden" name="gt" value="<?php echo $gt ?>">
							      </th>
							    </tr>
							  </tfoot>
							</table>
						    </div>

							<div class="form-group">
							  <label class="col-sm-8 control-label">Jenis Pembayaran</label>
							  <div class="col-sm-4">
							  	<select name="jenisbayar" class="form-control" >
							  		<option value=""></option>	
							  		<option value="BON" <?php if($_POST['level']=="BON") { echo "selected";} ?>>BON</option>
							  		<option value="DP" <?php if($_POST['level']=="DP") { echo "selected";} ?>>DP</option>	
							  		<option value="Penuh" <?php if($_POST['level']=="Penuh") { echo "selected";} ?>>Penuh</option>	
							  	</select>								
							  </div>
							</div> 

							<div class="form-group">
							  <label class="col-sm-8 control-label">Nominal Bayar</label>
							  <div class="col-sm-4">
							  	<input type="number" name="nominal"  value="<?php echo $_POST["nominal"]?>" class="form-control" >
							  </div>
							</div> 

							

							<div class="form-group">
							  <label class="col-sm-8 control-label"></label>
							  <div class="col-sm-4">
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



<script>
	$(document).ready(function() {
		var ac_config = {
			source: "json/barang.php",
			select: function(event, ui) {
				$("#barangid").val(ui.item.id);
				$("#namabarang").val(ui.item.namabarang);
			},
			focus: function(event, ui) {
				$("#barangid").val(ui.item.id);
				$("#namabarang").val(ui.item.namabarang);
			},
			minLength: 1
		};
		$("#namabarang").autocomplete(ac_config);
	});
</script>