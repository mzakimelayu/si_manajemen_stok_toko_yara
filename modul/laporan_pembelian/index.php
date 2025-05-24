<?php
    $judul_halaman = "Laporan Pembelian";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 animate-fade-in">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-6">Laporan Pembelian</h2>

            <!-- Enhanced Filter Form -->
            <form action="" method="GET" class="space-y-6 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Filter Type Selection -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jenis Filter</h3>
                        <div class="space-y-3 mb-4">
                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <input type="radio" name="tipe_filter" id="filter_tanggal" value="tanggal" class="w-4 h-4 text-blue-600" checked>
                                <span class="ml-3 text-gray-700">Rentang Tanggal</span>
                            </label>
                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <input type="radio" name="tipe_filter" id="filter_bulan" value="bulan" class="w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-700">Bulan</span>
                            </label>
                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <input type="radio" name="tipe_filter" id="filter_tahun" value="tahun" class="w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-700">Tahun</span>
                            </label>
                        </div>

                        <!-- Date Range Filter -->
                        <div id="filter_tanggal_section" class="space-y-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" id="tanggal_awal" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                        </div>

                        <!-- Month/Year Filter -->
                        <div id="filter_bulan_section" class="space-y-4 hidden">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                                <select name="month" id="month" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">Pilih Bulan</option>
                                    <?php
                                        $months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 
                                                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
                                        foreach($months as $num => $name) {
                                            echo "<option value='$num'>$name</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                                <select name="year" id="year" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        $currentYear = date('Y');
                                        for($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            echo "<option value='$year'>$year</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Year Only Filter -->
                        <div id="filter_tahun_section" class="space-y-4 hidden">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                                <select name="year_only" id="year_only" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        $currentYear = date('Y');
                                        for($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            echo "<option value='$year'>$year</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Filter -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Supplier</h3>
                        <div class="relative">
                            <select name="supplier" id="supplier" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Semua Supplier</option>
                                <?php
                                    $query = "SELECT id_supplier, nama_supplier FROM supplier WHERE status_dihapus = 0 ORDER BY nama_supplier ASC";
                                    $result = mysqli_query($koneksi, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='".$row['id_supplier']."'>".$row['nama_supplier']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Status</h3>
                            <select name="status" id="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Semua Status</option>
                                <option value="0">Selesai</option>
                                <option value="1">Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                        <div class="space-y-3">
                            <button type="submit" name="filter" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                <span class="font-medium">Terapkan Filter</span>
                            </button>
                            <button type="reset" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="font-medium">Reset Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <script>
                document.querySelectorAll('input[name="tipe_filter"]').forEach((radio) => {
                    radio.addEventListener('change', function() {
                        const sections = {
                            'filter_tanggal_section': 'tanggal',
                            'filter_bulan_section': 'bulan',
                            'filter_tahun_section': 'tahun'
                        };
                        
                        Object.keys(sections).forEach(sectionId => {
                            const element = document.getElementById(sectionId);
                            if (this.value === sections[sectionId]) {
                                element.classList.remove('hidden');
                                element.classList.add('animate-fade-in');
                            } else {
                                element.classList.add('hidden');
                                element.classList.remove('animate-fade-in');
                            }
                        });
                    });
                });
            </script>

            <!-- Table Section -->
            <div class="overflow-x-auto bg-gray-50 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Faktur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        if(isset($_GET['filter'])) {
                            $where = "1=1"; 
                                               
                            if(!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                                $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']);
                                $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']);
                                $where .= " AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                            }
                            
                            if(!empty($_GET['month']) && !empty($_GET['year'])) {
                                $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                                $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                                $where .= " AND MONTH(p.tanggal) = '$month' AND YEAR(p.tanggal) = '$year'";
                            }

                            if(!empty($_GET['year_only'])) {
                                $year_only = mysqli_real_escape_string($koneksi, $_GET['year_only']);
                                $where .= " AND YEAR(p.tanggal) = '$year_only'";
                            }
                            
                            if(!empty($_GET['supplier'])) {
                                $supplier = mysqli_real_escape_string($koneksi, $_GET['supplier']);
                                $where .= " AND p.id_supplier = '$supplier'";
                            }

                            if(isset($_GET['status']) && $_GET['status'] !== '') {
                                $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                                $where .= " AND p.status_dihapus = '$status'";
                            }

                            $query = "SELECT 
                                    p.tanggal,
                                    p.status_dihapus,
                                    p.no_invoice_pembelian,
                                    s.nama_supplier,
                                    b.nama_barang,
                                    pd.qty,
                                    pd.harga_satuan,
                                    pd.subtotal,
                                    u.nama_lengkap_pengguna as petugas
                                    FROM pembelian p
                                    JOIN pembelian_detail pd ON p.id_pembelian = pd.id_pembelian
                                    JOIN supplier s ON p.id_supplier = s.id_supplier
                                    JOIN barang b ON pd.id_barang = b.id_barang
                                    JOIN pengguna u ON p.id_pengguna = u.id_pengguna
                                    WHERE $where 
                                    ORDER BY p.tanggal DESC, p.id_pembelian DESC";

                            $result = mysqli_query($koneksi, $query);   
                            if (!$result) {
                                die("Query error: " . mysqli_error($koneksi));
                            }

                            $no = 1;
                            $total_pembelian = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $total_pembelian += $row['subtotal'];
                                    echo "<tr>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>$no</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['no_invoice_pembelian']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_supplier']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_barang']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>Rp. ".number_format($row['harga_satuan'], 0, ',', '.')."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['qty']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>Rp. ".number_format($row['subtotal'], 0, ',', '.')."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>";
                                    echo $row['status_dihapus'] == 1 ? "<span class='px-2 py-1 text-red-700 bg-red-100 rounded-full text-sm'>Dibatalkan</span>" : "<span class='px-2 py-1 text-green-700 bg-green-100 rounded-full text-sm'>Selesai</span>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                echo "<tr class='bg-gray-50'>";
                                echo "<td colspan='7' class='px-4 py-3 text-sm font-bold text-right'>Total Pembelian:</td>";
                                echo "<td colspan='2' class='px-4 py-3 text-sm font-bold'>Rp. ".number_format($total_pembelian, 0, ',', '.')."</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='9' class='px-4 py-3 text-sm text-gray-700 text-center'>Tidak ada data</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='px-4 py-3 text-sm text-gray-700 text-center'>Silahkan pilih filter terlebih dahulu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Print Options -->
            <div class="mt-6 flex flex-wrap gap-4 justify-end">
                <?php if(isset($_GET['filter'])): ?>
                <a href="cetak.php?<?php 
                    $params = array();
                    if(!empty($_GET['tanggal_awal'])) $params['tanggal_awal'] = $_GET['tanggal_awal'];
                    if(!empty($_GET['tanggal_akhir'])) $params['tanggal_akhir'] = $_GET['tanggal_akhir'];
                    if(!empty($_GET['month'])) $params['month'] = $_GET['month'];
                    if(!empty($_GET['year'])) $params['year'] = $_GET['year'];
                    if(!empty($_GET['year_only'])) $params['year_only'] = $_GET['year_only'];
                    if(!empty($_GET['supplier'])) $params['supplier'] = $_GET['supplier'];
                    if(isset($_GET['status'])) $params['status'] = $_GET['status'];
                    if(isset($_GET['tipe_filter'])) $params['tipe_filter'] = $_GET['tipe_filter'];
                    echo http_build_query($params);
                ?>" target="_blank" 
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Laporan
                </a>
                <?php endif; ?>
            </div>

        </div>
    </main>




<?php include ('../../layout/footer.php'); ?>