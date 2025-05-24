<?php
    $judul_halaman = "Edit Pengguna";
    
    include '../../cek_login.php';

    // Ambil data pengguna berdasarkan ID
    $id_pengguna = $_GET['id'];
    $query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    
        exit;
    }
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 animate-fade-in">
        <div class="bg-white rounded-lg shadow-md p-6 animate-slide-in-up">
            <h2 class="text-2xl font-semibold mb-6">Edit Pengguna</h2>

            <!-- Pesan Error Saat Username sama -->
            <?php
                if(isset($_SESSION['pengguna_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['pengguna_eror']; ?></p>
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
            unset($_SESSION['pengguna_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4 animate-fade-in">
            <input type="hidden" name="id_pengguna" value="<?php echo $data['id_pengguna']; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="username_pengguna" value="<?php echo $data['username_pengguna']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan username" required>
                </div>
        
                <div class="form-group">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                    <input type="password" id="password" name="password" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    </div>
                </div>

                <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap_pengguna" value="<?php echo $data['nama_lengkap_pengguna']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                <select name="role_pengguna" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" <?php echo ($data['role_pengguna'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="kasir" <?php echo ($data['role_pengguna'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
                    <option value="pemilik" <?php echo ($data['role_pengguna'] == 'pemilik') ? 'selected' : ''; ?>>Pemilik</option>
                </select>
                </div>

                <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                <input type="text" name="nohp_pengguna" value="<?php echo $data['nohp_pengguna']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nomor HP" required>
                </div>

                <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin_pengguna" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" <?php echo ($data['jenis_kelamin_pengguna'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?php echo ($data['jenis_kelamin_pengguna'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat_pengguna" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat lengkap" required><?php echo $data['alamat_pengguna']; ?></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">Batal</a>
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">Simpan Perubahan</button>
            </div>
            </form>    
        </div>
    </main>      

    <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
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
  </script>

<?php include ('../../layout/footer.php'); ?>