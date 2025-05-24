  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_satuan = $_POST['nama_satuan'];

        try {
            // Check if satuan already exists
            $check = mysqli_prepare($koneksi, "SELECT nama_satuan FROM satuan_barang WHERE nama_satuan = ? AND status_dihapus = 0");
            mysqli_stmt_bind_param($check, "s", $nama_satuan);
            mysqli_stmt_execute($check);
            $result = mysqli_stmt_get_result($check);
        
            if (mysqli_num_rows($result) > 0) {
              $_SESSION['satuan_eror'] = 'Nama satuan sudah ada!';
              header('Location: tambah.php');
              exit;       
            }

            // Insert new satuan
            $query = mysqli_prepare($koneksi, "INSERT INTO satuan_barang (nama_satuan, status_dihapus) VALUES (?, 0)");
            mysqli_stmt_bind_param($query, "s", $nama_satuan);
            mysqli_stmt_execute($query);
          
            $_SESSION['satuan_sukses'] = 'Data berhasil ditambahkan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            echo "<script>
                alert('Terjadi kesalahan saat menambah data!');
                window.location.href='tambah.php';
            </script>";
        }
    }  ?>