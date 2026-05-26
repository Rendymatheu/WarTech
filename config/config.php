<?php
// Deteksi via environment variable APP_ENV
if (getenv('APP_ENV') === 'production') {
    $main_url = "/";
} else {
    $main_url = "/WarTech/";
}

$host = getenv('MYSQLHOST')     ?: "127.0.0.1";
$user = getenv('MYSQLUSER')     ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "";
$db   = getenv('MYSQLDATABASE') ?: "dbpos";
$port = getenv('MYSQLPORT')     ?: 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}