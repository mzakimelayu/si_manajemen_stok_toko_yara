<?php
include "../../koneksi/db.php";

header('Content-Type: application/json');

if(isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    
    $query = "SELECT id_barang, kode_barang, nama_barang, harga_beli 
              FROM barang 
              WHERE (nama_barang LIKE ? OR kode_barang LIKE ?)
              AND status_dihapus = 0";
    
    $stmt = mysqli_prepare($koneksi, $query);
    $searchParam = "%$searchTerm%";
    mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);    
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id_barang' => $row['id_barang'],
            'kode_barang' => $row['kode_barang'],
            'nama_barang' => $row['nama_barang'],
            'harga_beli' => $row['harga_beli']
        );
    }
    
    echo json_encode($data);
    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
?>
