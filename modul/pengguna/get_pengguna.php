
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM pengguna where status_dihapus=0 ORDER BY id_pengguna ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pengguna' => $row['id_pengguna'],
        'nama_pengguna' => $row['nama_lengkap_pengguna'], 
        'username' => $row['username_pengguna'],
        'password' => $row['password_pengguna'],
        'role' => $row['role_pengguna'],
        'nohp' => $row['nohp_pengguna'],
        'jenis_kelamin' => $row['jenis_kelamin_pengguna'],
        'alamat' => $row['alamat_pengguna'],
        'status_dihapus' => $row['status_dihapus']    
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
