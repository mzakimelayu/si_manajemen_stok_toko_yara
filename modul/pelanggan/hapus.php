<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    $query = "UPDATE pelanggan SET status_dihapus = 1 WHERE id_pelanggan = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 
                          'message' => 'Data pelanggan berhasil dihapus']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus data pelanggan'
        ]);
    }
    
    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}?>
