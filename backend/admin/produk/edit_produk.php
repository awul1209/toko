<?php
$id=$_GET['kode'];
$result_produk=mysqli_query($koneksi,"SELECT * FROM produk WHERE id='$id'");
$row=mysqli_fetch_assoc($result_produk);
?>
<div class="card card-info mt-3" id="card-add-user">
    <div class="card-header" style="background-color: #3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-edit"></i> Form Ubah Data
        </h5>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="card-body">

           
<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="produk" class="col-form-label">Masukkan produk:</label>
    <input type="text" name="produk" class="form-control" id="produk" required value="<?= $row['produk'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="kategori" class="col-form-label">Masukkan kategori:</label>
        <select class="form-select" aria-label="Default select example" name="kategori" required>
    <option selected value="<?= $row['kategori'] ?>"><?= $row['kategori'] ?></option>
    <option value="Fashion">Fashion</option>
    <option value="Kerajinan">Kerajinan</option>
    <option value="Makanan">Makanan</option>
    <option value="Sembako">Sembako</option>
    </select>
  </div>
</div>
<div class="kotak-form-user col-12">
<div class="mb-2 kotak-input-user">
    <label for="rasa" class="col-form-label">Masukkan rasa:</label>
    <input type="text" name="rasa" class="form-control" id="rasa" required  value="<?= $row['rasa'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="ukuran" class="col-form-label">Masukkan ukuran:</label>
    <input type="text" name="ukuran" class="form-control" id="ukuran" required  value="<?= $row['ukuran'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="warna" class="col-form-label">Masukkan warna:</label>
    <input type="text" name="warna" class="form-control" id="warna" required  value="<?= $row['warna'] ?>">
  </div>
</div>
<div class="kotak-form-user col-12">
<div class="mb-2 kotak-input-user">
    <label for="harga" class="col-form-label">Masukkan harga:</label>
    <input type="text" name="harga" class="form-control" id="harga" required  value="<?= $row['harga'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="stock" class="col-form-label">Masukkan stock:</label>
    <input type="text" name="stock" class="form-control" id="stock" required value="<?= $row['stock'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="diskon" class="col-form-label">Masukkan diskon:</label>
    <input type="text" name="diskon" class="form-control" id="diskon" required  value="<?= $row['diskon'] ?>">
  </div>
</div>



<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
    <label for="deskripsi" class="col-form-label">Masukkan Deskripsi:</label>
    <textarea class="form-control" name="deskripsi" id=""><?= $row['deskripsi'] ?></textarea>
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="metode" class="col-form-label">Masukkan pembayaran:</label>
    <input type="text" name="metode" class="form-control" id="metode" required  value="<?= $row['metode'] ?>">
  </div>
  <div class="mb-2 kotak-input-user">
    <label for="briva" class="col-form-label">Masukkan briva:</label>
    <input type="text" name="briva" class="form-control" id="briva" required  value="<?= $row['briva'] ?>">
  </div>
</div>

<div class="kotak-form-user col-12">
  <div class="mb-2 kotak-input-user">
              <label for="gambar1-tambah" class="col-form-label">Logo Toko :</label>
            <input class="form-control" name="gambar1" id="gambar1-tambah" type="file" id="formFileMultiple" multiple onchange="previewImageTambah1()">
            <?php if ($row['gambar1']) : ?>
      <img class="foto-preview-tambah1" src="../assets/img/produk/<?= $row['gambar1'] ?>" alt="Gambar 1" width="80">
    <?php else : ?>
      <p>No image</p>
    <?php endif; ?>
    </div>
  <div class="mb-2 kotak-input-user">
              <label for="gambar2-tambah" class="col-form-label">Logo Toko :</label>
            <input class="form-control" name="gambar2" id="gambar2-tambah" type="file" id="formFileMultiple" multiple onchange="previewImageTambah2()">
            <?php if ($row['gambar2']) : ?>
      <img class="foto-preview-tambah1" src="../assets/img/produk/<?= $row['gambar2'] ?>" alt="Gambar 1" width="80">
    <?php else : ?>
      <p>No image</p>
    <?php endif; ?>
    </div>
  <div class="mb-2 kotak-input-user">
              <label for="gambar3-tambah" class="col-form-label">Logo Toko :</label>
            <input class="form-control" name="gambar3" id="gambar3-tambah" type="file" id="formFileMultiple" multiple onchange="previewImageTambah3()">
            <?php if ($row['gambar3']) : ?>
      <img class="foto-preview-tambah1" src="../assets/img/produk/<?= $row['gambar3'] ?>" alt="Gambar 1" width="80">
    <?php else : ?>
      <p>No image</p>
    <?php endif; ?>
    </div>
</div>

           



        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit" name="simpan">Ubah</button>
            <a href="?page=data-produk" title="Kembali" class="btn btn-warning text-white">Batal</a>
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
     function previewImageTambah2() {
    const image = document.querySelector('#gambar2-tambah');
    const imgPreview = document.querySelector('.foto-preview-tambah2');
    imgPreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent) {
      imgPreview.src = oFREvent.target.result;
    }
  }
     function previewImageTambah3() {
    const image = document.querySelector('#gambar3-tambah');
    const imgPreview = document.querySelector('.foto-preview-tambah3');
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
    $id=$_POST['id'];
    $produk = $_POST['produk'];
    $kategori = $_POST['kategori'];
    $rasa = $_POST['rasa'];
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $diskon = $_POST['diskon'];
    $metode = $_POST['metode'];
    $briva = $_POST['briva'];
    $deskripsi = $_POST['deskripsi'];
        // Menangani gambar
        $gambar1 = ($_FILES['gambar1']['error'] === 4) ? $row['gambar1'] : upload1();
        $gambar2 = ($_FILES['gambar2']['error'] === 4) ? $row['gambar2'] : upload2();
        $gambar3 = ($_FILES['gambar3']['error'] === 4) ? $row['gambar3'] : upload3();
    $query = "UPDATE produk SET 
    produk = '$produk',
    kategori = '$kategori',
    rasa = '$rasa',
    ukuran = '$ukuran',
    warna = '$warna',
    harga = '$harga',
    stock = '$stock',
    diskon = '$diskon',
    metode = '$metode',
    briva = '$briva',
    deskripsi = '$deskripsi',
    gambar1 = '$gambar1',
    gambar2 = '$gambar2',
    gambar3 ='$gambar3'
    WHERE id='$id'";
     $simpan = mysqli_query($koneksi, $query);
    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-produk';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-produk';
            }
        })</script>";
    }
}

function upload1()
{
    $namafile = $_FILES['gambar1']['name'];
    $ukuranfile = $_FILES['gambar1']['size'];
    $error = $_FILES['gambar1']['error'];
    $tmpname = $_FILES['gambar1']['tmp_name'];

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

    move_uploaded_file($tmpname, '../assets/img/produk/' . $namafilebaru);

    return $namafilebaru;
}
function upload2()
{
    $namafile = $_FILES['gambar2']['name'];
    $ukuranfile = $_FILES['gambar2']['size'];
    $error = $_FILES['gambar2']['error'];
    $tmpname = $_FILES['gambar2']['tmp_name'];

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

    move_uploaded_file($tmpname, '../assets/img/produk/' . $namafilebaru);

    return $namafilebaru;
}
function upload3()
{
    $namafile = $_FILES['gambar3']['name'];
    $ukuranfile = $_FILES['gambar3']['size'];
    $error = $_FILES['gambar3']['error'];
    $tmpname = $_FILES['gambar3']['tmp_name'];

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

    move_uploaded_file($tmpname, '../assets/img/produk/' . $namafilebaru);

    return $namafilebaru;
}

die();
?>