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
    <div class="row" style="height: 100vh; display: grid; place-items:center;">
            <div class="col-lg-4 border border-2 p-4 rounded-2" style="box-sizing: border-box;">
                <h3 class="text-center mb-3">Form Register Seller</h3>
                <form action="" method="post">
                <div class="mb-2">
                    <label for="nama" class="mb-2">Masukkan Nama</label>
                    <input type="nama" name="nama" id="nama" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="email" class="mb-2">Masukkan Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="kontak" class="mb-2">Masukkan Kontak</label>
                    <input type="text" name="kontak" id="kontak" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="alamat" class="mb-2">Masukkan Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"></textarea>
                </div>
                <div class="mb-2">
                    <label for="toko" class="mb-2">Nama Toko</label>
                    <input type="text" name="toko" id="toko" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="deskripsi" class="mb-2">Deskripsi Toko</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                </div>
                <label for="password" class="mb-2">Masukkan Password</label>
                <div class="input-group mb-2">
                    <input type="password" name="password" id="password" class="form-control" aria-describedby="button-addon2">
                    <button onclick="togglePassword()" class="btn btn-outline-secondary" type="button" id="button-addon2"><img id="image-preview" src="assets/img/icon_form/eye-tutup-biru.png" alt="eye" width="25" ></button>
                </div>
                <div class="mb-2">
                    <label for="password2" class="mb-2">Ulangi Password</label>
                    <input type="password" name="password2" id="password2" class="form-control">
                </div>
                <div class="row justify-content-center  mt-3">
                    <button type="submit" name="register" id="register" class="btn btn-primary w-75">Register</button>
                </div>
            </form>
            <div class="row text-center mt-1">
                <p><small>Sudah Punya Akun? <a href="index.php" class="text-decoration-none">Login Now!</a></small></p>
            </div>
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
if(isset($_POST['register'])){
    $nama= strtolower(stripslashes(htmlspecialchars($_POST['nama'])));
    $email= strtolower(stripslashes(htmlspecialchars($_POST['email'])));
    $kontak= strtolower(stripslashes(htmlspecialchars($_POST['kontak'])));
    $alamat= strtolower(stripslashes(htmlspecialchars($_POST['alamat'])));
    $toko= strtolower(stripslashes(htmlspecialchars($_POST['toko'])));
    $deskripsi= strtolower(stripslashes(htmlspecialchars($_POST['deskripsi'])));
    $password=mysqli_real_escape_string($koneksi,htmlspecialchars($_POST['password']));
    $password2=mysqli_real_escape_string($koneksi,htmlspecialchars($_POST['password2']));

    // cek username sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT email FROM seller WHERE email = '$email'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('email sudah terdaftar!')
		      </script>";
		return false;
	}

    	// cek konfirmasi password
	if( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}

	// enkripsi password
	$password_acak = password_hash($password, PASSWORD_DEFAULT);
    // $level='user';
	// tambahkan userbaru ke database
	$simpan = mysqli_query($koneksi, "INSERT INTO seller (nama,email,kontak,alamat,nama_toko,deskripsi_toko,password) VALUES ('$nama','$email','$kontak' ,'$alamat','$toko' ,'$deskripsi' ,'$password_acak')");
    if($simpan){
        echo "<script>
        Swal.fire({title: 'Berhasil Register',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = 'marketplace/login.php';
            }
            })</script>";
    }

}

?>