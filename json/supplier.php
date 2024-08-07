<?php
include "../sqlLib.php";
$sqlLib = new sqlLib();


// escape your parameters to prevent sql injection
$term = trim(strip_tags($_GET['term']));

// fetch a title for a better user experience maybe..
$sql = "SELECT  SupplierID, NamaSupplier, Alamat, NoTelp, RecUser
		FROM ms_supplier
		WHERE (NamaSupplier LIKE '%" . $term . "%' OR SupplierID LIKE '" . $term . "%') LIMIT 10 ";
$data_brg = $sqlLib->select($sql);
foreach ($data_brg as $data) {


    $row['id'] = $data['SupplierID'];
    $row['value'] = $data['NamaSupplier'];
    $row['namasupplier'] = $data['NamaSupplier'];

    //buat array yang nantinya akan di konversi ke json
    $row_set[] = $row;
}
echo json_encode($row_set);
