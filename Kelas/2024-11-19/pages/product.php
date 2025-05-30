
<?php

$sql = "SELECT * FROM product ORDER BY produk ASC";
// echo $sql;

$hasil = mysqli_query($koneksi, $sql);
$baris = mysqli_num_rows($hasil);
echo $baris;

if ($baris == 0) {
    echo "<h1>Produk Belum diisi</h1>";
}
?>



<div class="produk">
    <h1>Produk</h1>
    <?php 
    if ($baris > 0) {
        while ($row = mysqli_fetch_assoc($hasil)) {
            #?>
            <div class="detail-produk">
            <h2><?= $row['produk']?></h2>
            <img src="images/<?= $row['gambar']?>" alt="" style="width: 200px;">
            <p><?= $row ['deskripsi']?></p>
            <p><?= $row ['stok']?></p>
            <p><strong><?= $row ['harga'] ?></strong></p>
            <a href="?menu=cart&add=<?= $row['id']?>"><button>BELI</button></a>
            </div>
            <?php
            }
        }
     ?>
</div>
