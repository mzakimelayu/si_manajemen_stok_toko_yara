
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_supplier = $_POST['nama_supplier'];
    $kontak_supplier = $_POST['kontak_supplier'];
    $alamat_supplier = $_POST['alamat_supplier'];

    $query = "UPDATE supplier SET 
              nama_supplier = '$nama_supplier',
              kontak_supplier = '$kontak_supplier',
              alamat_supplier = '$alamat_supplier'
              WHERE id_supplier = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['supplier_sukses'] = "Data supplier berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['supplier_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
