<?php

// Query untuk mengambil semua data rating
$query = "SELECT * FROM rating";
$stmt = mysqli_query($koneksi, $query);

// Mengambil semua data rating
$data = mysqli_fetch_all($stmt, MYSQLI_ASSOC);

// Fungsi untuk menentukan ulasan berdasarkan rating
function buatUlasan($rating) {
    switch ($rating) {
        case 1:
            return "Kurang";
        case 2:
            return "Cukup";
        case 3:
            return "Baik";
        case 4:
            return "Sangat Baik";
        case 5:
            return "Sempurna";
        case 6:
            return "Sempurna";
        default:
            return "Tidak Valid";
    }
}

// Menyimpan rating per kategori
$semua_rating = [];
$all_ratings_combined = []; // Array untuk menyimpan semua rating dari kategori 1 hingga 4

// Mengambil rating per kategori dari setiap data
foreach ($data as $row) {
    for ($i = 1; $i <= 1; $i++) {
        // Menambahkan rating dari setiap kategori ke array $semua_rating
        $semua_rating[$i][] = $row['rating'];
        
        // Menambahkan semua rating ke dalam satu array untuk perhitungan rata-rata total
        $all_ratings_combined[] = $row['rating'];
    }
}

// Membuat ulasan per kategori berdasarkan rata-rata rating
$ulasan_per_kategori = [];
for ($i = 1; $i <= 1; $i++) {
    $total_rating = array_sum($semua_rating[$i]); // Menghitung total rating per kategori
    $rata_rata_rating = $total_rating / count($semua_rating[$i]); // Menghitung rata-rata rating per kategori
    $ulasan_per_kategori[$i] = buatUlasan(round($rata_rata_rating)); // Menyimpan ulasan berdasarkan rata-rata kategori
}

// Menghitung rata-rata total dari semua rating
$total_rating_combined = array_sum($all_ratings_combined); // Total rating dari semua kategori
$rata_rata_combined = $total_rating_combined / count($all_ratings_combined); // Rata-rata rating keseluruhan
$ulasan_total = buatUlasan(round($rata_rata_combined)); // Ulasan total berdasarkan rata-rata keseluruhan

?>

<script src="assets/js/alert.js"></script>
<div class="kotak-rating">
    <div class="card-rating">


<?php if (!isset($s_nama)) { ?>
    <h3>Hai</h3>

    <?php if($ulasan_total == 'Kurang') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Cukup') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Baik') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Sangat Baik') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Sempurna') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } ?>

    <!-- <?php if($ulasan_per_kategori[1] == 'Kurang') { ?>
      <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
    <div class="stars">
      <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_per_kategori[1] == 'Cukup') { ?>
      <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
      <div class="stars">
      <div class="star-rating"></div>
      <div class="star-rating"></div>
    </div>
      <?php } else if($ulasan_per_kategori[1] == 'Baik') { ?>
        <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
        <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
      </div>
        <?php } else if($ulasan_per_kategori[1] == 'Sangat Baik') { ?>
          <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
          <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        </div>
      
        <?php } else if($ulasan_per_kategori[1] == 'Sempurna') { ?>
          <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
          <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        </div>
      <?php } ?> -->

    

    


      <!-- user -->
<?php } else { ?>
    <h3>Hai <?= $s_nama ?></h3><br>
    <?php if($ulasan_total == 'Kurang') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini : </strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Cukup') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Baik') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini : </strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Sangat Baik') { ?>
      <!-- Ulasan Total -->
      <p><strong>Rating Website ini :</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_total == 'Sempurna') { ?>
      <!-- Ulasan Total -->
      <p><strong>Ulasan Total (dari semua pertanyaan):</strong> <?= $ulasan_total ?></p>
      <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
    </div>
    <?php } ?>
    
    <!-- <?php if($ulasan_per_kategori[1] == 'Kurang') { ?>
      <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
    <div class="stars">
      <div class="star-rating"></div>
    </div>
    <?php } else if($ulasan_per_kategori[1] == 'Cukup') { ?>
      <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
      <div class="stars">
      <div class="star-rating"></div>
      <div class="star-rating"></div>
    </div>
      <?php } else if($ulasan_per_kategori[1] == 'Baik') { ?>
        <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
        <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
      </div>
        <?php } else if($ulasan_per_kategori[1] == 'Sangat Baik') { ?>
          <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
          <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        </div>
      
        <?php } else if($ulasan_per_kategori[1] == 'Sempurna') { ?>
          <p>Seberapa membantu web ini bagi anda?  <?= $ulasan_per_kategori[1] ?></p>
          <div class="stars">
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        <div class="star-rating"></div>
        </div>
      <?php } ?> -->

    

    

<?php }  ?>

    <form action="" method="post">
        <button type="submit" name="nilai" class="btn text-white mt-2 mb-3" style="background-color:#0092dc;" >Nilai</button>
    </form>
    </div>
    
    <div class="komentar">
        <h4>Komentar</h4>
        <ul class="list-disc pl-5">
    <?php  
    $query_komen = mysqli_query($koneksi, "SELECT komentar FROM rating");  

    if (mysqli_num_rows($query_komen) > 0) {  
        while ($row = mysqli_fetch_assoc($query_komen)) { ?>  
            <li class="text-black text-start border-b" style="margin-bottom:-15px;">
                <p><?= htmlspecialchars($row['komentar']) ?></p>
            </li>  
    <?php } 
    } else { ?>  
        <li class="text-gray-500 italic">Belum ada komentar.</li>  
    <?php } ?>  
</ul>

    </div>
</div>

<?php
// Proses setelah tombol 'Nilai' diklik
if (isset($_POST['nilai'])) {
    if (!empty($s_nama)) {
        echo "<script>
            window.location = '?page=proses-nilai';
            </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Anda Belum Terdaftar',
                text: '',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {}
            });
        </script>";
    }
}
?>
