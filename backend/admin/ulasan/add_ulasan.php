<div class="card card-info mt-3" id="card-add-user">
    <div class="card-header" style="background-color: #3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-edit"></i> Form Tambah Data
        </h5>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">

        <div class="mb-2">
              <label for="email" class="col-form-label">User</label>
              <select class="form-select" name="user_id" aria-label="Default select example" id="select">
           <?php   $result = mysqli_query($koneksi, 'SELECT id,nama from user');
              while ($data = mysqli_fetch_assoc($result)) { ?>
                <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                <?php } ?>
              </select>
            </div>

<div class="kotak-form-ulasan col-12">
<div class="mb-2 kotak-input-ulasan">
              <label for="rating1" class="col-form-label">Seberapa membantu web ini bagi anda?</label>
              <input type="number" min="1" max="5" name="rating1" class="form-control" id="rating1">
            </div>
            <div class="mb-2 kotak-input-ulasan">
              <label for="rating2" class="col-form-label">Seberapa lengkap destinasi wisata yang kami tawarkan?</label>
              <input type="number" min="1" max="5" name="rating2" class="form-control" id="rating2">
            </div>
</div>
<div class="kotak-form-ulasan col-12">
<div class="mb-2 kotak-input-ulasan">
              <label for="rating3" class="col-form-label">Seberapa mudah pengunaan website ini?</label>
              <input type="number" min="1" max="5" name="rating3" class="form-control" id="rating3">
            </div>
            <div class="mb-2 kotak-input-ulasan">
              <label for="rating4" class="col-form-label">Seberapa menarik tampilan website ini menurut Anda?</label>
              <input type="number" min="1" max="5" name="rating4" class="form-control" id="rating4">
            </div>
</div>
       


           



        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
            <a href="?page=data-ulasan" title="Kembali" class="btn btn-warning">Batal</a>
        </div>
    </form>
</div>




<?php
if (isset($_POST['simpan'])) {
    $user_id=$_POST['user_id'];
    $rating1 = $_POST['rating1'];
    $rating2 = $_POST['rating2'];
    $rating3 = $_POST['rating3'];
    $rating4 = $_POST['rating4'];

    $query = mysqli_query($koneksi,"SELECT * FROM rating WHERE user_id = '$user_id'");
    if(mysqli_num_rows($query) >= 1){
        $query= "UPDATE rating set
        rating1= '$rating1',
        rating2= '$rating2',
        rating3= '$rating3',
        rating4= '$rating4'
        WHERE user_id='$user_id'
        ";
    }else{
    // Menyimpan data ke database
    $query = "INSERT INTO rating (user_id,rating1, rating2, rating3, rating4) 
            VALUES ('$user_id','$rating1', '$rating2', '$rating3', '$rating4')";
    }

    $simpan = mysqli_query($koneksi, $query);
    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-ulasan';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=data-ulasan';
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