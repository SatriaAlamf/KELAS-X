<h3>Insert Kategori</h3>
<div class="">
    <form action="" method="post">
        <div class=" w-50">
            <label for="" class="mb-3">Nama Kategori</label>
            <input type="text" name="kategori" required placeholder="isi kategori" class="form-control">
        </div>
        <div>
            <input type="submit" name="simpan" value="simpan" class="mt-3 btn btn-primary">
        </div>
    </form>
</div>

<?php 

    if (isset($_POST['simpan'])) {
        $kategori =  $_POST['kategori'];
        $sql = "INSERT INTO tblkategori VALUES  ('','$kategori')";

        $db->runSQL($sql);

        header("location:?f=kategori&m=select");
    }

?>