  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_supplier = $_POST['nama_supplier'];
        $kontak_supplier = $_POST['kontak_supplier'];
        $alamat_supplier = $_POST['alamat_supplier'];

        try {
            // Insert new supplier
            $query = mysqli_prepare($koneksi, "INSERT INTO supplier (nama_supplier, kontak_supplier, alamat_supplier, status_dihapus) VALUES (?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "sss", $nama_supplier, $kontak_supplier, $alamat_supplier);
            mysqli_stmt_execute($query);
          
            $_SESSION['supplier_sukses'] = 'Data berhasil ditambahkan!';
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