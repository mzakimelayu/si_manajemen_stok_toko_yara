<div class="min-h-screen flex flex-col">
      <!-- Sidebar Overlay -->
      <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebarMobile()"></div>
      
      <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 bg-blue-700 text-white transition-all duration-300 transform md:translate-x-0 -translate-x-full sidebar-expanded z-50 flex flex-col">
        <div class="p-4 flex-shrink-0">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-2xl font-bold sidebar-item-text" id="adminTitle">Admin Panel</h2>
                <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-blue-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>            
        </div>
        <div class="flex-1 overflow-y-auto scrollbar-hide">
            <nav class="p-4 text-sm">
                <ul class="space-y-3">
                    <!-- Dashboard -->
                    <li>
                        <a href="<?= base_url('dashboard.php') ?>" class="flex items-center p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            <span class="ml-3 sidebar-item-text">Dashboard</span>
                        </a>
                    </li>     
                    <!-- Manajemen Barang -->
                    <?php if ($sesi_role_pengguna == "pemilik" || $sesi_role_pengguna == "admin") { ?> 
                    <li class="relative">
                        <button onclick="toggleSubmenu('userSubmenu_1')" class="w-full flex items-center justify-between p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/barang') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <div class="flex items-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                </svg>
                                <span class="ml-3 sidebar-item-text">Manajemen Barang</span>
                            </div>
                            <svg id="userSubmenu_1Arrow" class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                          <ul id="userSubmenu_1" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/barang') !== false) ? '' : 'hidden'; ?> submenu-transition pl-4 mt-2 space-y-2">
                            <li>
                            <a href="<?= base_url('modul/barang/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/barang') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM3 16a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                    Barang
                                </span> 
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/kategori/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Kategori
                                </span>
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/satuan/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                <span class="ml-3 sidebar-item-text">
                                Satuan
                                </span>
                            </a>
                            </li>
                        </ul>                      
                    </li>     
                    <!-- Manajemen Pembelian -->
                    <li class="relative">
                        <button onclick="toggleSubmenu('userSubmenu_2')" class="w-full flex items-center justify-between p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/supplier') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/pembelian') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <div class="flex items-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                                <span class="ml-3 sidebar-item-text">Manajemen Pembelian</span>
                            </div>
                            <svg id="userSubmenu_2Arrow" class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                          <ul id="userSubmenu_2" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/supplier') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/pembelian') !== false) ? '' : 'hidden'; ?> submenu-transition pl-4 mt-2 space-y-2">
                            <li>
                            <a href="<?= base_url('modul/supplier/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/supplier') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                    Supplier
                                </span> 
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/pembelian/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pembelian') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Transaksi Pembelian
                                </span>
                            </a>
                            </li>
                        </ul>                      
                    </li>       
                    <?php } ?>
                   <!-- Manajemen Penjuualan -->
                   <?php if ($sesi_role_pengguna == "kasir" || $sesi_role_pengguna == "admin") { ?> 
                    <li class="relative">
                        <button onclick="toggleSubmenu('userSubmenu_3')" class="w-full flex items-center justify-between p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <div class="flex items-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>                                
                                <span class="ml-3 sidebar-item-text">Manajemen Penjualan</span>
                            </div>
                            <svg id="userSubmenu_3Arrow" class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                          <ul id="userSubmenu_3" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? '' : 'hidden'; ?> submenu-transition pl-4 mt-2 space-y-2">
                            <li>
                            <a href="<?= base_url('modul/pelanggan/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                    Pelanggan
                                </span> 
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/penjualan/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Transaksi Penjualan
                                </span>
                            </a>
                            </li>
                        </ul>                      
                    </li>  
                    <?php } ?>
                    <!-- Manajemen Laporan -->
                    <?php if ($sesi_role_pengguna == "pemilik" || $sesi_role_pengguna == "admin") { ?> 
                    <li class="relative">
                        <button onclick="toggleSubmenu('userSubmenu_4')" class="w-full flex items-center justify-between p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_pembelian') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <div class="flex items-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"/>
                                </svg>                                
                                <span class="ml-3 sidebar-item-text">Manajemen Laporan</span>
                            </div>
                            <svg id="userSubmenu_4Arrow" class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                          <ul id="userSubmenu_4" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_pembelian') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? '' : 'hidden'; ?> submenu-transition pl-4 mt-2 space-y-2">
                            <li>
                            <a href="<?= base_url('modul/laporan_stok_masuk/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                    Laporan Stok Masuk
                                </span> 
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/laporan_stok_keluar/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Laporan Stok Keluar
                                </span>
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/laporan_pembelian/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_pembelian') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Laporan Pembelian
                                </span>
                            </a>
                            </li>
                            <li>
                            <a href="<?= base_url('modul/laporan_penjualan/index.php') ?>" class="block p-2 rounded-lg transition-colors duration-200 flex items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? 'bg-white hover:bg-blue-800 text-black hover:text-white' : 'hover:bg-blue-800'; ?>">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-4a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zm6-3a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>                                    
                                <span class="ml-3 sidebar-item-text">
                                Laporan Penjualan
                                </span>
                            </a>
                            </li>
                        </ul>                      
                    </li>  
                    <!-- Pengguna -->
                    <li>
                        <a href="<?= base_url('modul/pengguna/index.php') ?>" class="flex items-center p-3 rounded-lg sidebar-hover-card <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pengguna') !== false) ? 'bg-white text-black hover:bg-white hover:text-white' : 'bg-blue-800 hover:bg-blue-900'; ?>">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>                            
                            <span class="ml-3 sidebar-item-text">Pengguna</span>
                        </a>
                    </li>        
                    <?php } ?>          
                </ul>
            </nav>
        </div>
    </div>

      <!-- Main Content Container -->
      <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 bg-gray-100" id="mainContainer">
          <!-- Header -->
          <header class="bg-white shadow-md sticky top-0 z-40">
              <div class="flex items-center justify-between px-6 py-4">
                  <div class="flex items-center">
                      <button id="menuBtn" class="md:hidden mr-4 text-gray-600 hover:text-gray-900">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                          </svg>
                      </button>
                      <a href="<?= base_url('dashboard.php') ?>" class="text-2xl font-bold tracking-wider text-blue-900">YARA<span class="text-blue-600">BANGUNAN</span></a>
                  </div>
                  
                  <div class="flex items-center space-x-2 sm:space-x-4">
                      <!-- Notifications -->
                        <?php
                        // Query untuk mengecek stok barang
                        $query = "SELECT id_barang, nama_barang, stok, stok_minimum FROM barang WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        
                        $low_stock = 0;
                        $out_stock = 0;
                        $notifications = [];
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            if($row['stok'] == 0) {
                                $out_stock++;
                                $notifications[] = [
                                    'type' => 'danger',
                                    'message' => "Stok {$row['nama_barang']} habis!",
                                    'priority' => 1
                                ];
                            } else if($row['stok'] <= $row['stok_minimum']) {
                                $low_stock++;
                                $notifications[] = [
                                    'type' => 'warning',
                                    'message' => "Stok {$row['nama_barang']} hampir habis!",
                                    'priority' => 2
                                ];
                            }
                        }
                        
                        // Sort notifications by priority
                        usort($notifications, function($a, $b) {
                            return $a['priority'] - $b['priority'];
                        });
                        
                        $total_notifications = $low_stock + $out_stock;
                        ?>
                        
                        <div class="relative">
                            <button onclick="toggleNotificationMenu()" class="relative p-2 text-gray-700 hover:bg-gray-100 rounded-full transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <?php if($total_notifications > 0): ?>
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-0.5 sm:px-2.5 sm:py-1 text-xs font-bold leading-none text-white transform bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse"><?= $total_notifications ?></span>
                                <?php endif; ?>
                            </button>
                            
                            <div id="notificationMenu" class="hidden absolute right-0 mt-3 w-72 sm:w-96 bg-white rounded-2xl shadow-2xl py-2 z-50 backdrop-blur-sm border border-gray-100">
                                <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-100">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Notifikasi</h3>
                                </div>
                                <?php if(empty($notifications)): ?>
                                    <div class="flex flex-col items-center justify-center py-6 sm:py-8">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="mt-3 sm:mt-4 text-sm sm:text-base text-gray-500">Tidak ada notifikasi</p>
                                    </div>
                                <?php else: ?>
                                    <div class="h-[240px] sm:h-[280px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        <?php foreach($notifications as $notification): ?>
                                            <div class="px-3 sm:px-4 py-2 sm:py-3 hover:bg-gray-50 transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <?php if($notification['type'] == 'danger'): ?>
                                                            <div class="p-1.5 sm:p-2 bg-red-100 rounded-lg">
                                                                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="p-1.5 sm:p-2 bg-yellow-100 rounded-lg">
                                                                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-3 sm:ml-4 flex-1">
                                                        <p class="text-xs sm:text-sm font-medium text-gray-800"><?= $notification['message'] ?></p>
                                                        <p class="text-xs text-gray-500 mt-0.5 sm:mt-1">Baru saja</p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <script>
                        function toggleNotificationMenu() {
                            const menu = document.getElementById('notificationMenu');
                            menu.classList.toggle('hidden');
                            if (!menu.classList.contains('hidden')) {
                                menu.classList.add('animate-fadeIn');
                            }
                        }
                        
                        document.addEventListener('click', function(event) {
                            const menu = document.getElementById('notificationMenu');
                            const button = event.target.closest('button');
                            if (!menu.contains(event.target) && !button?.contains(event.target)) {
                                menu.classList.add('hidden');
                            }
                        });
                        
                        document.head.insertAdjacentHTML('beforeend', `
                            <style>
                                @keyframes fadeIn {
                                    from { opacity: 0; transform: translateY(-10px); }
                                    to { opacity: 1; transform: translateY(0); }
                                }
                                .animate-fadeIn {
                                    animation: fadeIn 0.3s ease-out;
                                }
                            </style>
                        `);
                        </script>
                      
                      <div class="relative">
                          <button onclick="toggleProfileMenu()" class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span class="hidden sm:block text-sm md:text-base text-gray-700"><?php echo $sesi_nama_lengkap_pengguna ?></span>
                          </button>
                          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 transform transition-all duration-300 ease-in-out">
                              <div class="px-4 py-2 border-b border-gray-100">
                                  <p class="text-sm font-semibold text-gray-800"><?php echo $sesi_nama_lengkap_pengguna ?></p>
                                  <p class="text-xs text-gray-500"><?php echo $sesi_role_pengguna; ?></p>
                              </div>
                              <div class="py-1">
                                  <a href="<?= base_url('modul/profil.php')?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                      <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                      </svg>
                                      Profil
                                  </a>
                                  <a href="<?= base_url('modul/pengaturan.php')?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                      <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                      </svg>
                                      Pengaturan Akun
                                  </a>
                              </div>
                              <div class="border-t border-gray-100">
                                  <a href="<?= base_url('logout.php') ?>" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                      <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                      </svg>
                                      Logout
                                  </a>
                              </div>
                          </div>                      
                        </div>
                  </div>
              </div>
          </header>