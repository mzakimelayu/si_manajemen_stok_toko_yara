<?php
    $judul_halaman = "Detail Pembelian";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 bg-white">
        <?php
            
            $id_pembelian = $_GET['id'];
            
            // Get pembelian data
            $query = "SELECT p.*, s.nama_supplier, s.alamat_supplier, u.nama_lengkap_pengguna 
                     FROM pembelian p 
                     JOIN supplier s ON p.id_supplier = s.id_supplier 
                     JOIN pengguna u ON p.id_pengguna = u.id_pengguna 
                     WHERE p.id_pembelian = $id_pembelian";
            $result = mysqli_query($koneksi, $query);
            $pembelian = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) == 0) {
                echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    exit;
            }        
            ?>
        
        <div class="max-w-4xl mx-auto bg-white p-8" id="printArea">
            <!-- Header -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Invoice Pembelian</h2>
                    <p class="text-gray-700 text-lg mb-2">No: <?php echo $pembelian['no_invoice_pembelian']; ?></p>
                    <p class="<?php echo $pembelian['status_dihapus'] == 1 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'; ?> inline-block px-3 py-1 rounded text-sm mt-3">Status: <?php echo $pembelian['status_dihapus'] == 1 ? 'DIBATALKAN' : 'SELESAI'; ?></p>
                    <p class="text-gray-600 mt-2">Tanggal: <?php echo date('d/m/Y', strtotime($pembelian['tanggal'])); ?></p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Supplier:</h2>
                    <p class="text-gray-700 text-lg mb-2"><?php echo $pembelian['nama_supplier']; ?></p>
                    <p class="text-gray-600"><?php echo $pembelian['alamat_supplier']; ?></p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="w-full mb-8">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 text-left">Barang</th>
                        <th class="py-2 px-4 text-right">Qty</th>
                        <th class="py-2 px-4 text-right">Harga</th>
                        <th class="py-2 px-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $subtotal = 0;
                        $query_detail = "SELECT pd.*, b.nama_barang 
                                       FROM pembelian_detail pd 
                                       JOIN barang b ON pd.id_barang = b.id_barang 
                                       WHERE pd.id_pembelian = $id_pembelian";
                        $result_detail = mysqli_query($koneksi, $query_detail);
                        while($row = mysqli_fetch_assoc($result_detail)) {
                    ?>
                    <tr class="border-b">
                        <td class="py-2 px-4"><?php echo $row['nama_barang']; ?></td>
                        <td class="py-2 px-4 text-right"><?php echo $row['qty']; ?></td>
                        <td class="py-2 px-4 text-right"><?php echo number_format($row['harga_satuan'], 2, ',', '.'); ?></td>
                        <td class="py-2 px-4 text-right"><?php echo number_format($row['subtotal'], 2, ',', '.'); ?></td>
                    </tr>
                    <?php 
                    $subtotal += $row['subtotal'];
                    } ?>
                </tbody>
                <tfoot>
                    <tr class="border-t-2">
                        <td colspan="3" class="py-2 px-4 text-right font-bold">Subtotal:</td>
                        <td class="py-2 px-4 text-right"><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-right font-bold">Diskon:</td>
                        <td class="py-2 px-4 text-right"><?php echo $pembelian['diskon'] . "% (" . number_format(($pembelian['diskon']/100) * $subtotal, 2, ',', '.') . ")"; ?></td>                    </tr>
                    <tr class="font-bold">
                        <td colspan="3" class="py-2 px-4 text-right">Total:</td>
                        <td class="py-2 px-4 text-right"><?php echo number_format($pembelian['total_bayar'], 2, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Signatures -->
            <div class="w-full mb-2">
                <p class="text-right mr-0">Padang, <?php echo date('d F Y'); ?></p>
            </div>            
            <div class="flex justify-between">
                <div class="text-center">
                    <p>Diterima oleh</p>
                    <p class="mt-16 font-bold"><?php echo $pembelian['nama_lengkap_pengguna']; ?> <br>Petugas</p>
                </div>
                <div class="text-center">
                    <p>Supplier</p>
                    <p class="mt-16 font-bold"><?php echo $pembelian['nama_supplier']; ?> <br>Supplier</p>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="max-w-4xl mx-auto mt-8 text-center">
            <button onclick="window.print()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 print:hidden">
                Print Invoice
            </button>
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
                    width: 210mm;
                    height: 297mm;
                    margin: 0;
                    padding: 20mm;
                    box-sizing: border-box;
                }
                @page {
                    size: A4;
                    margin: 0;
                }
                table {
                    page-break-inside: avoid;
                }
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
            }
        </style>
    </main>    

<?php include ('../../layout/footer.php'); ?>