<?php
include "../sqlLib.php";
$sqlLib = new sqlLib();


// escape your parameters to prevent sql injection
$term = trim(strip_tags($_GET['term']));

// fetch a title for a better user experience maybe..
$sql = "SELECT  CustomerID, NamaCustomer, Alamat, NoTelp, NoKtp
		FROM ms_customer
		WHERE (NamaCustomer LIKE '%" . $term . "%' OR CustomerID LIKE '" . $term . "%') LIMIT 10 ";
$data_brg = $sqlLib->select($sql);
foreach ($data_brg as $data) {


    $row['id'] = $data['CustomerID'];
    $row['value'] = $data['NamaCustomer'];
    $row['namacustomer'] = $data['NamaCustomer'];

    //buat array yang nantinya akan di konversi ke json
    $row_set[] = $row;
}
echo json_encode($row_set);
