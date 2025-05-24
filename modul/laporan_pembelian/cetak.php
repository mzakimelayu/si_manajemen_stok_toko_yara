<?php
    $judul_halaman = "Print Laporan Pembelian";
    
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
            <h1 class="title">LAPORAN PEMBELIAN</h1>
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
                    <?php if(!empty($_GET['supplier'])): ?>
                        <?php 
                            $supplier_query = mysqli_query($koneksi, "SELECT nama_supplier FROM supplier WHERE id_supplier = '".$_GET['supplier']."'");
                            $supplier_data = mysqli_fetch_assoc($supplier_query);
                        ?>
                        <p>Supplier: <?php echo $supplier_data['nama_supplier']; ?></p>
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
                    <th>Supplier</th>
                    <th>Kontak Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Stok</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Petugas</th>
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

                    if(!empty($_GET['supplier'])) {
                        $supplier = mysqli_real_escape_string($koneksi, $_GET['supplier']);
                        $where .= " AND p.id_supplier = '$supplier'";
                    }

                    if(isset($_GET['status']) && $_GET['status'] !== '') {
                        $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                        $where .= " AND p.status_dihapus = '$status'";
                    }

                    $query = "SELECT p.tanggal, p.status_dihapus, p.no_invoice_pembelian, p.diskon, p.total_bayar,
                            s.nama_supplier, s.kontak_supplier, s.alamat_supplier,
                            b.nama_barang, b.kode_barang, b.stok,
                            pd.qty, pd.harga_satuan, pd.subtotal,
                            pg.nama_lengkap_pengguna
                            FROM pembelian p
                            JOIN pembelian_detail pd ON p.id_pembelian = pd.id_pembelian
                            JOIN supplier s ON p.id_supplier = s.id_supplier
                            JOIN barang b ON pd.id_barang = b.id_barang
                            JOIN pengguna pg ON p.id_pengguna = pg.id_pengguna
                            WHERE $where
                            ORDER BY p.id_pembelian DESC, p.tanggal DESC";

                    $result = mysqli_query($koneksi, $query);
                
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }

                    $no = 1;
                    $total_qty = 0;
                    $total_subtotal = 0;
                    $total_diskon = 0;
                    $total_bayar_all = 0;

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                            echo "<td>".$row['no_invoice_pembelian']."</td>";
                            echo "<td>".$row['nama_supplier']."</td>";
                            echo "<td>".$row['kontak_supplier']."</td>";
                            echo "<td>".$row['alamat_supplier']."</td>";
                            echo "<td>".$row['nama_barang']."</td>";
                            echo "<td>".$row['kode_barang']."</td>";
                            echo "<td>".$row['stok']."</td>";
                            echo "<td>Rp ".number_format($row['harga_satuan'],2,',','.')."</td>";
                            echo "<td>".$row['qty']."</td>";
                            echo "<td>Rp ".number_format($row['subtotal'],2,',','.')."</td>";
                            echo "<td>Rp ".number_format(($row['subtotal'] * $row['diskon'] / 100),2,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['total_bayar'],2,',','.')."</td>";
                            echo "<td>".$row['nama_lengkap_pengguna']."</td>";
                            echo "<td>";
                            echo $row['status_dihapus'] == 1 ? "<span class='status-batal'>Dibatalkan</span>" : "<span class='status-selesai'>Selesai</span>";
                            echo "</td>";
                            echo "</tr>";
                            
                            // Menghitung total
                            $total_qty += $row['qty'];
                            $total_subtotal += $row['subtotal'];
                            $total_diskon += ($row['subtotal'] * $row['diskon'] / 100);
                            $total_bayar_all += $row['total_bayar'];
                            
                            $no++;
                        }
                        // Menampilkan baris total
                        echo "<tr class='total-row'>";
                        echo "<td colspan='10'><strong>Total</strong></td>";
                        echo "<td><strong>".$total_qty."</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_subtotal,2,',','.')."</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_diskon,2,',','.')."</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_bayar_all,2,',','.')."</strong></td>";
                        echo "<td colspan='2'></td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='16' style='text-align: center;'>Tidak ada data</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='16' style='text-align: center;'>Silahkan pilih filter terlebih dahulu</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
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