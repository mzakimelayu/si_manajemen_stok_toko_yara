
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp_pelanggan = $_POST['no_hp_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];

    // Cek nama pelanggan apakah sudah ada yang menggunakan
    $check_nama = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE nama_pelanggan = '$nama_pelanggan' AND id_pelanggan != '$id' AND status_dihapus = 0");
    if(mysqli_num_rows($check_nama) > 0) {
        $_SESSION['pelanggan_eror'] = "Nama pelanggan sudah digunakan!";
        header("Location: edit.php?id=" . $id);
        exit();
    }

    $query = "UPDATE pelanggan SET 
              nama_pelanggan = '$nama_pelanggan',
              no_hp_pelanggan = '$no_hp_pelanggan',
              alamat_pelanggan = '$alamat_pelanggan'
              WHERE id_pelanggan = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['pelanggan_sukses'] = "Data pelanggan berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['pelanggan_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

?>
