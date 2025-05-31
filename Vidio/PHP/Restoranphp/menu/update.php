<h1>Update Menu</h1>
<?php 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tblmenu WHERE idmenu = $id";
        $item = $db->getITEM($sql);
        $idkategori = $item['idkategori'];

    }

    $row = $db->getALL("SELECT * FROM tblkategori ORDER BY kategori  ASC");

?>
<div class="">
    <form action="" method="post" enctype="multipart/form-data">
        <div class=" w-50">
            <label for="" class="mb-3">Kategori</label><br>
            <select name="idkategori" id="">
                <?php foreach($row as $r): ?>
                <option <?php if ($idkategori == $r['idkategori']) {echo "selected";}?> value="<?php echo $r['idkategori'] ?>"><?php echo $r['kategori'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class=" w-50">
            <label for="" class="mb-3">Nama Menu</label>
            <input type="text" name="menu" required value="<?php echo $item ['menu']?>" class="form-control">
        </div>
        <div class=" w-50">
            <label for="" class="mb-3">Harga</label>
            <input type="text" name="harga" number required value="<?php echo $item ['harga']?>" class="form-control">
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
        $gambar =  $item['gambar'];
        // $gambar = $_FILES['gambar']['name'];
        $temp = $_FILES['gambar']['tmp_name'];

        if (!empty($temp)) {
            $gambar = $_FILES['gambar']['name'];
            move_uploaded_file($temp,'../upload/'.$gambar);
        }

        $sql = "UPDATE tblmenu SET idkategori = $idkategori, menu = '$menu', gambar = '$gambar', harga = '$harga'  WHERE idmenu = $id";

        $db->runSQL($sql);
        header("location:?f=menu&m=select");


        // if (empty($gambar)) {
        //     echo "<h3>GAMBAR KOSONG</h3>";
        // }else{
        //     $sql = "INSERT INTO tblmenu VALUES  ('',$idkategori,'$menu','$gambar',$harga)";
        //     
        //     
        // }
        
    }

?>