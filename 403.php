<?php

function base_url($path = '') {
    $host = $_SERVER['HTTP_HOST'];
    
    // Jika menggunakan Ngrok, paksa HTTPS
    if (strpos($host, "ngrok-free.app") !== false) {
        $protocol = "https";
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    }

    $project_folder = "/si_manajemen_stok_toko_yara/"; 

    return $protocol . '://' . $host . $project_folder . $path;
}
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>403 Dilarang | Akses Ditolak</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-2xl w-full bg-white rounded-lg shadow-xl overflow-hidden">
    <div class="bg-blue-700 p-8 text-white text-center">
      <h1 class="text-6xl font-bold mb-4">403</h1>
      <h2 class="text-2xl font-semibold mb-2">Akses Dilarang</h2>
      <div class="w-16 h-1 bg-amber-500 mx-auto my-4"></div>
    </div>
    
    <div class="bg-gray-100 p-8">
      <div class="text-center">
        <p class="text-gray-800 text-lg mb-6">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a href="<?= base_url('dashboard.php') ?>" class="px-6 py-3 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 font-medium">
            Kembali ke Beranda
          </a>
          <a href="javascript:history.back()" class="px-6 py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors duration-200 font-medium">
            Kembali
          </a>
        </div>
      </div>
    </div>
    
    <div class="bg-slate-50 p-4 border-t border-gray-200">
      <p class="text-center text-gray-600 text-sm">
        Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem
      </p>
    </div>
  </div>
</body>
</html>