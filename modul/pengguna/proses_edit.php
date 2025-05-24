
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengguna = $_POST['id_pengguna'];
    $username_pengguna = $_POST['username_pengguna'];
    $password = $_POST['password'];
    $nama_lengkap_pengguna = $_POST['nama_lengkap_pengguna'];
    $role_pengguna = $_POST['role_pengguna'];
    $nohp_pengguna = $_POST['nohp_pengguna'];
    $jenis_kelamin_pengguna = $_POST['jenis_kelamin_pengguna'];
    $alamat_pengguna = $_POST['alamat_pengguna'];

    // Cek username apakah sudah ada yang menggunakan
    $check_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username_pengguna = '$username_pengguna' AND id_pengguna != '$id_pengguna'");
    if(mysqli_num_rows($check_username) > 0) {
        $_SESSION['pengguna_eror'] = "Username sudah digunakan!";
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }

    // Jika password diisi, update dengan password baru
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE pengguna SET 
                  username_pengguna = '$username_pengguna',
                  password_pengguna = '$hashed_password',
                  nama_lengkap_pengguna = '$nama_lengkap_pengguna',
                  role_pengguna = '$role_pengguna',
                  nohp_pengguna = '$nohp_pengguna',
                  jenis_kelamin_pengguna = '$jenis_kelamin_pengguna',
                  alamat_pengguna = '$alamat_pengguna'
                  WHERE id_pengguna = '$id_pengguna'";
    } else {
        // Jika password kosong, update tanpa mengubah password
        $query = "UPDATE pengguna SET 
                  username_pengguna = '$username_pengguna',
                  nama_lengkap_pengguna = '$nama_lengkap_pengguna',
                  role_pengguna = '$role_pengguna',
                  nohp_pengguna = '$nohp_pengguna',
                  jenis_kelamin_pengguna = '$jenis_kelamin_pengguna',
                  alamat_pengguna = '$alamat_pengguna'
                  WHERE id_pengguna = '$id_pengguna'";
    }

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['pengguna_sukses'] = "Data pengguna berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['pengguna_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
