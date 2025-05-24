
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM kategori_barang where status_dihapus = 0 ORDER BY nama_kategori ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_kategori'],
        'nama_kategori' => $row['nama_kategori'],
        'status_dihapus' => $row['status_dihapus']    
    );
}
echo json_encode($data);
mysqli_close($koneksi);?>
