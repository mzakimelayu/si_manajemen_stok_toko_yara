
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM pelanggan where status_dihapus = 0 ORDER BY nama_pelanggan ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_pelanggan'],
        'nama_pelanggan' => $row['nama_pelanggan'],
        'no_hp_pelanggan' => $row['no_hp_pelanggan'],
        'alamat_pelanggan' => $row['alamat_pelanggan'],
        'status_dihapus' => $row['status_dihapus'],
    );
}
echo json_encode($data);
mysqli_close($koneksi);

?>
