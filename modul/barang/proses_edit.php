
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori_id = $_POST['kategori_id'];
    $satuan_id = $_POST['satuan_id'];
    $stok = $_POST['stok'];
    $stok_minimum = $_POST['stok_minimum'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $deskripsi = $_POST['deskripsi'];

    // Cek kode barang apakah sudah ada yang menggunakan
    $check_kode = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '$kode_barang' AND id_barang != '$id' AND status_dihapus = 0");
    if(mysqli_num_rows($check_kode) > 0) {
        $_SESSION['barang_eror'] = "Kode barang sudah digunakan!";
        header("Location: edit.php?id=" . $id);
        exit();
    }

    $query = "UPDATE barang SET 
              kode_barang = '$kode_barang',
              nama_barang = '$nama_barang',
              kategori_id = '$kategori_id',
              satuan_id = '$satuan_id',
              stok = '$stok',
              stok_minimum = '$stok_minimum',
              harga_beli = '$harga_beli',
              harga_jual = '$harga_jual',
              deskripsi = '$deskripsi'
              WHERE id_barang = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['barang_sukses'] = "Data barang berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['barang_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
