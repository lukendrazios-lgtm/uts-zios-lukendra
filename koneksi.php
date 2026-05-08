<?php
// Pengaturan database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_toko_produk";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>