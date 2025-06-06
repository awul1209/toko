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
<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="password" class="col-form-label">Masukkan Pssword:</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="kontak" class="col-form-label">Masukkan Kontak:</label>
    <input type="text" name="kontak" class="form-control" id="kontak">
  </div>
</div>

<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="nama_toko" class="col-form-label">Masukkan Toko:</label>
    <input type="text" name="nama_toko" class="form-control" id="nama_toko">
  </div>
  <div class="mb-2 kotak-input-user">
              <label for="gambar1-tambah" class="col-form-label">Logo Toko :</label>
            <input class="form-control" name="gambar" id="gambar1-tambah" type="file" id="formFileMultiple" multiple onchange="previewImageTambah1()">
            <img class="foto-preview-tambah1" src="" alt="" width="80">
            </div>
</div>

<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="deskripsi" class="col-form-label">Masukkan Deskripsi Toko:</label>
    <textarea class="form-control" name="deskripsi" id=""></textarea>
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="kontak" class="col-form-label">Masukkan Alamat:</label>
    <textarea class="form-control" name="alamat" id=""></textarea>
  </div>
</div>


           



        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
            <a href="?page=data-seller" title="Kembali" class="btn btn-warning text-white">Batal</a>
        </div>
    </form>
</div>
<script>
     function previewImageTambah1() {
    const image = document.querySelector('#gambar1-tambah');
    const imgPreview = document.querySelector('.foto-preview-tambah1');
    imgPreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent) {
      imgPreview.src = oFREvent.target.result;
    }
  }
   
</script>



<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $kontak = $_POST['kontak'];
    $nama_toko = $_POST['nama_toko'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $password_acak = password_hash($password, PASSWORD_DEFAULT);
        // Menangani gambar
    $gambar = ($_FILES['gambar']['error'] === 4) ? NULL : upload1();
    $query = "INSERT INTO seller (nama,email,password,nama_toko,kontak,alamat,gambar,deskripsi_toko) VALUES ('$nama','$email','$password_acak','$nama_toko','$kontak','$alamat','$gambar','$deskripsi')";
    $simpan = mysqli_query($koneksi, $query);
    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-seller';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-seller';
            }
        })</script>";
    }
}

function upload1()
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
    $ektensigambarvalid = ['jpg', 'jpeg', 'png', 'webp','jfif'];

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

    move_uploaded_file($tmpname, 'assets/img/seller/' . $namafilebaru);

    return $namafilebaru;
}

die();
?>