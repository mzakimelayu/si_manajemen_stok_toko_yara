<?php
    $judul_halaman = "Profil Pengguna";
    
    include '../cek_login.php';
?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 animate-fade-in">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 animate-slide-up">
            <h2 class="text-2xl font-bold mb-6">Profil Saya</h2>
            <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$sesi_id_pengguna'");
                $data = mysqli_fetch_array($query);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <p class="text-gray-900"><?php echo $data['nama_lengkap_pengguna']; ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Username</label>
                        <p class="text-gray-900"><?php echo $data['username_pengguna']; ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                        <p class="text-gray-900"><?php echo $data['jenis_kelamin_pengguna'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">No. Telepon</label>
                        <p class="text-gray-900"><?php echo $data['nohp_pengguna']; ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Alamat</label>
                        <p class="text-gray-900"><?php echo $data['alamat_pengguna']; ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Peran</label>
                        <p class="text-gray-900"><?php echo ucfirst($data['role_pengguna']); ?></p>
                    </div>
                </div>
            </div>            
            <div class="flex justify-end mt-8 space-x-4">
                <a href="javascript:history.back()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300 transform">
                    Kembali
                </a>
                <a href="<?= base_url('modul/pengaturan.php') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300 transform">
                    Edit Profil
                </a>
            </div>
        </div>
    </main>
<?php include ('../layout/footer.php'); ?>