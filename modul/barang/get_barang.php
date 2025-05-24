
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM barang where status_dihapus = 0 ORDER BY nama_barang ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_barang'],
        'kode_barang' => $row['kode_barang'],
        'nama_barang' => $row['nama_barang'],
        'kategori_id' => $row['kategori_id'],
        'satuan_id' => $row['satuan_id'],
        'stok' => $row['stok'],
        'stok_minimum' => $row['stok_minimum'],
        'harga_beli' => $row['harga_beli'],
        'harga_jual' => $row['harga_jual'],
        'deskripsi' => $row['deskripsi'],
        'status_dihapus' => $row['status_dihapus'],
    );
}
echo json_encode($data);
mysqli_close($koneksi);
?>
