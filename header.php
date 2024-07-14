<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $nama_pengguna = $_SESSION['username']; // Sesuaikan dengan nama session yang Anda simpan
    $login_status = true; // Variabel untuk menandakan bahwa pengguna sudah login
} else {
    $login_status = false; // Variabel untuk menandakan bahwa pengguna belum login
}
?>
  <!-- ***** Header Area Start ***** -->
  <!-- Memuat jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Memuat Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Memuat Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
  $('#profile-link').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: 'get_profile_user.php',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        var birthdate = new Date(response.tanggal_lahir);
        var today = new Date();
        var age = today.getFullYear() - birthdate.getFullYear();
        var m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
          age--;
        }
        $('#profile-info').html(`
          <div>
            <img src="data:image/jpeg;base64,${response.photo_blob}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;" />
          </div>
          <div>
            <p style="margin-top: 10px; font-weight: bold;">${response.nama_user}</p>
            <p>${birthdate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} (${age} tahun)</p>
          </div>
        `);
        $('#profileModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error('Error fetching profile:', error);
        alert('Error fetching profile. Please try again.');
      }
    });
  });
  $('#logout-link').click(function(e) {
    e.preventDefault();
    $('#logoutModal').modal('show');
  });
  $('#logoutModal button.btn-danger').click(function() {
    window.location.href = 'auth/process_logout.php';
  });
});
</script>

<style>
    header {
      top: 0;
    }

    .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #C23BFE;
    min-width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    left: 0;
    margin-top: 8px;
}

.dropdown-content a {
    color: black;
    text-decoration: none;
    display: block;
    white-space: nowrap; /* Agar teks tidak mematah-matah */
    text-align: center;
}

.dropdown-content a:hover {
    background-color: #5B03E4;
}


.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown .dropbtn {
    text-decoration: none;
    color: black;
}

</style>
  <header class="header-area header-sticky" id="main-header">
    <div class="container">
      <div class="row">
        <nav class="main-nav">
          <!-- ***** Logo Start ***** -->
          <a href="index.php" class="logo">
            <img src="assets/images/Markiba3.png" alt="" style="width: 250px;"/>
          </a>
          <ul class="nav">
              <li><a href="<?php echo ($activePage == 'home') ? '#' : 'index.php'; ?>" <?php echo ($activePage == 'home') ? 'class="active"' : ''; ?>>Home</a></li>
              <li class="dropdown">
                  <a href="<?php echo ($activePage == 'kategori') ? '#' : 'kategori.php'; ?>" <?php echo ($activePage == 'kategori') ? 'class="active"' : ''; ?>>Kategori <i class="fa fa-caret-down"></i></a>
                  <div class="dropdown-content">
                      <a href="ulasan_kategori.php?id_kategori=1">Kesusastraan</a>
                      <a href="ulasan_kategori.php?id_kategori=2">Filsafat & Psikologi</a>
                      <a href="ulasan_kategori.php?id_kategori=3">Sejarah & Geografi</a>
                      <!-- Tambahkan submenu sesuai kebutuhan -->
                  </div>
              </li>
              <li><a href="<?php echo ($activePage == 'ulasan') ? '#' : 'ulasan.php'; ?>" <?php echo ($activePage == 'ulasan') ? 'class="active"' : ''; ?>>Ulasan</a></li>
              <li><a href="<?php echo ($activePage == 'artikel') ? '#' : 'artikel.php'; ?>" style="padding-right: 10px;" <?php echo ($activePage == 'artikel') ? 'class="active"' : ''; ?>>Artikel</a></li>
              <li><a href="<?php echo ($activePage == 'about') ? '#' : 'about.php'; ?>" <?php echo ($activePage == 'about') ? 'class="active"' : ''; ?>>About Us</a></li>
              <?php if ($login_status==false) {
                ?>
                  <li><a href="<?php echo ($activePage == 'login') ? '#' : 'auth/login.php'; ?>" <?php echo ($activePage == 'login') ? 'class="active"' : ''; ?>>Login</a></li>
                <?php
              }else{
                ?>
              <li class="dropdown">
                <a class="dropbtn"  style="padding-top:8px;">
                <i class="fa fa-user-circle" style="font-size: 35px;"></i>
                </a>
                <div class="dropdown-content" style="min-width:150px;">
                  <?php
                  if($_SESSION['is_manager']){
                    echo '<a href="manager/index.php">Dashboard</a>';
                  }else if($_SESSION['is_admin']){
                    echo '<a href="admin/pages/buku/buku.php">Dashboard</a>';
                  }else {
                    echo '<a href="#" id="profile-link">Profile</a>';
                  }
                  ?>
                  <a id="logout-link" href="#">Keluar</a>
                </div>
              </li>
              <?php
            }
            ?>
          </ul>
          <!-- ***** Menu End ***** -->
        </nav>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="profileModalLabel">Profil Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="profile-info">
            <!-- Data profil pengguna akan dimasukkan di sini -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-center" style="display: block;">
          <h5 class="modal-title" id="logoutModalLabel">Beneran Mau Keluar?</h5>
        </div>
        <div class="modal-body text-center">
          <div>
            <button type="submit" data-bs-dismiss="modal" class="btn btn-success">Batal</button>
            <button type="submit" class="btn btn-danger">Keluar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let lastScrollTop = 0;
    const header = document.getElementById('main-header');

    window.addEventListener('scroll', function() {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop) {
        // Scroll ke bawah - sembunyikan header
        header.style.transform = 'translateY(-100%)';
      } else {
        // Scroll ke atas - tampilkan kembali header
        header.style.transform = 'translateY(0)';
      }
      lastScrollTop = scrollTop;
    });
  </script>