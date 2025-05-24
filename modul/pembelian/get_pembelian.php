
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT p.*, s.nama_supplier FROM pembelian p
LEFT JOIN supplier s ON p.id_supplier = s.id_supplier
ORDER BY p.tanggal DESC";

$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pembelian' => $row['id_pembelian'],
        'no_invoice_pembelian' => $row['no_invoice_pembelian'], 
        'id_supplier' => $row['id_supplier'],
        'nama_supplier' => $row['nama_supplier'],
        'id_pengguna' => $row['id_pengguna'],
        'tanggal' => $row['tanggal'],
        'diskon' => $row['diskon'],
        'total_bayar' => $row['total_bayar'],
        'status_dihapus' => $row['status_dihapus']
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
