<?php
    $judul_halaman = "Detail Supplier";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto animate-fade-in animate-slide-in-up">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Detail Supplier</h1>
            
            <?php                
                $id = $_GET['id'];
                $query = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier = '$id'");
                $data = mysqli_fetch_array($query);
                
                if (mysqli_num_rows($query) == 0) {
                    echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    exit;
                }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Nama Supplier</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['nama_supplier']; ?></span>
                    </div>
                    
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Kontak</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['kontak_supplier'] ?: '-'; ?></span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Alamat</label>
                        <span class="mt-1 text-gray-800"><?php echo $data['alamat_supplier'] ?: '-'; ?></span>
                    </div>
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