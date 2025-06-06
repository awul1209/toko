<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- alert -->
 <script src="assets/js/alert.js"></script>
</head>
<body>
    <div class="row p-4" style="height: 100vh; display: grid; place-items:center;">
            <div class="col-lg-4 border border-2 p-4 rounded-2" style="box-sizing: border-box;">
                <h3 class="text-center mb-3">Form Login</h3>
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
                    <button type="submit" name="login" class="btn btn-primary w-75 m-auto">Login</button>
                    <br>
                    <p class="d-block m-auto mt-2">Belum Punya akun?  <a class="text-decoration-none " href="daftar_seler.php">Daftar Sekarang</a> </p>
                
               
            </div>
          </form>

            </div>
    </div>

    <script>
        function togglePassword() {
            var previewImage = document.getElementById('image-preview');
            let imageUrlBuka = 'assets/img/icon_form/eye-biru.png';
            let imageUrlTutup = 'assets/img/icon_form/eye-tutup-biru.png';
            const passwordInput = document.getElementById('password');
            const passwordType = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = passwordType;
            if (passwordInput.type === 'password') {
              previewImage.src = imageUrlTutup;
            }else{
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
session_start();
include 'koneksi.php';

// Cek jika pengguna sudah login
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: backend/index.php");
    exit;
}

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Menggunakan prepared statement untuk mencegah SQL Injection
    $stmt = $koneksi->prepare("SELECT * FROM `seller` WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah email ada di database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Cek password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION["login"] = true;
            $_SESSION['ses_id'] = $row['id'];
            $_SESSION['ses_nama'] = $row['nama'];
            $_SESSION['ses_email'] = $row['email'];
            $_SESSION['ses_created_at'] = $row['created_at'];
            $_SESSION['ses_role'] =  $row['role'];

            echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'backend/index.php';
                    }
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Login Gagal',
                    text: 'Email atau password salah!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Login Gagal',
                text: 'Email atau password salah!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>
