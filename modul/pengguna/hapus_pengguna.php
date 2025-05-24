<?php

session_start();

header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    if ($id == $_SESSION['dataPengguna']['id_pengguna']) {
        echo json_encode([
            'success' => false,
            'message' => 'Tidak dapat menghapus akun yang sedang digunakan'
        ]);
        exit;
    }
    
    $query = "UPDATE pengguna SET status_dihapus = 1 WHERE id_pengguna = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 
                          'message' => 'Data pengguna berhasil dihapus']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus data pengguna'
        ]);
    }    
    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?>
