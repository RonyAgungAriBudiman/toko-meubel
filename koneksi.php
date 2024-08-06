<?php
$host = "203.175.9.111";
$db   = "intc2668_gsr02";
$user = "intc2668_gsr02";
$password = "123gsr02321#";

$kon = mysqli_connect($host, $user, $password, $db);
if (!$kon) {
    die("Koneksi gagal:" . mysqli_connect_error());
} else {
    echo "Koneksi berhasil";
}
