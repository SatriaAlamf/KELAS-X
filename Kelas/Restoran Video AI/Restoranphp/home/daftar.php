<h3>Registrasi pelanggan</h3>
<div class="mb-3">
    <form action="" method="post">
        <div class="mt-2 mb-3 w-50">
            <label for="">pelanggan</label>
            <input type="text" name="pelanggan" required placeholder="isi pelanggan" class="form-control">
        </div>
        <div class="mt-2 mb-3 w-50">
            <label for="">Alamat</label>
            <input type="text" name="alamat" required placeholder="isi Alamat" class="form-control">
        </div>
        <div class="mt-2 mb-3 w-50">
            <label for="">Telp</label>
            <input type="text" name="telp" required placeholder="isi Telp" class="form-control">
        </div>
        <div class="mt-2 mb-3 w-50">
            <label for="">Email</label>
            <input type="email" name="email" required placeholder="Email" class="form-control">
        </div>
        <div class="mt-2 mb-3 w-50">
            <label for="">Password</label>
            <input type="password" name="password" required placeholder="Password" class="form-control">
        </div>
        <div class="mt-2 mb-3 w-50">


            <label for="">Konfirmasi Password</label>
            <input type="password" name="konfirmasi" required placeholder="Password" class="form-control">
        </div>
        <div>
            <input type="submit" name="simpan" value="simpan" class="mt-3 btn btn-primary">
        </div>
    </form>
</div>

<?php 

    if (isset($_POST['simpan'])) {
        $pelanggan =  $_POST['pelanggan'];
        $alamat =  $_POST['alamat'];
        $telp =  $_POST['telp'];
        $email =  $_POST['email'];
        $password = $_POST['password'];
        $konfirmasi = $_POST['konfirmasi'];
        // $level = $_POST['level']; // Remove or comment out this line
        if ($konfirmasi === $password) {
            $sql = "INSERT INTO tblpelanggan (pelanggan, alamat, telp, email, password, aktif) VALUES ('$pelanggan','$alamat','$telp','$email','$password',1)";
            $db->runSQL($sql);
            header("location:?f=home&m=info");
        }else {
            echo "<h3>PASSWORD  TIDAK SESUAI</h3>";
        }
    }

?>