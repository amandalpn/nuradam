<?php
// File: koneksi.php

$host = 'qhhujc.h.filess.io';
$port = 3307;
$database = 'choclouddb_bravetouch';
$username = 'choclouddb_bravetouch';
$password = '5a86f8035230cbb781e526d9b0b95966b51f73c7';

// Membuat koneksi menggunakan MySQLi
$koneksi = new mysqli($host, $username, $password, $database, $port);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Mengatur charset ke utf8mb4 untuk mendukung berbagai karakter
$koneksi->set_charset("utf8mb4");
?>