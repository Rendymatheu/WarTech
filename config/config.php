<?php
// Mengambil kredensial dari Railway Environment Variables, jika tidak ada baru pakai localhost (untuk backup)
$host     = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: 'GpwzPVMaGfjEkkSHocssljrpPHStEqzy';
$database = getenv('MYSQLDATABASE') ?: 'railway';
$port     = getenv('MYSQLPORT') ?: 3306;

// Line 8 yang sebelumnya error, ubah menjadi seperti ini:
$koneksi = new mysqli($host, $user, $password, $database, $port);

// Cek koneksi jika gagal
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
