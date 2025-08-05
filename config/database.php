<?php
$host = 'localhost';
$db   = 'winkur';
$user = 'dev';
$pass = 'terserah';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
