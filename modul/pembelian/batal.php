<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    $id_pembelian = $_GET['id'];
    
    mysqli_begin_transaction($koneksi);
    
    try {
        // Get pembelian details first
        $query_get = "SELECT id_pembelian FROM pembelian WHERE id_pembelian = ? AND status_dihapus = 0";
        $stmt_get = mysqli_prepare($koneksi, $query_get);
        mysqli_stmt_bind_param($stmt_get, "i", $id_pembelian);
        mysqli_stmt_execute($stmt_get);
        $result = mysqli_stmt_get_result($stmt_get);
        $pembelian = mysqli_fetch_assoc($result);

        if (!$pembelian) {
            throw new Exception('Transaksi tidak ditemukan');
        }
            
        // Get and update stock from pembelian_detail
        $query_detail = "SELECT id_barang, qty FROM pembelian_detail WHERE id_pembelian = ? AND status_dihapus = 0";
        $stmt_detail = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "i", $id_pembelian);
        mysqli_stmt_execute($stmt_detail);
        $result_detail = mysqli_stmt_get_result($stmt_detail);
        
        if (mysqli_num_rows($result_detail) === 0) {
            throw new Exception('Detail pembelian tidak ditemukan');
        }
        
        while ($detail = mysqli_fetch_assoc($result_detail)) {
            // Check current stock first
            $query_check_stock = "SELECT stok FROM barang WHERE id_barang = ? AND status_dihapus = 0";
            $stmt_check_stock = mysqli_prepare($koneksi, $query_check_stock);
            mysqli_stmt_bind_param($stmt_check_stock, "i", $detail['id_barang']);
            mysqli_stmt_execute($stmt_check_stock);
            $result_stock = mysqli_stmt_get_result($stmt_check_stock);
            $current_stock = mysqli_fetch_assoc($result_stock);
            
            if (!$current_stock) {
                throw new Exception('Barang tidak ditemukan');
            }
            
            if ($current_stock['stok'] < $detail['qty']) {
                throw new Exception('Stok tidak mencukupi untuk pembatalan');
            }
            
            // Reverse stock updates
            $query_update_stok = "UPDATE barang SET stok = stok - ? WHERE id_barang = ? AND status_dihapus = 0";
            $stmt_update_stok = mysqli_prepare($koneksi, $query_update_stok);
            mysqli_stmt_bind_param($stmt_update_stok, "ii", $detail['qty'], $detail['id_barang']);
            
            if (!mysqli_stmt_execute($stmt_update_stok)) {
                throw new Exception('Gagal mengupdate stok barang');
            }
        }
        
        // Soft delete pembelian_detail
        $query_delete_detail = "UPDATE pembelian_detail SET status_dihapus = 1 WHERE id_pembelian = ?";
        $stmt_delete_detail = mysqli_prepare($koneksi, $query_delete_detail);
        mysqli_stmt_bind_param($stmt_delete_detail, "i", $id_pembelian);
        
        if (!mysqli_stmt_execute($stmt_delete_detail)) {
            throw new Exception('Gagal membatalkan detail pembelian');
        }
        
        // Soft delete pembelian
        $query_delete = "UPDATE pembelian SET status_dihapus = 1 WHERE id_pembelian = ?";
        $stmt_delete = mysqli_prepare($koneksi, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_pembelian);
        
        if (!mysqli_stmt_execute($stmt_delete)) {
            throw new Exception('Gagal membatalkan pembelian');
        }
        
        mysqli_commit($koneksi);
        echo json_encode([
            'success' => true,
            'message' => 'Transaksi pembelian berhasil dibatalkan'
        ]);
        
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal membatalkan transaksi: ' . $e->getMessage()
        ]);
    }
    
    mysqli_close($koneksi);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}?>
