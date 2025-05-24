<?php
    $judul_halaman = "Detail Pembelian";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 bg-white">
        <?php
            $id_penjualan = (int)$_GET['id'];
            
            // Get penjualan data
            $query = "SELECT p.*, pl.nama_pelanggan, pl.alamat_pelanggan, u.nama_lengkap_pengguna 
                     FROM penjualan p 
                     LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                     JOIN pengguna u ON p.id_pengguna = u.id_pengguna 
                     WHERE p.id_penjualan = $id_penjualan";
            $result = mysqli_query($koneksi, $query);
            $penjualan = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) == 0) {
                echo "<script>window.location.href='" . base_url('404.php') . "';</script>";
                exit;
            }        
        ?>
        
        <div class="max-w-sm mx-auto bg-white p-4" id="printArea">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold">TOKO YARA BANGUNAN</h1>
                <p class="text-sm">Jln. Limau Manis, Padang</p>
                <p class="text-sm">Telp: (0751) 123456</p>
                <div class="border-b-2 border-black my-2"></div>
            </div>

            <div class="text-sm mb-4">
                <p>No: <?php echo $penjualan['no_faktur_penjualan']; ?></p>
                <p>Kasir: <?php echo $penjualan['nama_lengkap_pengguna']; ?></p>
                <p>Tanggal: <?php echo date('d/m/Y', strtotime($penjualan['tanggal'])); ?></p>
                <?php if($penjualan['id_pelanggan']) { ?>
                <p>Pelanggan: <?php echo $penjualan['nama_pelanggan']; ?></p>
                <?php } ?>
            </div>

            <div class="border-b-2 border-black my-2"></div>

            <!-- Items -->
            <?php
                $subtotal = 0;
                $query_detail = "SELECT pd.*, b.nama_barang 
                               FROM penjualan_detail pd 
                               JOIN barang b ON pd.id_barang = b.id_barang 
                               WHERE pd.id_penjualan = $id_penjualan";
                $result_detail = mysqli_query($koneksi, $query_detail);
                while($row = mysqli_fetch_assoc($result_detail)) {
            ?>
            <div class="text-sm mb-2">
                <p class="font-bold"><?php echo $row['nama_barang']; ?></p>
                <div class="flex justify-between">
                    <p><?php echo $row['qty'] . ' x Rp. ' . number_format($row['harga_satuan'], 0, ',', '.'); ?></p>
                    <p>Rp. <?php echo number_format($row['subtotal'], 0, ',', '.'); ?></p>
                </div>
            </div>
            <?php 
            $subtotal += $row['subtotal'];
            } ?>

            <div class="border-b-2 border-black my-2"></div>

            <!-- Totals -->
            <div class="text-sm">
                <div class="flex justify-between mb-1">
                    <p>Total:</p>
                    <p>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></p>
                </div>
                <div class="flex justify-between mb-1">
                    <p>Diskon (<?php echo number_format($penjualan['diskon']) ?>%):</p>
                    <p>Rp. <?php echo number_format(($penjualan['diskon'] / 100) * $subtotal, 0, ',', '.'); ?></p>
                </div>
                <div class="flex justify-between mb-1">
                    <p>Total Pembayaran:</p>
                    <p>Rp. <?php echo number_format($subtotal - (($penjualan['diskon'] / 100) * $subtotal), 0, ',', '.'); ?></p>
                </div>                <div class="flex justify-between mb-1">
                    <p>Dibayar:</p>
                    <p>Rp. <?php echo number_format($penjualan['dibayar'], 0, ',', '.'); ?></p>
                </div>
                <div class="flex justify-between font-bold">
                    <p>Kembalian:</p>
                    <p>Rp. <?php echo number_format($penjualan['kembalian'], 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="border-b-2 border-black my-2"></div>

            <!-- Footer -->
            <div class="text-center text-sm mt-4">
                <p>Terima Kasih</p>
                <p>Atas Kunjungan Anda</p>
            </div>

            
            <?php if($penjualan['status_dihapus'] == 1): ?>
            <div class="text-center text-red-600 font-bold text-xl mt-4 border-4 border-red-600 p-2">
                <p>STRUK TIDAK BERLAKU</p>
                <p>BELANJA DIBATALKAN</p>
            </div>
            <?php endif; ?>
            
        </div>

        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #printArea, #printArea * {
                    visibility: visible;
                }
                #printArea {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 80mm;
                    margin: 0;
                    padding: 5mm;
                    box-sizing: border-box;
                }
                @page {
                    size: 80mm auto;
                    margin: 0;
                    padding: 0;
                }
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
            }
        </style>

        <script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 1000);
            };
        </script>
    </main>

<?php include ('../../layout/footer.php'); ?>