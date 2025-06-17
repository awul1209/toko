<?php
$id_produk=$_GET['produk'];
$tgl=date('Y-m-d');
$produk=mysqli_query($koneksi,"SELECT * from produk
        WHERE id='$id_produk'");
?>
<div class="kotak-tr">
<div class="card shadow-sm">
            <h2 class="text-center">Form Transaksi </h2>

            <form action="" method="post">
                <?php $row = mysqli_fetch_assoc($produk) ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="assets/img/produk/<?= $row['gambar1']; ?>" class="img-fluid rounded-start" alt="<?= $row['produk']; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"> <?= $row['produk']; ?> </h5>
                                    <p class="card-text text-danger fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                    <p class="card-text">Stock: <?= $row['stock']; ?></p>
                                    
                                    <?php if ($row['kategori'] == 'Fashion' ) { ?>
                                    <label class="form-label">Pilih Ukuran:</label>
                                    <select class="form-select ukuran" name="ukuran">
                                        <?php 
                                        $ukuran = isset($row['ukuran']) ? str_replace(['[', ']'], '', $row['ukuran']) : '';
                                        $ukuranArray = explode(',', $ukuran);
                                        foreach ($ukuranArray as $data) { ?>
                                            <option value="<?= trim($data) ?>"><?= trim($data) ?></option>
                                        <?php } ?>
                                    </select>

                                    <label class="form-label">Pilih Warna:</label>
                                        <select class="form-select warna" name="warna">
                                        <?php 
                                        $warna = isset($row['warna']) ? str_replace(['', ''], '', $row['warna']) : '';
                                        $warnaArray = explode(',', $warna);
                                        foreach ($warnaArray as $data) { ?>
                                            <option value="<?= trim($data) ?>"><?= trim($data) ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } elseif ($row['kategori'] == 'Makanan') { ?>
                                        <label class="form-label">Pilih Rasa:</label>
                                        <select class="form-select rasa" name="rasa">
                                        <?php 
                                        $rasa = isset($row['rasa']) ? str_replace(['', ''], '', $row['rasa']) : '';
                                        $rasaArray = explode(',', $rasa);
                                        foreach ($rasaArray as $data) { ?>
                                            <option value="<?= trim($data) ?>"><?= trim($data) ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } elseif ($row['kategori'] == 'Kerajinan') { ?>
                                    <label class="form-label">Pilih Warna:</label>
                                        <select class="form-select warna" name="warna">
                                        <?php 
                                        $warna = isset($row['warna']) ? str_replace(['', ''], '', $row['warna']) : '';
                                        $warnaArray = explode(',', $warna);
                                        foreach ($warnaArray as $data) { ?>
                                            <option value="<?= trim($data) ?>"><?= trim($data) ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } elseif ($row['kategori'] == 'Sembako') { ?>

                                    <?php } ?>
                                    
                                    <label class="form-label">Jumlah:</label>
                                    <input type="number" class="form-control jumlah" min="0" max="<?= $row['stock']; ?>" value="<?= $row['stock'] > 0 ? '0' : '0'; ?>" oninput="hitungTotal()" <?= $row['stock'] == 0 ? 'disabled' : ''; ?> name="jumlah">
                                </div>
                            </div>
                        </div>
                    </div>
                
                <label class="form-label">Metode Pembayaran:</label>
                                <select class="form-select metode" name="metode" id="metode">
                    <option selected>-- pilih --</option>
                    <?php 
                    $metode = isset($row['metode']) ? str_replace(['', ''], '', $row['metode']) : '';
                    $metodeArray = explode(',', $metode);
                    foreach ($metodeArray as $data) { ?>
                        <option value="<?= trim($data) ?>"><?= trim($data) ?></option>
                    <?php } ?>
                </select>

                <input type="text" class="form-control" name="briva" id="briva" readonly value="<?= $row['briva'] ?>">

                
                <h3 class="mt-3 text-center">Total Bayar: <span class="text-success fw-bold">Rp <span id="totalHarga">0</span></span></h3>
                <input type="hidden" id="totalBayarInput" name="total_harga">

                <button type="submit" class="btn btn-primary w-100 mt-3" id="beliButton" onclick="prosesTransaksi()" name="beli" disabled>Beli Sekarang</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById("metode").addEventListener("change", function() {
        let selectedValue = this.value;
        let brivaInput = document.getElementById("briva");

        if (selectedValue.toLowerCase() === "briva") {
            brivaInput.value = "<?= $row['briva'] ?>"; // Isi dengan nomor BRIVA
        } else {
            brivaInput.value = ""; // Kosongkan jika bukan BRIVA
        }
    });
</script>

    <script>
       function hitungTotal() {
    let total = 0;
    let jumlahInputs = document.querySelectorAll(".jumlah");
    let hargaElements = document.querySelectorAll(".card-text.text-danger");
    let beliButton = document.getElementById("beliButton");
    let validJumlah = false;

    jumlahInputs.forEach((input, index) => {
        let harga = Number(hargaElements[index].innerText.replace("Rp ", "").replace(/\./g, ""));
        let jumlah = parseInt(input.value);
        total += harga * jumlah;

        if (jumlah > 0) {
            validJumlah = true;
        }
    });


    // Tampilkan total harga di HTML
    document.getElementById("totalHarga").innerText = total.toLocaleString("id-ID");

    // Simpan total harga di input hidden agar bisa dikirim ke PHP
    document.getElementById("totalBayarInput").value = total;

    // Nonaktifkan tombol beli jika jumlah 0
    beliButton.disabled = !validJumlah;
}

    </script>
    
<?php
if(isset($_POST['beli'])){
    if(isset($_POST['ukuran'])){
        $ukuran=$_POST['ukuran'];
    }else{
        $ukuran='-';
    }
    if(isset($_POST['warna'])){
        $warna=$_POST['warna'];
    }else{
        $warna='-';
    }
    if(isset($_POST['rasa'])){
        $rasa=$_POST['rasa'];
    }else{
        $rasa='-';
    }

    if(isset($_POST['briva']) != ''){
        $briva= $_POST['briva'];
    }else{
        $briva='-';
    }
$jumlah=$_POST['jumlah'];
$metode=$_POST['metode'];
$harga= $_POST['total_harga'];
$status='pending';

if($metode == 'Briva'){
    $query=mysqli_query($koneksi,"INSERT INTO pesanan (user_id,produk_id,quantity,price,status,tgl_pesanan,ukuran,warna,rasa,metode,briva) VALUES ('$s_id','$id_produk','$jumlah','$harga','menunggu pembayaran','$tgl','$ukuran','$warna','$rasa','$metode','$briva')");
}elseif($metode == 'COD'){
    $query=mysqli_query($koneksi,"INSERT INTO pesanan (user_id,produk_id,quantity,price,status,tgl_pesanan,ukuran,warna,rasa,metode,briva) VALUES ('$s_id','$id_produk','$jumlah','$harga','$status','$tgl','$ukuran','$warna','$rasa','$metode','$briva')");
}

if($query){
    echo "<script>
    Swal.fire({title: 'Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
    }).then((result) => {if (result.value){
        window.location = '?page=dashboard';
        }
        })</script>";
}
}
?>