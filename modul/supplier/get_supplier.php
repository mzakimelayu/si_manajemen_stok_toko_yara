
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM supplier where status_dihapus = 0 ORDER BY nama_supplier ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_supplier'],
        'nama_supplier' => $row['nama_supplier'],
        'kontak_supplier' => $row['kontak_supplier'],
        'alamat_supplier' => $row['alamat_supplier'],
        'status_dihapus' => $row['status_dihapus'],
    );
}
echo json_encode($data);
mysqli_close($koneksi);?>
