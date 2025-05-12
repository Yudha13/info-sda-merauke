<?php
$servername = "server db anda";
$username = "username db anda";
$password = "isi password db anda";
$dbname = "dbsumberdaya"; // Ganti dengan nama database yang sudah Anda buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
