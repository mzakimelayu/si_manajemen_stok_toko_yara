  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_barang = $_POST['kode_barang'];
        $nama_barang = $_POST['nama_barang'];
        $kategori_id = $_POST['kategori_id'];
        $satuan_id = $_POST['satuan_id'];
        $stok = $_POST['stok'];
        $stok_minimum = $_POST['stok_minimum'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $deskripsi = $_POST['deskripsi'];

        try {
            // Check if kode_barang already exists
            $check_query = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM barang WHERE kode_barang = ? AND status_dihapus = 0");
            mysqli_stmt_bind_param($check_query, "s", $kode_barang);
            mysqli_stmt_execute($check_query);
            mysqli_stmt_bind_result($check_query, $count);
            mysqli_stmt_fetch($check_query);
            mysqli_stmt_close($check_query);

            if($count > 0) {
                $_SESSION['barang_eror'] = 'Kode barang sudah ada!';
                header('Location: tambah.php');
                exit;            
            }

            // Insert new barang
            $query = mysqli_prepare($koneksi, "INSERT INTO barang (kode_barang, nama_barang, kategori_id, satuan_id, stok, stok_minimum, harga_beli, harga_jual, deskripsi, status_dihapus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "ssiiiiiis", $kode_barang, $nama_barang, $kategori_id, $satuan_id, $stok, $stok_minimum, $harga_beli, $harga_jual, $deskripsi);
            mysqli_stmt_execute($query);
          
            $_SESSION['barang_sukses'] = 'Data berhasil ditambahkan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            echo "<script>
                alert('Terjadi kesalahan saat menambah data!');
                window.location.href='tambah.php';
            </script>";
        }    
    }        
    
?>