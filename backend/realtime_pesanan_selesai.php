<?php
include '../koneksi.php';
// Harap pastikan variabel koneksi Anda bernama $koneksi

$ses_id = $_GET['ses_id'];
$no = 1;

// --- QUERY YANG SUDAH DIPERBAIKI ---
// Logika Query:
// Ambil pesanan jika:
// 1. Statusnya 'dikirim' ATAU 'diterima' (selalu tampil).
// 2. ATAU statusnya 'selesai' TAPI tanggal selesainya masih dalam 24 jam terakhir.
$query = "
    SELECT 
        p.id AS id_pesanan,
        p.quantity,
        p.ukuran,
        p.warna,
        p.rasa,
        p.metode,
        p.price,
        p.tgl_pesanan,
        p.status,
        pr.gambar1,
        pr.produk,
        u.email,
        u.kontak,
        u.alamat,
        t.created_at AS tgl_selesai 
    FROM pesanan p
    JOIN produk pr ON pr.id = p.produk_id
    JOIN user u ON u.id = p.user_id
    JOIN seller s ON s.id = pr.seller_id
    LEFT JOIN transaksi t ON t.pesanan_id = p.id
    WHERE 
        s.id = '$ses_id' 
        AND (
            (p.status = 'dikirim' OR p.status = 'diterima')
            OR
            (p.status = 'selesai' AND t.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY))
        )
    ORDER BY p.tgl_pesanan DESC
";

$pesanan = mysqli_query($koneksi, $query);

while ($data = mysqli_fetch_assoc($pesanan)) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><img src="../assets/img/produk/<?= $data['gambar1'] ?>" alt="icon" width="100px"></td>
        <td><?= htmlspecialchars($data['produk']) ?></td>
        <td><?= htmlspecialchars($data['email']) ?> <br> (<?= htmlspecialchars($data['kontak']) ?>)</td>
        <td><?= $data['tgl_pesanan'] ?></td>
        <td><?= $data['quantity'] ?></td>
        
        <?php 
        // Menampilkan Varian dengan lebih ringkas
        $varian = '';
        if ($data['ukuran'] != '-' && $data['warna'] != '-') {
            $varian = htmlspecialchars($data['warna']) . ' - (' . htmlspecialchars($data['ukuran']) . ')';
        } else if ($data['rasa'] != '-') {
            $varian = htmlspecialchars($data['rasa']);
        } else {
            $varian = '-';
        }
        ?>
        <td><?= $varian ?></td>
        
        <td>Rp.<?= number_format($data['price'], 0, ',', '.'); ?></td>
        <td><?= htmlspecialchars($data['metode']) ?></td>
        
        <td>
            <?php if($data['status'] == 'dikirim' || $data['status'] == 'diterima') { ?>
                <span class="badge bg-primary">Dikirim</span>
            <?php } elseif($data['status'] == 'selesai') { ?>
                <span class="badge bg-success">Selesai</span>
            <?php } ?>
        </td>
        <td>
            <button type="button" class="badge bg-warning border-0 text-white btn-detail" 
                data-bs-toggle="modal" 
                data-bs-target="#modalDetailPesanan"
                data-idpesanan="KDP<?= $data['id_pesanan'] ?>"
                data-produk="<?= htmlspecialchars($data['produk']) ?>"
                data-user="<?= htmlspecialchars($data['email']) ?>"
                data-kontak="<?= htmlspecialchars($data['kontak']) ?>"
                data-alamat="<?= htmlspecialchars($data['alamat']) ?>"
                data-tglpesan="<?= $data['tgl_pesanan'] ?>"
                data-tglselesai="<?= $data['tgl_selesai'] ?? 'Belum Selesai' ?>"
                data-total="Rp.<?= number_format($data['price'], 0, ',', '.'); ?>"
                data-quantity="<?= $data['quantity'] ?>"
                data-varian="<?= $varian ?>"
                data-metode="<?= htmlspecialchars($data['metode']) ?>">
                Detail
            </button>
        </td>
    </tr>
<?php } ?>