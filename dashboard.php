<?php
    $judul_halaman = "Dashboard";
    
    include 'cek_login.php';
?>

<?php include 'layout/header.php'; ?>

<?php include 'layout/sidebar.php'; ?>

          <!-- Main Content Area -->
          <main class="flex-1 p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                  <!-- Total Penjualan -->
                  <?php if ($sesi_role_pengguna == "pemilik" || $sesi_role_pengguna == "admin") { ?> 
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-amber-500 text-white">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                              </svg>
                          </div>
                          <div class="ml-4">
                              <h2 class="text-gray-600 text-sm">Total Penjualan</h2>
                              <?php
                                $query = "SELECT SUM(total_harga) as total FROM penjualan WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                                $total_penjualan = number_format($row['total'], 0, ',', '.');
                              ?>
                              <p class="text-2xl font-semibold text-gray-800">Rp <?php echo $total_penjualan; ?></p>
                          </div>
                      </div>
                  </div>
                  <!-- Total Transaksi -->
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-yellow-500 text-white">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                              </svg>
                          </div>
                          <div class="ml-4">
                              <h2 class="text-gray-600 text-sm">Total Transaksi</h2>
                              <?php
                                $query = "SELECT COUNT(*) as total FROM penjualan WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                              ?>
                              <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                          </div>
                      </div>
                  </div>
                  <?php } ?>
                  <!-- Total Pelangggan -->
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-amber-500 text-white">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                              </svg>
                          </div>
                          <div class="ml-4">
                              <h2 class="text-gray-600 text-sm">Total Pelanggan</h2>
                              <?php
                                $query = "SELECT COUNT(*) as total FROM pelanggan WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                              ?>
                              <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                          </div>
                      </div>
                  </div>
                  <!-- Total Pengguna -->
                  <?php if ($sesi_role_pengguna == "pemilik" || $sesi_role_pengguna == "admin") { ?> 
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-amber-500 text-white">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                              </svg>
                          </div>
                          <div class="ml-4">
                              <h2 class="text-gray-600 text-sm">Total Pengguna</h2>
                              <?php
                                $query = "SELECT COUNT(*) as total FROM pengguna WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                              ?>
                              <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                          </div>
                      </div>
                  </div>
                  <?php } ?>

                  <!-- Total Barang -->
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <div class="flex items-center">
                          <div class="p-3 rounded-full bg-yellow-500 text-white">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                              </svg>
                          </div>
                          <div class="ml-4">
                              <h2 class="text-gray-600 text-sm">Total Barang</h2>
                              <?php
                                $query = "SELECT COUNT(*) as total FROM barang WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                              ?>
                              <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                          </div>
                      </div>
                  </div>
                  <!-- stok aman -->
                  <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-600 text-sm">Stok Aman</h2>
                            <?php
                                $query = "SELECT COUNT(*) as total FROM barang WHERE stok >= stok_minimum AND status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                            ?>
                            <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                <!-- stok kurang -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-500 text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-600 text-sm">Stok Kurang</h2>
                            <?php
                                $query = "SELECT COUNT(*) as total FROM barang WHERE stok < stok_minimum AND status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                $row = mysqli_fetch_assoc($result);
                            ?>
                            <p class="text-2xl font-semibold text-gray-800"><?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
              </div>

              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                  <div class="bg-white rounded-lg shadow-md p-6">
                      <h2 class="text-lg font-semibold mb-4">Ringkasan Penjualan</h2>
                      <canvas id="salesChart" width="400" height="200"></canvas>
                  </div>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        <?php
                        // Query untuk mendapatkan data penjualan per bulan
                        $query = "SELECT 
                            DATE_FORMAT(tanggal, '%Y-%m') as bulan,
                            SUM(total_harga) as total_penjualan,
                            COUNT(*) as jumlah_transaksi
                        FROM penjualan 
                        WHERE status_dihapus = 0
                        GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
                        ORDER BY bulan ASC
                        LIMIT 12";
                        
                        $result = mysqli_query($koneksi, $query);
                        
                        $months = [];
                        $totals = [];
                        $transactions = [];
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            $months[] = date('M Y', strtotime($row['bulan']));
                            $totals[] = (float)$row['total_penjualan'];
                            $transactions[] = (int)$row['jumlah_transaksi'];
                        }
                        ?>

                        const ctx = document.getElementById('salesChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($months); ?>,
                                datasets: [{
                                    label: 'Total Penjualan (Rp)',
                                    data: <?php echo json_encode($totals); ?>,
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgb(59, 130, 246)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                },
                                {
                                    label: 'Jumlah Transaksi',
                                    data: <?php echo json_encode($transactions); ?>,
                                    borderColor: 'rgb(34, 197, 94)',
                                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgb(34, 197, 94)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    yAxisID: 'transactions'
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 2000,
                                    easing: 'easeInOutQuart'
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        },
                                        title: {
                                            display: true,
                                            text: 'Total Penjualan (Rp)'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                return 'Rp ' + value.toLocaleString('id-ID');
                                            }
                                        }
                                    },
                                    transactions: {
                                        beginAtZero: true,
                                        position: 'right',
                                        grid: {
                                            drawOnChartArea: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Jumlah Transaksi'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Bulan'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                if (context.dataset.label === 'Total Penjualan (Rp)') {
                                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                                }
                                                return context.dataset.label + ': ' + context.parsed.y;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                  </script>

                  <div class="bg-white rounded-lg shadow-md p-6">
                      <h2 class="text-lg font-semibold mb-4">Pesanan Terbaru</h2>
                      <div class="overflow-x-auto">
                          <table class="w-full text-sm text-left text-gray-500">
                              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                  <tr>
                                      <th class="px-6 py-3">No Faktur</th>
                                      <th class="px-6 py-3">Pelanggan</th>
                                      <th class="px-6 py-3">Total Harga</th>
                                      <th class="px-6 py-3">Tanggal</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  $query = "SELECT p.no_faktur_penjualan, pl.nama_pelanggan, p.total_harga, p.tanggal 
                                           FROM penjualan p 
                                           LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                           WHERE p.status_dihapus = 0 
                                           ORDER BY p.tanggal DESC 
                                           LIMIT 2";
                                  $result = mysqli_query($koneksi, $query);
                                  while($row = mysqli_fetch_assoc($result)) {
                                  ?>
                                  <tr class="bg-white border-b">
                                      <td class="px-6 py-4"><?php echo $row['no_faktur_penjualan']; ?></td>
                                      <td class="px-6 py-4"><?php echo $row['nama_pelanggan'] ? $row['nama_pelanggan'] : 'Umum'; ?></td>
                                      <td class="px-6 py-4">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                      <td class="px-6 py-4"><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                  </tr>
                                  <?php } ?>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  
              </div>
          </main>

<?php include 'layout/footer.php'; ?>