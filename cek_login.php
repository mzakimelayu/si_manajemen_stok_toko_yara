<?php

// mulai session
session_start();

// koneksi ke database
include 'koneksi/db.php';

// redirect ke halaman dashboard
function base_url($path = '') {
    $host = $_SERVER['HTTP_HOST'];
    
    // Jika menggunakan Ngrok, paksa HTTPS
    if (strpos($host, "ngrok-free.app") !== false) {
        $protocol = "https";
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    }

    $project_folder = "/si_manajemen_stok_toko_yara/"; 

    return $protocol . '://' . $host . $project_folder . $path;
}

// cek session
if (!isset($_SESSION['dataPengguna'])) {
    // simpan pesan ke session
    $_SESSION['pesan_login'] = "Sesi Anda Berakhir, Silahkan login terlebih dahulu!";
    // jika session username tidak ada, redirect ke halaman login
    header("Location: " . base_url('login.php'));
    exit();
}

// Untuk Judul Setiap Halaman
$judul_utama = $judul_halaman . " | Sistem Informasi Manajemeen STOK Barang";

$sesi_id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];
$sesi_username_pengguna = $_SESSION['dataPengguna']['username_pengguna'];
$sesi_nama_lengkap_pengguna = $_SESSION['dataPengguna']['nama_lengkap_pengguna'];
$sesi_role_pengguna = $_SESSION['dataPengguna']['role_pengguna'];

// cek hak akses berdasarkan role
if ($sesi_role_pengguna == "kasir") {
    // jika role kasir mencoba akses halaman terlarang
    if (strpos($_SERVER['REQUEST_URI'], '/barang/') !== false || 
        strpos($_SERVER['REQUEST_URI'], '/kategori/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_pembelian/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_penjualan/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_stok_keluar/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_stok_masuk/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/pembelian/') !== false || 
        strpos($_SERVER['REQUEST_URI'], '/pengguna/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/satuan/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/supplier/') !== false) {

        header("Location: " . base_url('403.php'));
        exit();
    }
}else if ($sesi_role_pengguna == "pemilik") {
    // jika role admin mencoba akses halaman terlarang
    if (strpos($_SERVER['REQUEST_URI'], '/penjualan/') !== false || 
        strpos($_SERVER['REQUEST_URI'], '/pelanggan/') !== false) {

        header("Location: " . base_url('403.php'));
        exit();
    }
}

?>