
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_satuan = $_POST['nama_satuan'];

    // Cek nama satuan apakah sudah ada yang menggunakan
    $check_nama = mysqli_query($koneksi, "SELECT * FROM satuan_barang WHERE nama_satuan = '$nama_satuan' AND id_satuan != '$id' AND status_dihapus = 0");
    if(mysqli_num_rows($check_nama) > 0) {
        $_SESSION['satuan_eror'] = "Nama satuan sudah digunakan!";
        header("Location: edit.php?id=" . $id);
        exit();
    }

    $query = "UPDATE satuan_barang SET 
              nama_satuan = '$nama_satuan'
              WHERE id_satuan = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['satuan_sukses'] = "Data satuan berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['satuan_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>
