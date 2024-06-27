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
    position: relative; /* Memastikan posisi relatif untuk elemen induk */
    cursor: pointer;
  }

/* Dropdown button */
.dropdown .dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  color: white;
  background-color: inherit;
  font-family: inherit; /* Important for vertical align on mobile phones */
  margin: 0; /* Important for vertical align on mobile phones */
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #BD38FD;
  min-width: 100px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1000;
}
/* Links inside the dropdown */
.dropdown-content a {
  text-align: center;
}

/* Add a grey background color to dropdown links on hover */
.dropdown-content a:hover {
  background-color: #5701E4;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
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
                <a class="dropbtn"><?php echo $nama_pengguna?>
                  <i class="fa fa-caret-down"></i>
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