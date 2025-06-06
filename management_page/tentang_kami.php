<div class="kotak-tentang-kami">
    <div class="isi">
<?php
        $no = 1;
        $result = mysqli_query($koneksi, 'SELECT * from tentang_kami');
        while ($data = mysqli_fetch_assoc($result)) { ?>
<P><?= $data['deskripsi'] ?></P>
<?php  } ?>   
</div>  
</div>