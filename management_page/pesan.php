<?php
$pesan=mysqli_query($koneksi,"SELECT nama_toko,seller.gambar,chats.seller_id FROM seller 
RIGHT JOIN chats ON seller.id=chats.seller_id
LEFT JOIN user ON user.id=chats.user_id
WHERE user_id='$s_id' GROUP BY chats.seller_id");
?>
<div class="kotak-pesan">
    <center>
        <h3>Daftar Chating</h3>
    </center>
    <?php while($row=mysqli_fetch_assoc($pesan)){ ?>
    <div class="pesan">
        <div class="img">
            <img src="assets/img/icon_form/user.png" alt="">
            <p><?= $row['nama_toko'] ?></p>
        </div>
        <div class="button">
            <a href="?page=chat&seller_id=<?= $row['seller_id'] ?>" class="text-decoration-none">
                <div class="badge">
                    Chat 
                    <span id="notif-<?= $row['seller_id'] ?>" class="notif-icon" style="display: none;"></span>
                </div>
            </a>
        </div>
    </div>
    <?php } ?>
</div>

<style>
           .badge {
    background-color: #712cf9;
    color: white;
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 14px;
    position: relative;
    display: inline-block;
}

.notif-icon {
    background: red;
    color: white;
    border-radius: 50%;
    font-size: 12px;
    font-weight: bold;
    padding: 6px 6px;
    position: absolute;
    top: -5px;
    right: -3px;
    display: none;
}

</style>

<script>
        function checkNotifications(receiverId) {
            $.get("check_notifications.php", { receiver_id: receiverId }, function(data) {
                let notifications = JSON.parse(data);
                
                $(".notif-icon").hide(); // Sembunyikan semua notif dulu
                
                Object.keys(notifications).forEach(sellerId => {
                    let count = notifications[sellerId];
                    if (count > 0) {
                        $("#notif-" + sellerId).text('').show();
                    }
                });
            });
        }

        setInterval(function() {
            checkNotifications(<?php echo $s_id; ?>);
        }, 2000);
    </script>