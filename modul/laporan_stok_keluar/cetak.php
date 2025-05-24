<?php
    $judul_halaman = "Print Laporan Stok Keluar";
    
    include '../../cek_login.php';
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $judul_utama ?></title>
        <style>
            @media print {
                body {
                    margin: 0;
                    padding: 2mm;
                    font-family: Arial, sans-serif;
                }
                @page {
                    size: landscape;
                    margin: 10mm;
                }
                .no-print {
                    display: none;
                }
            }
            body {
                font-family: Arial, sans-serif;
                background: white;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #000;
                padding-bottom: 20px;
            }
            .title {
                font-size: 24px;
                font-weight: bold;
                margin: 0;
                padding: 0;
            }
            .subtitle {
                font-size: 20px;
                margin: 10px 0;
            }
            .period {
                font-size: 14px;
                color: #333;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                font-size: 12px;
            }
            th {
                background-color: #f0f0f0;
            }
            .footer {
                text-align: center;
                width: 200px;
                float: right;
            }
            .signature {
                margin-top: 10px;
                text-align: center;
            }
            .signature-line {
                width: 200px;
                margin-top: 80px;
            }
            .status-batal {
                color: #dc2626;
                font-weight: bold;
            }
            .status-selesai {
                color: #059669;
                font-weight: bold;
            }
        </style>
        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    </head>
    <body>
        <div class="header">
            <h1 class="title">LAPORAN STOK KELUAR</h1>
            <h2 class="subtitle">TOKO BANGUNAN YARA</h2>
            <?php if(isset($_GET['tipe_filter'])): ?>
                <div class="period">
                    <?php if($_GET['tipe_filter'] == 'tanggal' && !empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])): ?>
                        <p>Periode: <?php echo date('d/m/Y', strtotime($_GET['tanggal_awal'])) . ' - ' . date('d/m/Y', strtotime($_GET['tanggal_akhir'])); ?></p>
                    <?php endif; ?>
                    <?php if($_GET['tipe_filter'] == 'bulan' && !empty($_GET['month']) && !empty($_GET['year'])): ?>
                    <?php
                    $bulan = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember'
                    );
                    $periode = date('F Y', strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
                    $bulan_indo = $bulan[date('F', strtotime($_GET['year'].'-'.$_GET['month'].'-01'))];
                    ?>
                    <p>Periode: <?php echo $bulan_indo . ' ' . date('Y', strtotime($_GET['year'].'-'.$_GET['month'].'-01')); ?></p>                    <?php endif; ?>
                    <?php if($_GET['tipe_filter'] == 'tahun' && !empty($_GET['year_only'])): ?>
                        <p>Tahun: <?php echo $_GET['year_only']; ?></p>
                    <?php endif; ?>
                    <?php if(!empty($_GET['pelanggan'])): ?>
                        <?php 
                            $pelanggan_query = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = '".$_GET['pelanggan']."'");
                            $pelanggan_data = mysqli_fetch_assoc($pelanggan_query);
                        ?>
                        <p>Pelanggan: <?php echo $pelanggan_data['nama_pelanggan']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Faktur</th>
                    <th>Pelanggan</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['tipe_filter'])) {
                    $where = "1=1";

                    if($_GET['tipe_filter'] == 'tanggal' && !empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                        $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']);
                        $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']);
                        $where .= " AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                    }

                    if($_GET['tipe_filter'] == 'bulan' && !empty($_GET['month']) && !empty($_GET['year'])) {
                        $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                        $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                        $where .= " AND MONTH(p.tanggal) = '$month' AND YEAR(p.tanggal) = '$year'";
                    }

                    if($_GET['tipe_filter'] == 'tahun' && !empty($_GET['year_only'])) {
                        $year_only = mysqli_real_escape_string($koneksi, $_GET['year_only']);
                        $where .= " AND YEAR(p.tanggal) = '$year_only'";
                    }

                    if(!empty($_GET['pelanggan'])) {
                        $pelanggan = mysqli_real_escape_string($koneksi, $_GET['pelanggan']);
                        $where .= " AND p.id_pelanggan = '$pelanggan'";
                    }

                    if(isset($_GET['status']) && $_GET['status'] !== '') {
                        $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                        $where .= " AND p.status_dihapus = '$status'";
                    }

                    $query = "SELECT p.tanggal, p.status_dihapus, p.no_faktur_penjualan, pl.nama_pelanggan,
                            b.nama_barang, pd.qty
                            FROM penjualan p
                            JOIN penjualan_detail pd ON p.id_penjualan = pd.id_penjualan
                            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                            JOIN barang b ON pd.id_barang = b.id_barang
                            WHERE $where 
                            ORDER BY p.id_penjualan DESC, p.tanggal DESC";

                    $result = mysqli_query($koneksi, $query);
                
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }

                    $no = 1;
                    $total_qty = 0;
                    $total_transaksi = 0;
                    $total_selesai = 0;
                    $total_batal = 0;
                    $total_pelanggan = 0;

                    if (mysqli_num_rows($result) > 0) {
                        $pelanggan_unik = array();
                        $faktur_unik = array();
                        $faktur_selesai = array();
                        $faktur_batal = array();
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                            echo "<td>".$row['no_faktur_penjualan']."</td>";
                            echo "<td>".$row['nama_pelanggan']."</td>";
                            echo "<td>".$row['nama_barang']."</td>";
                            echo "<td>".$row['qty']."</td>";
                            echo "<td>";
                            echo $row['status_dihapus'] == 1 ? "<span class='status-batal'>Dibatalkan</span>" : "<span class='status-selesai'>Selesai</span>";
                            echo "</td>";
                            echo "</tr>";
                            
                            // Hitung total
                            if($row['status_dihapus'] == 0) {
                                $total_qty += $row['qty'];
                                if (!in_array($row['no_faktur_penjualan'], $faktur_selesai)) {
                                    $faktur_selesai[] = $row['no_faktur_penjualan'];
                                    $total_selesai++;
                                }
                            } else {
                                if (!in_array($row['no_faktur_penjualan'], $faktur_batal)) {
                                    $faktur_batal[] = $row['no_faktur_penjualan'];
                                    $total_batal++;
                                }
                            }
                            
                            if (!in_array($row['no_faktur_penjualan'], $faktur_unik)) {
                                $faktur_unik[] = $row['no_faktur_penjualan'];
                                $total_transaksi++;
                            }

                            if (!in_array($row['nama_pelanggan'], $pelanggan_unik)) {
                                $pelanggan_unik[] = $row['nama_pelanggan'];
                                $total_pelanggan++;
                            }

                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align: center;'>Tidak ada data</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>Silahkan pilih filter terlebih dahulu</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php if(isset($_GET['tipe_filter']) && mysqli_num_rows($result) > 0): ?>
        <div class="summary-info">
            <p><strong>Ringkasan:</strong></p>
            <p>Total Transaksi: <?php echo $total_transaksi; ?> Transaksi</p>
            <p>Total Transaksi Selesai: <?php echo $total_selesai; ?> Transaksi</p>
            <p>Total Transaksi Dibatalkan: <?php echo $total_batal; ?> Transaksi</p>
            <p>Total Jumlah Barang Keluar: <?php echo $total_qty; ?> Unit</p>
            <p>Total Jumlah Pelanggan: <?php echo $total_pelanggan; ?> Pelanggan</p>        
        </div>        
        <?php endif; ?>
        <div class="footer">
            <p>Padang, 
                <?php 
                    $bulan = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober', 
                        'November' => 'November',
                        'December' => 'Desember'
                    );
                    echo date('d ') . $bulan[date('F')] . date(' Y'); 
                ?>
            </p>            
            <div class="signature">
                <p>Pemilik</p>
                <div class="signature-line"></div>
                <p>(____________________)</p>
            </div>
        </div>
    </body>
</html>