<?php
if ($_POST["page"] == "") $_POST["page"] = 1;

$kondisi = "";
if ($_POST['namasupplier'] != "" and $_POST['supplierid'] != "") $kondisi .= " AND a.SupplierID ='" . $_POST['supplierid'] . "'";

$sql_count = "SELECT COUNT(a.SupplierID) as JmlData
				FROM ms_supplier a	
				WHERE a.NamaSupplier != '' " . $kondisi;
$data_count = $sqlLib->select($sql_count);

$jml_data = $data_count[0]["JmlData"];
$jml_row = "10";
$jml_page = ceil($jml_data / $jml_row);
if ($jml_page == 0) $jml_page = 1;

$page = ($_POST["page"] - 1);
$dari = ($page * $jml_row);

$sql = "SELECT a.SupplierID, a.NamaSupplier, a.Alamat, a.NoTelp
			FROM ms_supplier a	
			WHERE a.NamaSupplier != '' " . $kondisi;
$sql .= "ORDER BY a.NamaSupplier ASC LIMIT " . $dari . "," . $jml_row;
$data = $sqlLib->select($sql);


?>

<div class="header">
	<h1>
		<?php echo acakacak("decode", $_GET["p"]) ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> dashboard</a></li>
		<li class="active"><?php echo acakacak("decode", $_GET["p"]) ?></li>
		<li><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Info </button> &nbsp;
			<a href="index.php?m=<?php echo acakacak("encode", "datamaster/supplier") ?>&sm=<?php echo acakacak("encode", "add") ?>&p=<?php echo acakacak("decode", $_GET["p"]) ?>">
				<button type="button" class="btn btn-primary"><i class="fa fa-plus"> </i> Supplier</button></a>

		</li>
	</ol>
</div>


<div class="row">
	<div class="col-sm-12">
		<?php
		if ($alert == "0") {
		?><div class="form-group">
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Alert!</h4>
					<?php echo $note ?>
				</div>
			</div><?php
				} else if ($alert == "1") {
					?><div class="form-group">
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-warning"></i> Alert!</h4>
					<?php echo $note ?>
				</div>
			</div><?php
				}
					?>

		<div class="box box-primary">
			<div class="box-header">
				<div class="form-group row">
					<form method="post">
						<div class="col-md-2">
							<select name="supplierid" id="supplierid" class="form-control">
								<option value="">Pilih Supplier</option>
								<?php
								$sql_2 = "SELECT DISTINCT SupplierID, NamaSupplier FROM ms_supplier ";
								$data_2 = $sqlLib->select($sql_2);
								foreach ($data_2 as $row_2) {
								?><option value="<?php echo $row_2['SupplierID'] ?>" <?php if ($_POST['supplierid'] == $row_2['SupplierID']) {
																					echo "selected";
																				} ?>><?php echo $row_2['NamaSupplier'] ?></option> <?php
																														}
																															?>
							</select>
						</div>
						
						<div class="col-md-2">
							<button type="submit" name="cari" class="btn btn-primary"> <i class="fa fa-search"> </i> Cari</button>
						</div>

						<div class="col-6">
							<div style="float:right; white-space: nowrap ">
								Page
								<select name="page" class="form-control" style="width:auto; display:inline; margin-right:35px" onchange="submit();">
									<?php
									for ($p = 1; $p <= $jml_page; $p++) { ?>
										<option value="<?php echo $p ?>" <?php if ($_POST["page"] == $p) {
																				echo "selected";
																			} ?>><?php echo $p ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

					</form>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Nama Supplier</th>
								<th>Alamat</th>
								<th>No Telp</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$no = 1;
							foreach ($data as $row) {
							?>
								<tr>
									<td style="text-align: left	;"><?php echo $row['NamaSupplier'] ?></td>
									<td style="text-align: left;"><?php echo $row['Alamat'] ?></td>
									<td style="text-align: left;"><?php echo $row['NoTelp'] ?></td>
									<?php if ($_SESSION["level"] == "9") { ?>
										<td style="text-align: center;">
											<a href="index.php?m=<?php echo acakacak("encode", "datamaster/supplier") ?>&sm=<?php echo acakacak("encode", "edit") ?>&supplierid=<?php echo $row['SupplierID'] ?>&p=<?php echo acakacak("decode", $_GET["p"]) ?>">
												<button type="button" class="btn btn-success"><i class="fa fa-edit"> </i> Edit</button>
											</a>
										</td>
									<?php } ?>
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
				<h5 class="modal-title" id="exampleModalLabel">Modul <?php echo acakacak("decode", $_GET["p"]) ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Berisi data supplier, dapat melakukan input data supplier dan update data supplier
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>




<script>
	$(document).ready(function() {
		var ac_config = {
			source: "json/supplier.php",
			select: function(event, ui) {
				$("#supplierid").val(ui.item.id);
				$("#namasupplier").val(ui.item.namasupplier);
			},
			focus: function(event, ui) {
				$("#supplierid").val(ui.item.id);
				$("#namasupplier").val(ui.item.namasupplier);
			},
			minLength: 1
		};
		$("#namasupplier").autocomplete(ac_config);
	});
</script>