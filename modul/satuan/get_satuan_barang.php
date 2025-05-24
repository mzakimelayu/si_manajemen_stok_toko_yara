
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM satuan_barang where status_dihapus = 0 ORDER BY nama_satuan ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_satuan'],
        'nama_satuan' => $row['nama_satuan'],
        'status_dihapus' => $row['status_dihapus']    
    );
}

echo json_encode($data);
mysqli_close($koneksi);?>
