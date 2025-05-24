  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_kategori = $_POST['nama_kategori'];

        try {
            // Check if kategori already exists
            $check = mysqli_prepare($koneksi, "SELECT nama_kategori FROM kategori_barang WHERE nama_kategori = ? AND status_dihapus = 0");
            mysqli_stmt_bind_param($check, "s", $nama_kategori);
            mysqli_stmt_execute($check);
            $result = mysqli_stmt_get_result($check);
        
            if (mysqli_num_rows($result) > 0) {
              $_SESSION['kategori_eror'] = 'Nama kategori sudah ada!';
              header('Location: tambah.php');
              exit;       
            }

            // Insert new kategori
            $query = mysqli_prepare($koneksi, "INSERT INTO kategori_barang (nama_kategori, status_dihapus) VALUES (?, 0)");
            mysqli_stmt_bind_param($query, "s", $nama_kategori);
            mysqli_stmt_execute($query);
          
            $_SESSION['kategori_sukses'] = 'Data berhasil ditambahkan!';
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