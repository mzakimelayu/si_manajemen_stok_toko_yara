
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_kategori = $_POST['nama_kategori'];

    // Cek nama kategori apakah sudah ada yang menggunakan
    $check_nama = mysqli_query($koneksi, "SELECT * FROM kategori_barang WHERE nama_kategori = '$nama_kategori' AND id_kategori != '$id' AND status_dihapus = 0");
    if(mysqli_num_rows($check_nama) > 0) {
        $_SESSION['kategori_eror'] = "Nama kategori sudah digunakan!";
        header("Location: edit.php?id=" . $id);
        exit();
    }

    $query = "UPDATE kategori_barang SET 
              nama_kategori = '$nama_kategori'
              WHERE id_kategori = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['kategori_sukses'] = "Data kategori berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['kategori_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>