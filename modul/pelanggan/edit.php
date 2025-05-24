<?php
    $judul_halaman = "Edit Pelanggan";
    
    include '../../cek_login.php';

    // Ambil data pelanggan berdasarkan ID
    $id = $_GET['id'];
    $query = "SELECT * FROM pelanggan WHERE id_pelanggan = '$id'";
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
            <h2 class="text-2xl font-semibold mb-6">Edit Pelanggan</h2>

            <?php
                if(isset($_SESSION['pelanggan_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['pelanggan_eror']; ?></p>
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
            unset($_SESSION['pelanggan_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4 animate-fade-in">
            <input type="hidden" name="id" value="<?php echo $data['id_pelanggan']; ?>">
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" value="<?php echo $data['nama_pelanggan']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama pelanggan" required>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP Pelanggan</label>
                    <input type="text" name="no_hp_pelanggan" value="<?php echo $data['no_hp_pelanggan']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan no hp pelanggan">
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pelanggan</label>
                    <textarea name="alamat_pelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat pelanggan"><?php echo $data['alamat_pelanggan']; ?></textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">Batal</a>
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">Simpan Perubahan</button>
            </div>
            </form>    
        </div>
    </main>    
<?php include ('../../layout/footer.php'); ?>