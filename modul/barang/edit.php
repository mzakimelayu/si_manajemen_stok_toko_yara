<?php
    $judul_halaman = "Edit Barang";
    
    include '../../cek_login.php';

    // Ambil data pelanggan berdasarkan ID
    $id = $_GET['id'];
    $query = "SELECT * FROM barang WHERE id_barang = '$id'";
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
            <h2 class="text-2xl font-semibold mb-6">Edit Barang</h2>

            <?php
                if(isset($_SESSION['barang_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['barang_eror']; ?></p>
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
            unset($_SESSION['barang_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="animate-fade-in">
                <input type="hidden" name="id" value="<?php echo $data['id_barang']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Barang</label>
                        <input type="text" name="kode_barang" value="<?php echo $data['kode_barang']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan kode barang" required>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama barang" required>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <?php
                            $query_kategori = "SELECT * FROM kategori_barang WHERE status_dihapus = 0";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            while($kategori = mysqli_fetch_assoc($result_kategori)) {
                                $selected = ($kategori['id_kategori'] == $data['kategori_id']) ? 'selected' : '';
                                echo "<option value='".$kategori['id_kategori']."' ".$selected.">".$kategori['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Satuan</label>
                        <select name="satuan_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <?php
                            $query_satuan = "SELECT * FROM satuan_barang WHERE status_dihapus = 0";
                            $result_satuan = mysqli_query($koneksi, $query_satuan);
                            while($satuan = mysqli_fetch_assoc($result_satuan)) {
                                $selected = ($satuan['id_satuan'] == $data['satuan_id']) ? 'selected' : '';
                                echo "<option value='".$satuan['id_satuan']."' ".$selected.">".$satuan['nama_satuan']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                        <input type="number" name="stok" value="<?php echo $data['stok']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan stok" required>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum</label>
                        <input type="number" name="stok_minimum" value="<?php echo $data['stok_minimum']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan stok minimum" required>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">Rp</span>
                            <input type="number" name="harga_beli" value="<?php echo $data['harga_beli']; ?>" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan harga beli" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Jual</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">Rp</span>
                            <input type="number" name="harga_jual" value="<?php echo $data['harga_jual']; ?>" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan harga jual" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan deskripsi" rows="3"><?php echo $data['deskripsi']; ?></textarea>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 flex items-center">Batal</a>
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 flex items-center">Simpan Perubahan</button>
                </div>            
            </form>        
        </div>
    </main><?php include ('../../layout/footer.php'); ?>