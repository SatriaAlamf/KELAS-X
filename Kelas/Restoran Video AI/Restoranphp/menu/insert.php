<?php 

    $row = $db->getALL("SELECT * FROM tblkategori ORDER BY kategori  ASC");

?>


<h3>Insert Menu</h3>
<div class="">
    <form action="" method="post" enctype="multipart/form-data">
        <div class=" w-50">
            <label for="" class="mb-3">Kategori</label><br>
            <select name="idkategori" id="">
                <?php foreach($row as $r): ?>
                <option value="<?php echo $r['idkategori'] ?>"><?php echo $r['kategori'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class=" w-50">
            <label for="" class="mb-3">Nama Menu</label>
            <input type="text" name="menu" required placeholder="isi menu" class="form-control">
        </div>
        <div class=" w-50">
            <label for="" class="mb-3">Harga</label>
            <input type="text" name="harga" number required placeholder="isi harga" class="form-control">
        </div>
        <div class=" w-50">
            <label for="" class="mb-3">Gambar</label><br>
            <input type="file" name="gambar">
        </div>
        <div>
            <input type="submit" name="simpan" value="simpan" class="mt-3 btn btn-primary">
        </div>
    </form>
</div>

<?php 

    if (isset($_POST['simpan'])) {
        $idkategori = $_POST['idkategori'];
        $menu =  $_POST['menu'];
        $harga = $_POST['harga'];
        $gambar = $_FILES['gambar']['name'];
        $temp = $_FILES['gambar']['tmp_name'];

        if (empty($gambar)) {
            echo "<h3>GAMBAR KOSONG</h3>";
        }else{
            $sql = "INSERT INTO tblmenu VALUES  ('',$idkategori,'$menu','$gambar',$harga)";
            move_uploaded_file($temp,'../upload/'.$gambar);
            $db->runSQL($sql);
            header("location:?f=menu&m=select");
        }
        
    }

?>

