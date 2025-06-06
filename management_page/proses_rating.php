<script src="assets/js/alert.js"></script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menangkap nilai rating dari setiap pertanyaan
    $komen = $_POST['comment'];
    $rating_1 = isset($_POST['rating_1']) ? intval($_POST['rating_1']) : 0;
    // $rating_2 = isset($_POST['rating_2']) ? intval($_POST['rating_2']) : 0;
    // $rating_3 = isset($_POST['rating_3']) ? intval($_POST['rating_3']) : 0;
    // $rating_4 = isset($_POST['rating_4']) ? intval($_POST['rating_4']) : 0;

    // Menghitung rata-rata rating hanya jika semua rating valid
    if ($rating_1 > 0 ) {
        $average_rating = ($rating_1);
    } else {
        $average_rating = "Invalid input. Please provide valid ratings for all questions.";
    }

    $query = mysqli_query($koneksi,"SELECT * FROM rating WHERE user_id = '$s_id'");
    if(mysqli_num_rows($query) >= 1){
        $sql= "UPDATE rating set
        rating= '$rating_1',
        komentar= '$komen'
        WHERE user_id='$s_id'
        ";
    }else{
    // Menyimpan data ke database
    $sql = "INSERT INTO rating (user_id,rating,komentar) 
            VALUES ('$s_id','$rating_1','$komen')";
    }

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>
        Swal.fire({title: 'Terimakasih atas $average_rating ulasannya',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
        window.location = '?page=rating';
            }
            })</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}
?>


<div class="kotak-proses-rating col-11">
    <h3 class="mb-4">Berikan Ulasan Anda</h3>
<p>Seberapa membantu web ini bagi anda?</p>
<form method="POST">
    <div class="stars" id="stars_1">
        <div class="star" data-value="1" onclick="setRating(this, 1, 'rating_1')"></div>
        <div class="star" data-value="2" onclick="setRating(this, 2, 'rating_1')"></div>
        <div class="star" data-value="3" onclick="setRating(this, 3, 'rating_1')"></div>
        <div class="star" data-value="4" onclick="setRating(this, 4, 'rating_1')"></div>
        <div class="star" data-value="5" onclick="setRating(this, 5, 'rating_1')"></div>
    </div>
    <input type="hidden" name="rating_1" id="rating_1">
    <textarea class="text-area" name="comment" placeholder="Tulis komentar Anda..." required></textarea>
    <br>
    <button class="btn text-white" type="submit" style="background-color:#0092dc;" >Kirim Rating</button>
</form>
</div>
<script>
    function setRating(star, value, inputId) {
        // Menentukan nilai rating untuk bintang yang dipilih
        var stars = star.parentElement.children;

        // Update bintang menjadi penuh atau kosong
        for (var i = 0; i < stars.length; i++) {
            if (i < value) {
                stars[i].classList.add('selected'); // Menambahkan kelas 'selected' untuk bintang penuh
            } else {
                stars[i].classList.remove('selected'); // Menghapus kelas 'selected' untuk bintang kosong
            }
        }

        // Update nilai input tersembunyi
        document.getElementById(inputId).value = value;
    }
</script>