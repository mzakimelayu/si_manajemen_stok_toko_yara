
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT p.*, pl.nama_pelanggan FROM penjualan p
LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
ORDER BY p.tanggal DESC";

$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_penjualan' => $row['id_penjualan'],
        'no_faktur_penjualan' => $row['no_faktur_penjualan'],
        'id_pelanggan' => $row['id_pelanggan'],
        'nama_pelanggan' => $row['nama_pelanggan'],
        'id_pengguna' => $row['id_pengguna'],
        'tanggal' => $row['tanggal'],
        'total_harga' => $row['total_harga'],
        'diskon' => $row['diskon'],
        'dibayar' => $row['dibayar'],
        'kembalian' => $row['kembalian'],
        'status_dihapus' => $row['status_dihapus']
    );
}

echo json_encode($data);
mysqli_close($koneksi);

?>
