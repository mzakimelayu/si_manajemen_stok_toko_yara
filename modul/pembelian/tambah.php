<?php
    $judul_halaman = "Tambah Pembelian Barang";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 animate-fade-in">
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 border-b pb-4">Transaksi Pembelian Barang</h2>

            <!-- Pesan Error -->
            <?php
                if(isset($_SESSION['pembelian_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                    <p class="font-medium"><?php echo $_SESSION['pembelian_eror']; ?></p>
                    <button onclick="closeAlert()" c`lass="text-red-700 hover:text-red-900">
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
            unset($_SESSION['pembelian_eror']);
            } 
            ?>

            <form id="formPembelian" class="space-y-8" method="POST" action="proses_tambah.php">
                <div class="grid grid-cols-1 gap-8">
                    <!-- Informasi Transaksi -->
                    <div class="md:col-span-2 bg-gray-50 p-4 sm:p-6 rounded-lg space-y-4 sm:space-y-6 border border-gray-300">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                            <div class="w-full sm:flex-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Faktur <span class="text-red-500">*</span></label>
                                <input type="text" id="noFaktur" name="no_invoice_pembelian" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" placeholder="Masukkan No Faktur" required>
                            </div>
                            
                            <div class="w-full sm:flex-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pembelian <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggalPembelian" name="tanggal" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                            </div>
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                            <select id="supplier" name="id_supplier" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                                <option value="">Pilih Supplier</option>
                                <?php
                                $query = "SELECT * FROM supplier WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='".$row['id_supplier']."'>".$row['nama_supplier']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Tabel Input Barang -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden">
                    <div class="flex justify-between items-center p-4 bg-gray-50 border-b border-gray-300">
                        <h3 class="text-lg font-semibold text-gray-800">Detail Barang</h3>
                        <button type="button" id="tambahBarang" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Barang
                        </button>
                    </div>

                    <div id="tabelDinamis" class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300" style="min-width: 300px; width: 40%">Nama Barang</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300" style="width: 15%">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300" style="width: 20%">Harga Satuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300" style="width: 20%">Subtotal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300" style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="detailBarang" class="divide-y divide-gray-300">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total dan Diskon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div></div>
                    <div class="bg-gray-50 p-6 rounded-lg space-y-4 border border-gray-300">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold text-gray-700">Subtotal:</label>
                            <span id="subtotal" class="text-lg font-bold text-gray-900">Rp 0</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-lg border border-gray-300">
                            <label class="text-sm font-semibold text-gray-700">Diskon (%):</label>
                            <input type="number" id="diskonPersen" name="diskon" min="0" max="100" class="w-24 rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" value="0">
                            <span id="diskonNominal" class="text-gray-700 font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-300">
                            <label class="text-lg font-semibold text-gray-800">Total:</label>
                            <span id="totalAkhir" class="text-2xl font-bold text-blue-600">Rp 0</span>
                            <input type="hidden" name="total_bayar" id="totalBayarInput">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-300">
                    <a href="index.php" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let barangCounter = 0;
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            document.getElementById('tambahBarang').addEventListener('click', function() {
                tambahBarisBarang();
            });

            const form = document.getElementById('formPembelian');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
                        form.removeEventListener('submit', arguments.callee); // hindari loop
                        form.submit();
                    }
            });

            document.getElementById('diskonPersen').addEventListener('input', function() {
                hitungTotal();
            });

            function tambahBarisBarang() {
                barangCounter++;
                const row = document.createElement('tr');
                row.id = `barang-${barangCounter}`;
                row.innerHTML = `
                    <td class="px-4 py-3" style="min-width: 300px;">
                        <div class="relative">
                            <input type="text" 
                                class="search-barang w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" 
                                placeholder="Masukkan kode/nama barang"
                                onkeypress="searchBarang(event, this, ${barangCounter})">
                            <input type="hidden" name="barang[${barangCounter}][id_barang]" class="barang-id">
                            <input type="hidden" name="barang[${barangCounter}][kode_barang]" class="barang-kode">
                            <div class="search-results absolute w-full bg-white border border-gray-300 rounded-lg mt-1 shadow-lg hidden z-50 max-h-60 overflow-y-auto"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="barang[${barangCounter}][qty]" class="qty w-20 rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" min="1" value="1" required onchange="hitungSubtotal(this)">
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="barang[${barangCounter}][harga_satuan]" class="harga w-32 rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" min="0" step="0.01" required onchange="hitungSubtotal(this)">
                    </td>
                    <td class="px-4 py-3">
                        <span class="subtotal">Rp 0</span>
                        <input type="hidden" name="barang[${barangCounter}][subtotal]" class="subtotal-input">
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="hapusBarang(${barangCounter})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                `;
                document.getElementById('detailBarang').appendChild(row);
            }

            window.searchBarang = function(event, input, counter) {
                if(event.key === 'Enter') {
                    event.preventDefault();
                    const searchTerm = input.value.trim();
                    const resultsDiv = input.parentElement.querySelector('.search-results');
                    const tabelDinamis = document.getElementById('tabelDinamis');
                    tabelDinamis.style.height = '400px';
                    tabelDinamis.style.overflowY = 'auto';

                    fetch(`search_barang.php?term=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsDiv.innerHTML = '';
                            if(data.length > 0) {
                                data.forEach(item => {
                                    const div = document.createElement('div');
                                    div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                    div.innerHTML = `${item.kode_barang} - ${item.nama_barang}`;
                                    div.onclick = function() {
                                        // Check if item already exists in any row by kode_barang
                                        const existingBarang = document.querySelectorAll('.barang-kode');
                                        for(let barang of existingBarang) {
                                            if(barang.value === item.kode_barang) {
                                                alert('Barang dengan kode ' + item.kode_barang + ' sudah ada dalam daftar!');
                                                resultsDiv.classList.add('hidden');
                                                input.value = '';
                                                return;
                                            }
                                        }
                                        
                                        input.value = item.nama_barang;
                                        input.parentElement.querySelector('.barang-id').value = item.id_barang;
                                        input.parentElement.querySelector('.barang-kode').value = item.kode_barang;
                                        const row = input.closest('tr');
                                        const hargaInput = row.querySelector('.harga');
                                        hargaInput.value = item.harga_beli;
                                        hitungSubtotal(hargaInput);
                                        resultsDiv.classList.add('hidden');
                                    };
                                    resultsDiv.appendChild(div);
                                });
                                resultsDiv.classList.remove('hidden');
                            }
                        });
                }
            };

            window.hitungSubtotal = function(element) {
                const row = element.closest('tr');
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const harga = parseFloat(row.querySelector('.harga').value) || 0;
                const subtotal = qty * harga;
                row.querySelector('.subtotal').textContent = `Rp ${formatter.format(subtotal)}`;
                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                hitungTotal();
            }

            window.hapusBarang = function(counter) {
                if(confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
                    document.getElementById(`barang-${counter}`).remove();
                    hitungTotal();
                }
            }

            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                const diskonPersen = parseFloat(document.getElementById('diskonPersen').value) || 0;
                const diskonNominal = total * (diskonPersen / 100);
                const totalAkhir = total - diskonNominal;

                document.getElementById('subtotal').textContent = `Rp ${formatter.format(total)}`;
                document.getElementById('diskonNominal').textContent = `Rp ${formatter.format(diskonNominal)}`;
                document.getElementById('totalAkhir').textContent = `Rp ${formatter.format(totalAkhir)}`;
                document.getElementById('totalBayarInput').value = totalAkhir.toFixed(2);
            }
        });
    </script>


<?php include ('../../layout/footer.php'); ?>