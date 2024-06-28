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
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    padding: 8px 0;
    left: 0; 
    margin-top: 8px;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    text-align:center;
    display: block;
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
    padding: 8px;
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
              <li><a href="<?php echo ($activePage == 'kategori') ? '#' : 'kategori.php'; ?>" <?php echo ($activePage == 'kategori') ? 'class="active"' : ''; ?>>Kategori</a></li>
              <li><a href="<?php echo ($activePage == 'ulasan') ? '#' : 'ulasan.php'; ?>" <?php echo ($activePage == 'ulasan') ? 'class="active"' : ''; ?>>Ulasan</a></li>
              <li><a href="<?php echo ($activePage == 'artikel') ? '#' : 'artikel.php'; ?>" <?php echo ($activePage == 'artikel') ? 'class="active"' : ''; ?>>Artikel</a></li>
              <li><a href="<?php echo ($activePage == 'about') ? '#' : 'about.php'; ?>" <?php echo ($activePage == 'about') ? 'class="active"' : ''; ?>>About Us</a></li>
              <?php if ($login_status==false) {
                ?>
                  <li><a href="<?php echo ($activePage == 'login') ? '#' : 'auth/login.php'; ?>" <?php echo ($activePage == 'login') ? 'class="active"' : ''; ?>>Login</a></li>
                <?php
              }else{
                ?>
              <li class="dropdown">
                <a class="dropbtn">
                <i class="fa fa-user-circle" style="font-size: 35px;"></i>
                </a>
                <div class="dropdown-content">
                  <?php
                  if($_SESSION['is_admin']){
                    echo '<a href="admin/index.php">Dashboard</a>';
                  }else{
                    echo '<a href="#">Profile</a>';
                  }
                  ?>
                  <a href="auth/process_logout.php">Keluar</a>
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