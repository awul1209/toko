<?php
include 'koneksi.php';
error_reporting(0);
session_start();
if (isset($_SESSION['ses_nama'])) {
    $s_id = $_SESSION['ses_id'];
    $s_nama = $_SESSION['ses_nama'];
    $s_email = $_SESSION['ses_email'];
    $s_pa = $_SESSION['ses_password'];
    $s_role = $_SESSION['ses_role'];
    $s_created = $_SESSION['ses_created_at'];
  }
$page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Link ke Bootstrap Icons CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/produk.css">
<link rel="stylesheet" href="assets/css/dashboard.css">
<link rel="stylesheet" href="assets/css/keranjang.css">
<link rel="stylesheet" href="assets/css/detail.css">
<link rel="stylesheet" href="assets/css/toko.css">
<link rel="stylesheet" href="assets/css/tr.css">
<link rel="stylesheet" href="assets/css/chat.css">
<link rel="stylesheet" href="assets/css/pesan.css">
<link rel="stylesheet" href="assets/css/tentang.css">
<link rel="stylesheet" href="assets/css/rating.css">

<!-- jquery -->
<script src="assets/js/jquery-3.7.1.js"></script>
    <!-- alert -->
    <script src="assets/js/alert.js"></script>
</head>
<body>

    <header>
        <?php include 'header.php'; ?>
    </header>
    <main role="main">
        <!-- web dinamis -->
        <?php include 'page.php' ?>
    </main>

   

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Marketplace UMKM Sumenep. by. Sucia.</p>
    </footer>


    <!-- Modal Login -->
  <div class="modal fade" id="modallogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Login Now!</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="Masukkan Email">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Password</label>
              <div class="input-group mb-2">
                <input type="password" name="password" id="password" class="form-control" aria-describedby="button-addon2">
                <button onclick="togglePassword()" class="btn btn-outline-secondary" type="button" id="button-addon2"><img id="image-preview" src="assets/img/icon_form/eye-tutup-biru.png" alt="eye" width="25"></button>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
        <div class="mb-3">
          <center>
            <p>Belum Punya Akun ? <a href="register.php">Daftar Sekarang!</a></p>
          </center>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal login -->

  <script>
     function togglePassword() {
      var previewImage = document.getElementById('image-preview');
      let imageUrlBuka = 'assets/images/icon_form/eye-biru.png';
      let imageUrlTutup = 'assets/images/icon_form/eye-tutup-biru.png';
      const passwordInput = document.getElementById('password');
      const passwordType = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = passwordType;
      if (passwordInput.type === 'password') {
        previewImage.src = imageUrlTutup;
      } else {
        previewImage.src = imageUrlBuka;
      }
    }
  </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['login'])) {
  // echo "<script>alert('hai');</script>";
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);

  $result = mysqli_query($koneksi, "SELECT * FROM `user` WHERE email = '$email'");
  // cek username
  if (mysqli_num_rows($result) > 0) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {

    if($row['role'] =='admin'){
          // set session
    $_SESSION["login"] = true;
    $_SESSION['ses_id'] = $row['id'];
    $_SESSION['ses_nama'] = $row['nama'];
    $_SESSION['ses_email'] = $row['email'];
    $_SESSION['ses_role'] = $row['role'];
    $_SESSION['ses_password'] = $row['password'];
    echo "<script>
    Swal.fire({title: 'Login Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
    }).then((result) => {if (result.value){
      window.location = 'backend/index.php';
      }
      })</script>";
      die();
    }else {
      // set session
      $_SESSION["login"] = true;
      $_SESSION['ses_id'] = $row['id'];
      $_SESSION['ses_nama'] = $row['nama'];
      $_SESSION['ses_email'] = $row['email'];
      $_SESSION['ses_password'] = $row['password'];
      $_SESSION['ses_role'] = $row['role'];
      $_SESSION['ses_created_at'] = $row['created_at'];
      echo "<script>
                Swal.fire({title: 'Login Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
                }).then((result) => {if (result.value){
                    window.location = 'index.php';
                    }
                    })</script>";
    } 
  }  else {
    echo "<script>
        alert('Gagagl LOgin');
      </script>";
  }
}else {
  echo "<script>
      alert('Username Tidak Ada');
    </script>";
}
}
?>



