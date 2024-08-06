<?php

$bulan = array("", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
if ($_POST["tahun"] == "") $_POST["tahun"] = date("Y");
if ($_POST["bulan"] == "") $_POST["bulan"] = date("m");


if ($_POST["jenis"] == "Iuran Bulanan") { ?>

    <div class="form-group">
        <label class="col-sm-2 control-label">TAHUN</label>
        <div class="col-sm-5">
            <select class="form-control" name="tahun" id="tahun" required="required">
            	<?php
                    for ($i = 2022; $i <= (date("Y") + 1); $i++) { ?>
                        <option value="<?php echo $i ?>" <?php if ($_POST["tahun"] == $i) {
                                                                echo "selected";
                                                            } ?>><?php echo $i ?></option>
                    <?php } ?>                
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">BULAN</label>
        <div class="col-sm-5">
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
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">RUMAH</label>
        <div class="col-sm-5">
            <select class="form-control" name="rumah" id="rumah" required="required">
            	<option value="">-Pilih Blok-</option>	
					<?php 
				       	$sql_kat = "SELECT CONCAT(Blok,'/',No) as Rumah FROM ms_rumah WHERE Blok !='' AND Koordinator = '".$_SESSION["userid"]."'";
				       	$data_kat= $sqlLib->select($sql_kat); 
				       	foreach ($data_kat as $row_kat)
				       	{ ?>
				            <option value="<?php echo $row_kat['Rumah'] ?>" 
				           	<?php if($_POST['rumah']== $row_kat['Rumah']) { echo "selected"; }?>>
				           	<?php echo $row_kat['Rumah'] ?></option>
				        <?php } ?>             
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">NOMINAL</label>
        <div class="col-sm-5">
            <select class="form-control" name="nominal" id="nominal" required="required">
            	<option value=""></option>
				<option value="10000" <?php if($_POST['nominal']== "10000") { echo "selected"; }?>>10.000</option>	
            	<option value="15000" <?php if($_POST['nominal']== "15000") { echo "selected"; }?>>15.000</option>	
            	<option value="20000" <?php if($_POST['nominal']== "20000") { echo "selected"; }?>>20.000</option>	
            	<option value="25000" <?php if($_POST['nominal']== "25000") { echo "selected"; }?>>25.000</option>
            	<option value="30000" <?php if($_POST['nominal']== "30000") { echo "selected"; }?>>30.000</option>	
            	<option value="35000" <?php if($_POST['nominal']== "35000") { echo "selected"; }?>>35.000</option>	
            	<option value="40000" <?php if($_POST['nominal']== "40000") { echo "selected"; }?>>40.000</option>	
			</select>
        </div>
    </div>

<?php }



if ($_POST["jenis"] == "Iuran THR") { ?>

    

<?php } 

if ($_POST["jenis"]!='')
{
	?>
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
<?php } ?>