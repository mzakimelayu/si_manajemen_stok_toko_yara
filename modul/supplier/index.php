<?php
    $judul_halaman = "Data Supplier";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

          <!-- Main Content Area -->
          <main class="flex-1 p-4 sm:p-6 animate-fade-in">
              <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 animate-slide-in-up">
                  
                <!-- Pesan Data Sukses -->
                <?php
                    if(isset($_SESSION['supplier_sukses'])) { ?>
                    <div id="alert-message" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
                        <p class="font-medium"><?php echo $_SESSION['supplier_sukses']; ?></p>
                        <button onclick="closeAlert()" class="text-green-700 hover:text-green-900">
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
                unset($_SESSION['supplier_sukses']);
                } 
                ?>  

                  <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4 animate-fade-in">
                      <h2 class="text-xl font-semibold text-gray-800">Data Supplier</h2>
                      <a href="tambah.php" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transform hover:scale-105 transition-transform duration-200">
                          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                          </svg>
                          Tambah Supplier
                      </a>
                  </div>

                  <div class="mb-4 animate-fade-in">
                      <div class="relative">
                          <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 transition-all duration-300" placeholder="Cari supplier...">
                          <div class="absolute left-3 top-2.5">
                              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                              </svg>
                          </div>
                      </div>
                  </div>

                  <div class="overflow-x-auto -mx-4 sm:-mx-6 animate-fade-in">
                      <div class="inline-block min-w-full align-middle">
                          <table id="penggunaTable" class="min-w-full border border-gray-200 divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th class="px-3 py-3 sm:px-6 text-xs cursor-pointer hover:bg-gray-100 border-r transition-colors duration-200" data-column="id">
                                          <div class="flex items-center">
                                              No
                                              <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-3 py-3 sm:px-6 text-xs cursor-pointer hover:bg-gray-100 border-r transition-colors duration-200" data-column="nama_supplier">
                                          <div class="flex items-center">
                                              Nama Supplier
                                              <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-3 py-3 sm:px-6 text-xs cursor-pointer hover:bg-gray-100 border-r transition-colors duration-200" data-column="kontak_supplier">
                                          <div class="flex items-center">
                                              Kontak
                                              <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-3 py-3 sm:px-6 text-xs cursor-pointer hover:bg-gray-100 border-r transition-colors duration-200" data-column="alamat_supplier">
                                          <div class="flex items-center">
                                              Alamat
                                              <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-3 py-3 sm:px-6 text-xs text-center">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200">
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4 animate-fade-in">
                      <div class="text-sm text-gray-600 w-full sm:w-auto flex items-center justify-center sm:justify-start">
                          <span id="paginationInfo"></span>
                          <select id="itemsPerPage" class="ml-2 border rounded px-2 py-1 transition-all duration-200">
                              <option value="10">10</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="all">Semua</option>
                          </select>
                      </div>
                      <div class="flex space-x-2 w-full sm:w-auto justify-center" id="paginationButtons">
                          <button class="px-3 py-1 border rounded hover:bg-gray-100 transition-colors duration-200" id="prevBtn">Sebelumnya</button>
                          <div id="pageNumbers" class="flex space-x-2"></div>
                          <button class="px-3 py-1 border rounded hover:bg-gray-100 transition-colors duration-200" id="nextBtn">Selanjutnya</button>
                      </div>
                  </div>
              </div>
          </main>
                   
          <script>
          let tableData = [];
          let currentPage = 1;
          let itemsPerPage = 10;
          let sortColumn = 'nama_supplier';
          let sortDirection = 'asc';
          
          async function fetchData() {
              try {
                  const response = await fetch('get_supplier.php');
                  const data = await response.json();
                  if (Array.isArray(data)) {
                      tableData = data;
                      renderTable();
                  } else {
                      console.error('Data tidak valid:', data);
                  }
              } catch (error) {
                  console.error('Error fetching data:', error);
              }
          }
          
          function initTable() {
              document.querySelectorAll('th[data-column]').forEach(header => {
                  header.addEventListener('click', () => {
                      const column = header.dataset.column;
                      if (sortColumn === column) {
                          sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                      } else {
                          sortColumn = column;
                          sortDirection = 'asc';
                      }
                      renderTable();
                  });
              });
          
              document.getElementById('searchInput').addEventListener('input', (e) => {
                  const searchTerm = e.target.value.toLowerCase();
                  filterTable(searchTerm);
              });
          
              document.getElementById('itemsPerPage').addEventListener('change', (e) => {
                  itemsPerPage = e.target.value === 'all' ? tableData.length : parseInt(e.target.value);
                  currentPage = 1;
                  renderTable();
              });
          
              document.getElementById('prevBtn').addEventListener('click', () => {
                  if (currentPage > 1) {
                      currentPage--;
                      renderTable();
                  }
              });
          
              document.getElementById('nextBtn').addEventListener('click', () => {
                  const totalPages = Math.ceil(tableData.length / itemsPerPage);
                  if (currentPage < totalPages) {
                      currentPage++;
                      renderTable();
                  }
              });
          }
          
          function filterTable(searchTerm) {
              const filteredData = tableData.filter(item => 
                  Object.values(item).some(value => 
                      value.toString().toLowerCase().includes(searchTerm)
                  )
              );
              currentPage = 1;
              renderTable(filteredData);
          }
          
          function sortData(data) {
              return [...data].sort((a, b) => {
                  let valueA = a[sortColumn];
                  let valueB = b[sortColumn];
                  
                  if (typeof valueA === 'string') {
                      valueA = valueA.toLowerCase();
                      valueB = valueB.toLowerCase();
                  }
                  
                  if (sortDirection === 'asc') {
                      return valueA > valueB ? 1 : -1;
                  } else {
                      return valueA < valueB ? 1 : -1;
                  }
              });
          }
          
          function renderTable(data = tableData) {
              const sortedData = sortData(data);
              const start = (currentPage - 1) * itemsPerPage;
              const paginatedData = sortedData.slice(start, start + itemsPerPage);
              
              const tbody = document.querySelector('tbody');
              tbody.innerHTML = '';
              
              paginatedData.forEach((row, index) => {
                  const tr = document.createElement('tr');
                  tr.className = 'bg-white hover:bg-gray-50';
                  tr.innerHTML = `
                      <td class="px-6 py-4 border-b border-r border-gray-200">${start + index + 1}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.nama_supplier}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.kontak_supplier}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.alamat_supplier}</td>
                      <td class="px-6 py-4 border-b border-gray-200">
                          <div class="flex justify-center space-x-3">
                              <button onclick="detailSupplier(${row.id})" class="text-red-500 hover:text-red-700 p-1.5 rounded-full hover:bg-red-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                              <button>
                              <button onclick="editSupplier(${row.id})" class="text-yellow-500 hover:text-yellow-700 p-1.5 rounded-full hover:bg-yellow-100">
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                  </svg>
                              </button>
                              <button onclick="hapusSupplier(${row.id})" class="text-red-500 hover:text-red-700 p-1.5 rounded-full hover:bg-red-100">
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                  </svg>
                              </button>
                          </div>
                      </td>                  
                      `;                  
                      tbody.appendChild(tr);
              });          
              updatePaginationInfo(sortedData.length, start);
              updatePaginationButtons(sortedData.length);
          }
          
          function updatePaginationInfo(totalItems, start) {
              const end = Math.min(start + itemsPerPage, totalItems);
              const paginationInfo = document.getElementById('paginationInfo');
              paginationInfo.textContent = `Menampilkan ${start + 1} - ${end} dari ${totalItems} item`;    
        }
          function updatePaginationButtons(totalItems) {
              const totalPages = Math.ceil(totalItems / itemsPerPage);
              const pageNumbers = document.getElementById('pageNumbers');
              pageNumbers.innerHTML = '';
            
              const maxButtons = 3;
              let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
              let endPage = Math.min(totalPages, startPage + maxButtons - 1);
            
              if (endPage - startPage + 1 < maxButtons) {
                  startPage = Math.max(1, endPage - maxButtons + 1);
              }
            
              for (let i = startPage; i <= endPage; i++) {
                  const button = document.createElement('button');
                  button.className = `px-3 py-1 border rounded ${i === currentPage ? 'bg-blue-500 text-white' : 'hover:bg-gray-100'}`;
                  button.textContent = i;
                  button.addEventListener('click', () => {
                      currentPage = i;
                      renderTable();
                  });
                  pageNumbers.appendChild(button);
              }
            
              document.getElementById('prevBtn').disabled = currentPage === 1;
              document.getElementById('nextBtn').disabled = currentPage === totalPages;
          }

          function editSupplier(id) {
              window.location.href = `edit.php?id=${id}`;
          }

          function detailSupplier(id) {
              window.location.href = `detail.php?id=${id}`;
          }

          async function hapusSupplier(id) {
              if (confirm('Apakah Anda yakin ingin menghapus supplier ini?')) {
                  try {
                      const response = await fetch(`hapus.php?id=${id}`, {
                          method: 'DELETE'
                      });
                      if (response.ok) {
                          alert('Supplier berhasil dihapus!');
                          fetchData();
                      } else {
                          alert('Gagal menghapus supplier!');
                      }
                  } catch (error) {
                      console.error('Error deleting data:', error);
                      alert('Terjadi kesalahan saat menghapus supplier!');
                      window.location.href = 'index.php';
                  }
              }
          }

          document.addEventListener('DOMContentLoaded', () => {
              initTable();
              fetchData();
          });

          </script>
        
<?php include ('../../layout/footer.php'); ?>