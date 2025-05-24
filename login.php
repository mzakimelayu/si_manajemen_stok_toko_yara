<?php
  // cek apakah ada session yang aktif
  session_start();
  if (isset($_SESSION['dataPengguna'])) {
      // Jika ada, redirect ke halaman dashboard
      header("Location: dashboard.php");
      exit();
  }

  // Panggil file koneksi.php untuk membuat koneksi ke database
  include 'koneksi/db.php';

// Logika login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form login
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Ambil password tanpa hash
    
    // Query untuk mencari user dengan username
    $query = "SELECT * FROM pengguna WHERE username_pengguna = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    // Cek apakah user ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data pengguna
        $data = mysqli_fetch_assoc($result);
          
        // Verifikasi password dengan password_verify
        if (password_verify($password, $data['password_pengguna'])) {
            // Simpan data pengguna ke dalam session
            $_SESSION['dataPengguna'] = $data;
            
            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Jika password tidak cocok
            $_SESSION['pesan_login'] = "Username atau password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        $_SESSION['pesan_login'] = "Username atau password salah!";
        header("Location: login.php");
        exit();
    }
}

?>


<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>Login | Sistem Informasi Manajemeen STOK Barang</title>
</head>
<body class="bg-gradient-to-r from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-auto hover:shadow-2xl transition duration-300">
    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold text-gray-800 mb-2 hover:text-blue-700 transition duration-300">MANAJEMEN STOK</h1>
      <p class="text-gray-600">Masuk menggunakan akun anda</p>
    </div>
    
    <!-- Pesan Error Saat Login Gagal -->
    <?php
        if(isset($_SESSION['pesan_login'])) { ?>
          <div id="alert-message" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
            <p class="font-medium"><?php echo $_SESSION['pesan_login']; ?></p>
            <button onclick="closeAlert()" class="text-red-700 hover:text-red-900">
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
      unset($_SESSION['pesan_login']);
    } 
    ?>

    <!-- Pesan Berhasil Saat Berhasil Logout -->
    <?php
        if(isset($_SESSION['pesan_logout'])) { ?>
          <div id="alert-message" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded animate-fade-in-down flex justify-between items-center" role="alert">
            <p class="font-medium"><?php echo $_SESSION['pesan_logout']; ?></p>
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
      unset($_SESSION['pesan_logout']);
    } 
    ?>  

    <form action="" method="POST" class="space-y-6">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
        <input type="text" id="username" name="username" 
               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-blue-700 outline-none transition duration-200"
               placeholder="Masukkan username anda"
               required>
      </div>
      
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" 
                 class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-blue-700 outline-none transition duration-200"
                 placeholder="Masukkan password anda"
                 required>
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>
      
      <button type="submit" 
              class="w-full bg-blue-700 text-white py-3 rounded-lg font-semibold hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition duration-200 transform hover:scale-[1.02] cursor-pointer">
        Login
      </button>
    </form>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }
  </script>
</body>
</html>