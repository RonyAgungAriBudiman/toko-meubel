<?php
include "../sqlLib.php";
$sqlLib = new sqlLib();


// escape your parameters to prevent sql injection
$term = trim(strip_tags($_GET['term']));

// fetch a title for a better user experience maybe..
$sql = "SELECT  a.BarangID, a.NamaBarang, a.Spesifikasi, a.Merk
		FROM ms_barang a
		WHERE (a.NamaBarang LIKE '%" . $term . "%' OR a.Spesifikasi LIKE '%" . $term . "%' OR a.BarangID LIKE '" . $term . "%') LIMIT 10 ";
$data_brg = $sqlLib->select($sql);
foreach ($data_brg as $data) {


    $row['id'] = $data['BarangID'];
    $row['value'] = $data['NamaBarang'] . ' ' . $data['Spesifikasi'];
    $row['namabarang'] = $data['NamaBarang'];

    //buat array yang nantinya akan di konversi ke json
    $row_set[] = $row;
}
echo json_encode($row_set);
