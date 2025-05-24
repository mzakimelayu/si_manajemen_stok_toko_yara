<?php

session_start();

include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $no_invoice_pembelian = $_POST['no_invoice_pembelian'];
      $id_supplier = $_POST['id_supplier'];
      $tanggal = $_POST['tanggal'];
      $diskon = $_POST['diskon'];
      $total_bayar = $_POST['total_bayar'];
      $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];
      $id_pembelian = $_POST['id_pembelian'];

      // Validate required fields first
      if (isset($_POST['barang']) && is_array($_POST['barang'])) {
        foreach($_POST['barang'] as $barang) {
            if (empty($barang['id_barang']) || empty($barang['kode_barang'])) {
                $_SESSION['pembelian_eror'] = 'Data barang tidak lengkap! Pastikan Data Barang Diisi dengan benar.';
                header('Location: edit.php?id='.$id_pembelian);
                exit;
            }
        }
    }

      mysqli_begin_transaction($koneksi);

      try {
          // Update pembelian header
          $query = mysqli_prepare($koneksi, "UPDATE pembelian SET no_invoice_pembelian=?, id_supplier=?, id_pengguna=?, tanggal=?, diskon=?, total_bayar=? WHERE id_pembelian=? AND status_dihapus=0");
          mysqli_stmt_bind_param($query, "siisddi", $no_invoice_pembelian, $id_supplier, $id_pengguna, $tanggal, $diskon, $total_bayar, $id_pembelian);
          mysqli_stmt_execute($query);

          // Reverse previous stock updates
          $query_old_details = mysqli_prepare($koneksi, "SELECT id_barang, qty FROM pembelian_detail WHERE id_pembelian=? AND status_dihapus=0");
          mysqli_stmt_bind_param($query_old_details, "i", $id_pembelian);
          mysqli_stmt_execute($query_old_details);
          $result = mysqli_stmt_get_result($query_old_details);
          
          while($row = mysqli_fetch_assoc($result)) {
              $query_reverse_stock = mysqli_prepare($koneksi, "UPDATE barang SET stok = stok - ? WHERE id_barang = ? AND status_dihapus = 0");
              mysqli_stmt_bind_param($query_reverse_stock, "ii", $row['qty'], $row['id_barang']);
              mysqli_stmt_execute($query_reverse_stock);
          }

          // Delete old detail records
          $query_delete = mysqli_prepare($koneksi, "DELETE FROM pembelian_detail WHERE id_pembelian=?");
          mysqli_stmt_bind_param($query_delete, "i", $id_pembelian);
          mysqli_stmt_execute($query_delete);
          
          // Insert new pembelian detail and update stock
          if (isset($_POST['barang']) && is_array($_POST['barang'])) {
              foreach($_POST['barang'] as $barang) {
                  if (!empty($barang['id_barang']) && !empty($barang['qty']) && !empty($barang['harga_satuan'])) {
                      // Validate numeric values
                      $qty = intval($barang['qty']);
                      $harga_satuan = floatval($barang['harga_satuan']);
                      $subtotal = $qty * $harga_satuan;

                      // Insert detail pembelian
                      $query_detail = mysqli_prepare($koneksi, "INSERT INTO pembelian_detail (id_pembelian, id_barang, qty, harga_satuan, subtotal, status_dihapus) VALUES (?, ?, ?, ?, ?, 0)");
                      mysqli_stmt_bind_param($query_detail, "iiidd", $id_pembelian, $barang['id_barang'], $qty, $harga_satuan, $subtotal);
                      mysqli_stmt_execute($query_detail);

                      // Update stock and harga_beli in barang table
                      $query_update_stok = mysqli_prepare($koneksi, "UPDATE barang SET stok = stok + ?, harga_beli = ? WHERE id_barang = ? AND status_dihapus = 0");
                      mysqli_stmt_bind_param($query_update_stok, "idi", $qty, $harga_satuan, $barang['id_barang']);
                      mysqli_stmt_execute($query_update_stok);
                  }
              }
          }

          mysqli_commit($koneksi);
          $_SESSION['pembelian_sukses'] = 'Transaksi pembelian berhasil diupdate!';
          header('Location: index.php');
          exit;

      } catch(Exception $e) {
          mysqli_rollback($koneksi);
          $_SESSION['pembelian_eror'] = 'Terjadi kesalahan saat mengupdate transaksi!';
          header('Location: edit.php?id='.$id_pembelian);
          exit;        
      }
  }    
?>