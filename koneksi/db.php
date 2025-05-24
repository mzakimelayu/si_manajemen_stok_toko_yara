<?php 

// koneksi ke database dengan mysqli

// $koneksi = mysqli_connect("localhost", "root", "", "db_admin");
$koneksi = mysqli_connect("localhost:3308", "root", "", "db_manajemen_stok_toko_yara");

// cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}