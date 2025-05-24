<?php
    $judul_halaman = "Detail Barang";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto animate-fade-in animate-slide-in-up">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Detail Barang</h1>
            
            <?php                
                $id = $_GET['id'];
                $query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori, s.nama_satuan 
                                               FROM barang b 
                                               LEFT JOIN kategori_barang k ON b.kategori_id = k.id_kategori
                                               LEFT JOIN satuan_barang s ON b.satuan_id = s.id_satuan
                                               WHERE b.id_barang = '$id' AND b.status_dihapus = 0");
                $data = mysqli_fetch_array($query);
                
                if (mysqli_num_rows($query) == 0) {
                    echo "<script>window.location.href='" . base_url('404.php') . "';</script>";
                    exit;
                }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Kode Barang</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['kode_barang']; ?></span>
                    </div>
                    
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Nama Barang</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['nama_barang']; ?></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Kategori</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['nama_kategori'] ?: '-'; ?></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Satuan</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['nama_satuan'] ?: '-'; ?></span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Stok</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['stok']; ?></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Stok Minimum</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['stok_minimum']; ?></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Harga Beli</label>
                        <span class="mt-1 text-gray-800">Rp <?php echo number_format($data['harga_beli'], 2, ',', '.'); ?></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Harga Jual</label>
                        <span class="mt-1 text-gray-800">Rp <?php echo number_format($data['harga_jual'], 2, ',', '.'); ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-600">Deskripsi</label>
                    <span class="mt-1 text-gray-800"><?php echo $data['deskripsi'] ?: '-'; ?></span>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="edit.php?id=<?php echo $id; ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Edit
                </a>
                <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </main>
<?php include ('../../layout/footer.php'); ?>