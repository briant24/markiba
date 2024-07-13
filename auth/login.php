<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Markiba</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../admin/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../admin/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../admin/images/Markiba.png" />
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-6 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center">
                <img src="../admin/images/Markiba.png">
              </div>
              <h4>Login</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form id="loginForm" class="pt-3">
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
              </form>
              <div><ul></div>
              <div>
              <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../admin/vendors/js/vendor.bundle.base.js"></script>
  <script src="../admin/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../admin/js/off-canvas.js"></script>
  <script src="../admin/js/misc.js"></script>
  <!-- endinject -->
  <script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Menghentikan pengiriman form default
      
      // Mengambil nilai dari form
      var formData = new FormData(this);

      // Kirim data ke server menggunakan AJAX
      fetch('process_login.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
            console.log(data);
              if (data.isManager) {
                  // Tampilkan Sweet Alert untuk manager
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Berhasil sebagai Manager!',
                      text: 'Selamat datang kembali, Manager.'
                  }).then(() => {
                      // Redirect ke halaman manager
                      window.location.href = '../manager/index.php';
                  });
              } else if (data.isAdmin) {
                  // Tampilkan Sweet Alert untuk admin
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Berhasil sebagai Admin!',
                      text: 'Selamat datang kembali, Admin.'
                  }).then(() => {
                      // Redirect ke halaman admin
                      window.location.href = '../admin/index.php';
                  });
              } else {
                  // Tampilkan Sweet Alert untuk user
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Berhasil!',
                      text: 'Selamat datang kembali.'
                  }).then(() => {
                      // Redirect ke halaman user
                      window.location.href = '../index.php';
                  });
              }
          } else {
              // Tampilkan Sweet Alert untuk login gagal
              Swal.fire({
                  icon: 'error',
                  title: 'Login Gagal!',
                  text: 'Username atau password salah.'
              });
          }
      })
      .catch(error => {
          console.error('Error:', error);
          // Tampilkan pesan error umum jika terjadi kesalahan
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
          });
      });
  });
  </script>

</body>

</html>
