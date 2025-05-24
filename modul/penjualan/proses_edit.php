<?php

session_start();

include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_penjualan = $_POST['id_penjualan'];
      $no_faktur_penjualan = $_POST['no_faktur_penjualan'];
      $id_pelanggan = $_POST['id_pelanggan'];
      $tanggal = $_POST['tanggal'];
      $diskon = $_POST['diskon'];
      $total_harga = $_POST['total_harga'];
      $dibayar = $_POST['dibayar'];
      $kembalian = $_POST['kembalian'];
      $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];

      // Validate required fields first
      if (isset($_POST['barang']) && is_array($_POST['barang'])) {
          foreach($_POST['barang'] as $barang) {
              if (empty($barang['id_barang']) || empty($barang['kode_barang'])) {
                  $_SESSION['penjualan_eror'] = 'Data barang tidak lengkap! Pastikan Data Barang Diisi dengan benar.';
                  header('Location: edit.php?id=' . $id_penjualan);
                  exit;
              }
          }
      }

      mysqli_begin_transaction($koneksi);

      try {
          // Update penjualan header
          $query = mysqli_prepare($koneksi, "UPDATE penjualan SET no_faktur_penjualan=?, id_pelanggan=?, id_pengguna=?, tanggal=?, total_harga=?, diskon=?, dibayar=?, kembalian=? WHERE id_penjualan=?");
          mysqli_stmt_bind_param($query, "siisddddi", $no_faktur_penjualan, $id_pelanggan, $id_pengguna, $tanggal, $total_harga, $diskon, $dibayar, $kembalian, $id_penjualan);
          mysqli_stmt_execute($query);

          // Get existing detail items to restore stock
          $get_old_details = mysqli_prepare($koneksi, "SELECT id_barang, qty FROM penjualan_detail WHERE id_penjualan = ? AND status_dihapus = 0");
          mysqli_stmt_bind_param($get_old_details, "i", $id_penjualan);
          mysqli_stmt_execute($get_old_details);
          $old_details = mysqli_stmt_get_result($get_old_details);
          
          // Restore old stock
          while($old_item = mysqli_fetch_assoc($old_details)) {
              $query_restore_stok = mysqli_prepare($koneksi, "UPDATE barang SET stok = stok + ? WHERE id_barang = ? AND status_dihapus = 0");
              mysqli_stmt_bind_param($query_restore_stok, "ii", $old_item['qty'], $old_item['id_barang']);
              mysqli_stmt_execute($query_restore_stok);
          }

          // Delete old detail records
          $delete_old_details = mysqli_prepare($koneksi, "DELETE FROM penjualan_detail WHERE id_penjualan = ?");
          mysqli_stmt_bind_param($delete_old_details, "i", $id_penjualan);
          mysqli_stmt_execute($delete_old_details);

          // Insert updated detail items and update stock
          if (isset($_POST['barang']) && is_array($_POST['barang'])) {
              foreach($_POST['barang'] as $barang) {
                  if (!empty($barang['id_barang']) && !empty($barang['qty']) && !empty($barang['harga_satuan'])) {
                      // Validate numeric values
                      $qty = intval($barang['qty']);
                      $harga_satuan = floatval($barang['harga_satuan']);
                      $harga_modal = floatval($barang['harga_modal']);
                      $subtotal = $qty * $harga_satuan;

                      // Check available stock first
                      $check_stok = mysqli_prepare($koneksi, "SELECT stok FROM barang WHERE id_barang = ? AND status_dihapus = 0");
                      mysqli_stmt_bind_param($check_stok, "i", $barang['id_barang']);
                      mysqli_stmt_execute($check_stok);
                      $result = mysqli_stmt_get_result($check_stok);
                      $stok_data = mysqli_fetch_assoc($result);

                      if($stok_data['stok'] < $qty) {
                          mysqli_rollback($koneksi);
                          $_SESSION['penjualan_eror'] = 'Stok tidak mencukupi untuk barang dengan kode ' . $barang['kode_barang'];
                          header('Location: edit.php?id=' . $id_penjualan);
                          exit;
                      }

                      // Insert new detail penjualan
                      $query_detail = mysqli_prepare($koneksi, "INSERT INTO penjualan_detail (id_penjualan, id_barang, qty, harga_satuan, harga_modal, subtotal, status_dihapus) VALUES (?, ?, ?, ?, ?, ?, 0)");
                      mysqli_stmt_bind_param($query_detail, "iiiddd", $id_penjualan, $barang['id_barang'], $qty, $harga_satuan, $harga_modal, $subtotal);
                      mysqli_stmt_execute($query_detail);

                      // Update stock in barang table
                      $query_update_stok = mysqli_prepare($koneksi, "UPDATE barang SET stok = stok - ? WHERE id_barang = ? AND status_dihapus = 0");
                      mysqli_stmt_bind_param($query_update_stok, "ii", $qty, $barang['id_barang']);
                      mysqli_stmt_execute($query_update_stok);
                  }
              }
          }            
          mysqli_commit($koneksi);
          $_SESSION['penjualan_sukses'] = 'Transaksi penjualan berhasil diupdate!';
          echo "<script>window.open('detail.php?id=" . $id_penjualan . "', '_blank'); window.location.href='index.php';</script>";          
          exit;

      } catch(Exception $e) {
          mysqli_rollback($koneksi);
          $_SESSION['penjualan_eror'] = 'Terjadi kesalahan saat mengupdate transaksi!';
          header('Location: edit.php?id=' . $id_penjualan);
          exit;        
      }
  }?>