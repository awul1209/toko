<div class="card card-info mt-3" id="card-add-user">
    <div class="card-header" style="background-color: #3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-edit"></i> Form Tambah Data
        </h5>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">

           
<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="nama" class="col-form-label">Masukkan Nama:</label>
    <input type="text" name="nama" class="form-control" id="nama">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="email" class="col-form-label">Masukkan Email:</label>
    <input type="email" name="email" class="form-control" id="email">
  </div>
</div>

<div class="mb-2 kotak-input-user">
            <label for="kontak" class="col-form-label">Masukkan Kontak:</label>
            <input type="number" name="kontak" class="form-control" id="kontak">
          </div>
          
          
          <label for="nama" class="col-form-label">Masukkan Role:</label><br>
          <div class="mb-2 kotak-input-user">
            <select class="form-select" name="role" aria-label="Default select example" id="select">
              <option selected>Pilih</option>
              <option value="admin">admin</option>
              <option value="user">user</option>
            </select>
          </div>

          
          
          <div class="mb-2 kotak-input-user">
            <label for="email" class="col-form-label">Masukkan Password:</label>
            <div class="input-group  kotak-input-user">
              <input type="password" name="password" id="passwordTambah" class="form-control" aria-describedby="button-addon2">
              <button onclick="togglePasswordTambah()" class="btn btn-outline-secondary" type="button" id="button-addon2"><img id="image-previewTambah" src="assets/img/icon_action/eye-tutup-biru.png" alt="eye" width="25"></button>
            </div>
          </div>
          
          <div class="mb-2 kotak-input-user">
                      <label for="alamat" class="col-form-label">Masukkan Alamat:</label>
                      <textarea class="form-control" id="alamat" name="alamat" ></textarea>
                    </div>



        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
            <a href="?page=data-user" title="Kembali" class="btn btn-warning text-white">Batal</a>
        </div>
    </form>
</div>
<script>
      function togglePasswordTambah() {
    var previewImage = document.getElementById('image-previewTambah');
    let imageUrlBuka = 'assets/img/icon_action/eye-biru.png';
    let imageUrlTutup = 'assets/img/icon_action/eye-tutup-biru.png';
    const passwordInput = document.getElementById('passwordTambah');
    const passwordType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = passwordType;
    if (passwordInput.type === 'password') {
      previewImage.src = imageUrlTutup;
    } else {
      previewImage.src = imageUrlBuka;
    }
  }
   
</script>



<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];
    $password_acak = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO user (nama,email,password,role,kontak,alamat) VALUES ('$nama','$email','$password_acak','$role','$kontak','$alamat')";
    $simpan = mysqli_query($koneksi, $query);
    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-user';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-user';
            }
        })</script>";
    }
}

function upload()
{
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    // cek gambar tidak diupload
    if ($error === 4) {
        echo "
        <script>
        alert('pilih gambar');
        </script>
        
        ";
        return false;
    }
    // cek yang di uplod gambar atau tidak
    $ektensigambarvalid = ['jpg', 'jpeg', 'png', 'webp'];

    $ektensigambar = explode('.', $namafile);
    $ektensigambar = strtolower(end($ektensigambar));
    // cek adakah string didalam array
    if (!in_array($ektensigambar, $ektensigambarvalid)) {
        echo "
        <script>
        alert('yang anda upload bukan gambar');
        </script>
        ";

        return false;
    }
    // cek jika ukuran terlalu besar
    if ($ukuranfile > 90000000) {
        echo "
        <script>
        alert('ukuran gambar terlalu besar');
        </script>
        
        ";
        return false;
    }

    // lolos pengecekan , gambar siap di upload
    // generete nama gambar baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ektensigambar;

    move_uploaded_file($tmpname, '../assets/img/blog/' . $namafilebaru);

    return $namafilebaru;
}

die();
?>