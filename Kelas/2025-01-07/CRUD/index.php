<?php
require_once 'classes/Barang.php';

$barang = new Barang();

// Proses Tambah Barang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
    $nama = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $barang->uploadGambar($_FILES['gambar']);
    }
    
    $barang->tambahBarang($nama, $deskripsi, $harga, $stok, $gambar);
}

// Proses Hapus Barang
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $barang->hapusBarang($_GET['id']);
}

$daftarBarang = $barang->ambilSemuaBarang();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center animate__animated animate__fadeIn">
            Manajemen Barang
        </h1>

        <!-- Form Tambah Barang -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 animate__animated animate__slideInDown">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="tambah">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nama_barang" placeholder="Nama Barang" required 
                           class="border rounded w-full py-2 px-3">
                    <input type="number" name="harga" placeholder="Harga" required 
                           class="border rounded w-full py-2 px-3">
                    <textarea name="deskripsi" placeholder="Deskripsi" 
                              class="border rounded w-full py-2 px-3 col-span-2"></textarea>
                    <input type="number" name="stok" placeholder="Stok" required 
                           class="border rounded w-full py-2 px-3">
                    <input type="file" name="gambar" 
                           class="border rounded w-full py-2 px-3">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                    Tambah Barang
                </button>
            </form>
        </div>

        <!-- Daftar Barang -->
        <div class="grid grid-cols-3 gap-4">
            <?php foreach($daftarBarang as $item): ?>
            <div class="bg-white shadow-md rounded p-4 animate__animated animate__fadeIn">
                <?php if($item['gambar']): ?>
                    <img src="uploads/<?= $item['gambar'] ?>" class="w-full h-48 object-cover mb-4">
                <?php endif; ?>
                <h2 class="text-xl font-bold"><?= $item['nama_barang'] ?></h2>
                <p>Harga: Rp. <?= number_format($item['harga']) ?></p>
                <p>Stok: <?= $item['stok'] ?></p>
                <p><?= $item['deskripsi '] ?></p>
                <a href="?aksi=hapus&id=<?= $item['id'] ?>" class="text-red-500 hover:underline">Hapus</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>