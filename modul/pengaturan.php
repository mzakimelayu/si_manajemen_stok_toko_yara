<?php
    $judul_halaman = "Edit Profil Pengguna";
    
    include '../cek_login.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_pengguna = $_POST['id_pengguna'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $nohp = $_POST['nohp'];
        $alamat = $_POST['alamat'];

        // cek username sudah ada atau belum
        $query_cek_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username_pengguna='$username' AND id_pengguna != '$id_pengguna'");
        if(mysqli_num_rows($query_cek_username) > 0) {
            $_SESSION['pesan_gagal'] = "Username sudah ada!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
        

        // Cek password lama
        $query_cek = mysqli_query($koneksi, "SELECT password_pengguna FROM pengguna WHERE id_pengguna='$id_pengguna'");
        $data_cek = mysqli_fetch_array($query_cek);
        
        if($password_lama != "" || $password_baru != "") {
            if(!password_verify($password_lama, $data_cek['password_pengguna'])) {
                $_SESSION['pesan_gagal'] = "Password lama tidak sesuai!";
                header("Location: " . base_url('modul/pengaturan.php'));                
                exit();
            }
            if($password_lama != "" && $password_baru == "") {
                $_SESSION['pesan_gagal'] = "Password baru tidak boleh kosong!";
                header("Location: " . base_url('modul/pengaturan.php'));
                exit();
            }
            $password = password_hash($password_baru, PASSWORD_DEFAULT);
            $update_password = ", password_pengguna='$password'";
        } else {
            $update_password = "";
        }

        $query = mysqli_query($koneksi, "UPDATE pengguna SET 
            nama_lengkap_pengguna='$nama_lengkap',
            username_pengguna='$username',
            jenis_kelamin_pengguna='$jenis_kelamin',
            nohp_pengguna='$nohp',
            alamat_pengguna='$alamat'
            $update_password
            WHERE id_pengguna='$id_pengguna'");

        if($query) {
            $_SESSION['pesan_sukses'] = "Profil berhasil diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        } else {
            $_SESSION['pesan_gagal'] = "Profil gagal diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
    }?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 animate-fade-in">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 animate-slide-up">
            <h2 class="text-2xl font-bold mb-6">Edit Profil Saya</h2>
            <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$sesi_id_pengguna'");
                $data = mysqli_fetch_array($query);
            ?>

            <!-- Pesan Berhasil Saat Berhasil Update Profil -->
            <?php
                if(isset($_SESSION['pesan_sukses'])) { ?>
                <div id="alert-message" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['pesan_sukses']; ?></p>
                    <button onclick="closeAlert()" class="text-green-700 hover:text-green-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                    document.getElementById('alert-message').style.display = 'none';
                    }, 3000);
                    
                    function closeAlert() {
                    document.getElementById('alert-message').style.display = 'none';
                    }
                </script>
            <?php 
            unset($_SESSION['pesan_sukses']);
            } 
            ?> 

            <!-- Pesan Error Saat Login Gagal -->
            <?php
                if(isset($_SESSION['pesan_gagal'])) { ?>
                <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['pesan_gagal']; ?></p>
                    <button onclick="closeAlert()" class="text-red-700 hover:text-red-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                    document.getElementById('alert-message').style.display = 'none';
                    }, 3000);
                    
                    function closeAlert() {
                    document.getElementById('alert-message').style.display = 'none';
                    }
                </script>
            <?php 
            unset($_SESSION['pesan_gagal']);
            } 
            ?>

            <form method="POST" action="">
                <input type="hidden" name="id_pengguna" value="<?php echo $data['id_pengguna']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap_pengguna']; ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Username</label>
                            <input type="text" name="username" value="<?php echo $data['username_pengguna']; ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Password Lama</label>
                            <div class="relative">
                                <input type="password" id="password_lama" name="password_lama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" onclick="togglePasswordLama()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIconLama" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Password Baru</label>
                            <div class="relative">
                                <input type="password" id="password_baru" name="password_baru" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" onclick="togglePasswordBaru()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIconBaru" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>
                        </div>                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="L" <?php echo $data['jenis_kelamin_pengguna'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?php echo $data['jenis_kelamin_pengguna'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. Telepon</label>
                            <input type="text" name="nohp" value="<?php echo $data['nohp_pengguna']; ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Alamat</label>
                            <textarea name="alamat" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" required><?php echo $data['alamat_pengguna']; ?></textarea>
                        </div>
                    </div>
                </div>            
                <div class="flex justify-end mt-8 space-x-4">
                    <a href="profil.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300 transform">
                        Batal
                    </a>
                    <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300 transform">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
    function togglePasswordLama() {
      const passwordInput = document.getElementById('password_lama');
      const eyeIcon = document.getElementById('eyeIconLama');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }

    function togglePasswordBaru() {
      const passwordInput = document.getElementById('password_baru');
      const eyeIcon = document.getElementById('eyeIconBaru');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }  </script>

<?php include ('../layout/footer.php'); ?>