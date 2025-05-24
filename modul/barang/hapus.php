<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    // Check stok before delete
    $check_stok = "SELECT stok FROM barang WHERE id_barang = ?";
    $stmt_check = $koneksi->prepare($check_stok);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_assoc();
    
    if($row['stok'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Tidak dapat menghapus barang karena stok masih tersedia'
        ]);
        exit;
    }
    
    $query = "UPDATE barang SET status_dihapus = 1 WHERE id_barang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 
                          'message' => 'Data barang berhasil dihapus']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus data barang'
        ]);
    }
    
    $stmt_check->close();
    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?>
