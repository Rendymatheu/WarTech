<?php

$main_url = "http://localhost/WarTech/";

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "dbpos";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}