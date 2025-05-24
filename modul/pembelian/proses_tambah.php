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

        // Validate required fields first
        if (isset($_POST['barang']) && is_array($_POST['barang'])) {
            foreach($_POST['barang'] as $barang) {
                if (empty($barang['id_barang']) || empty($barang['kode_barang'])) {
                    $_SESSION['pembelian_eror'] = 'Data barang tidak lengkap! Pastikan Data Barang Diisi dengan benar.';
                    header('Location: tambah.php');
                    exit;
                }
            }
        }

        mysqli_begin_transaction($koneksi);

        try {
            // Insert pembelian header
            $query = mysqli_prepare($koneksi, "INSERT INTO pembelian (no_invoice_pembelian, id_supplier, id_pengguna, tanggal, diskon, total_bayar, status_dihapus) VALUES (?, ?, ?, ?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "siisdd", $no_invoice_pembelian, $id_supplier, $id_pengguna, $tanggal, $diskon, $total_bayar);
            mysqli_stmt_execute($query);
            
            $id_pembelian = mysqli_insert_id($koneksi);

            // Insert pembelian detail and update stock
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
            $_SESSION['pembelian_sukses'] = 'Transaksi pembelian berhasil disimpan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            mysqli_rollback($koneksi);
            $_SESSION['pembelian_eror'] = 'Terjadi kesalahan saat menyimpan transaksi!';
            header('Location: tambah.php');
            exit;        
        }
    }    
?>