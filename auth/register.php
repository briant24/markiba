<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Markiba</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../admin/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../admin/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../admin/images/Markiba.png" />
  <!-- CSS Cropper.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

  <!-- Script Cropper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

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
              <h4>Daftar</h4>
              <h6 class="font-weight-light">Miliki Akun untuk mengakses semua fitur.</h6>
              <form class="pt-3" action="process_register.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" name="username" id="username" class="form-control form-control-lg"
                    placeholder="Username (maksimal 10 karakter)" maxlength="10" required>
                  <span id="usernameError" class="error-message"></span>
                </div>
                <div class="form-group">
                  <input type="text" name="fullname" class="form-control form-control-lg" placeholder="Nama Lengkap"
                    required>
                </div>
                <div class="form-group">
                  <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Email"
                    required>
                  <span id="emailError" class="error-message"></span>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg"
                    placeholder="Password (minimal 8 karakter)" minlength="8" required>
                </div>
                <div class="form-group">
                  <label for="birthdate">Tanggal Lahir:</label>
                  <input type="date" id="birthdate" name="birthdate" class="form-control form-control-lg" required>
                </div>
                <div>
                  <label for="profilePic">Foto Profil:</label>
                  <input type="file" id="profilePic" name="profilePic" class="form-control-file" accept="image/*">
                </div>
                <div class="mt-3">
                  <button type="submit"
                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Daftar</button>
                </div>
              </form>
              <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Masuk</a></p>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../admin/vendors/js/vendor.bundle.base.js"></script>
  <script src="../admin/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../admin/js/off-canvas.js"></script>
  <script src="../admin/js/misc.js"></script>
  <!-- endinject -->
  <script>
    $(document).ready(function() {
      // Event listener untuk input username
      $('#username').on('input', function() {
        var username = $(this).val();
        // Kirim permintaan AJAX
        $.ajax({
          url: 'check_username.php',
          method: 'POST',
          data: { username: username },
          success: function(response) {
            console.log(username);
            console.log(response);
            if (response === 'taken') {
              $('#usernameError').html('Username sudah digunakan. Silakan pilih username lain.');
              $('#username').addClass('is-invalid'); // Contoh penambahan kelas untuk memberi tahu pengguna
            } else {
              $('#usernameError').html('');
              $('#username').removeClass('is-invalid');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            $('#usernameError').html('Terjadi kesalahan. Silakan coba lagi nanti.');
          }
        });
      });

      // Event listener untuk input email
      $('#email').on('input', function() {
        var email = $(this).val();
        // Kirim permintaan AJAX
        $.ajax({
          url: 'check_email.php',
          method: 'POST',
          data: { email: email },
          success: function(response) {
            console.log(email);
            console.log(response);
            if (response === 'taken') {
              $('#emailError').html('Email sudah digunakan. Silakan gunakan email lain.');
              $('#email').addClass('is-invalid'); // Contoh penambahan kelas untuk memberi tahu pengguna
            } else {
              $('#emailError').html('');
              $('#email').removeClass('is-invalid');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            $('#emailError').html('Terjadi kesalahan. Silakan coba lagi nanti.');
          }
        });
      });
    });
  </script>
  <script>
  $(document).ready(function() {
    var cropper;

    // Event listener untuk input file
    $('#profilePic').change(function(e) {
      var file = e.target.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        var imgData = event.target.result;
        
        // Tampilkan modal
        $('#cropModal').modal({
          backdrop: 'static',
          keyboard: false
        });

        // Inisialisasi cropper
        var image = document.getElementById('cropImage');
        image.src = imgData;
        cropper = new Cropper(image, {
          aspectRatio: 1 / 1,
          viewMode: 1,
          movable: false,
          zoomable: false,
          rotatable: false,
          scalable: false,
          crop: function(event) {
            // Dapat mengakses koordinat cropping dengan event.detail
          }
        });
      };

      reader.readAsDataURL(file);
    });

    // Event listener untuk tombol Simpan di modal
    $('#cropButton').click(function() {
      var croppedCanvas = cropper.getCroppedCanvas({
        width: 200, // Ukuran hasil cropping yang diinginkan
        height: 200,
        fillColor: '#fff'
      });

      // Dapatkan data URL hasil cropping
      var croppedDataUrl = croppedCanvas.toDataURL('image/jpeg');

      // Gunakan data URL untuk tindakan selanjutnya, seperti menampilkan preview atau mengirim ke server
      $('#previewProfilePic').attr('src', croppedDataUrl);
      
      // Sembunyikan modal
      $('#cropModal').modal('hide');
    });
  });
</script>

<!-- Modal untuk preview dan cropping -->
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropModalLabel">Crop Foto Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <img id="cropImage" src="#" alt="Crop Area" style="max-width: 100%; height: auto;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="cropButton">Simpan</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
