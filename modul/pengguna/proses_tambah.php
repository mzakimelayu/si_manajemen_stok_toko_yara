  <?php

  session_start();
  
  include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username_pengguna'];
      $password = $_POST['password']; // Remove direct hashing
      $nama_lengkap = $_POST['nama_lengkap_pengguna'];
      $role = $_POST['role_pengguna'];
      $nohp = $_POST['nohp_pengguna'];
      $jenis_kelamin = $_POST['jenis_kelamin_pengguna'];
      $alamat = $_POST['alamat_pengguna'];

      try {
          // Check if username already exists
          $check = mysqli_prepare($koneksi, "SELECT username_pengguna FROM pengguna WHERE username_pengguna = ?");
          mysqli_stmt_bind_param($check, "s", $username);
          mysqli_stmt_execute($check);
          $result = mysqli_stmt_get_result($check);
        
          if (mysqli_num_rows($result) > 0) {
            $_SESSION['pengguna_eror'] = 'Username sudah digunakan!';
            header('Location: tambah.php');
            exit;       
          }

          // Hash password only if not empty
          if (!empty($password)) {
              $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          } else {
              $_SESSION['pengguna_eror'] = 'Password tidak boleh kosong!';
              header('Location: tambah.php');
              exit;
          }

          // Insert new user
          $query = mysqli_prepare($koneksi, "INSERT INTO pengguna (username_pengguna, password_pengguna, nama_lengkap_pengguna, 
                              role_pengguna, nohp_pengguna, jenis_kelamin_pengguna, alamat_pengguna, status_dihapus) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
                            
          mysqli_stmt_bind_param($query, "sssssss", $username, $hashed_password, $nama_lengkap, $role, $nohp, $jenis_kelamin, $alamat);
          mysqli_stmt_execute($query);

          
          $_SESSION['pengguna_sukses'] = 'Data berhasil ditambahkan!';
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