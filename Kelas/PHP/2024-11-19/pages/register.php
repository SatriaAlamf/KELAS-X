
    <div class="register">
        <h1>Register</h1>
        <form action="" method="post">
           <input type="email" name="email" required placeholder="masukkan alamat email">
           <input type="password" name="password" required placeholder="masukkan password">
           <input type="submit" name="register" value="Register" >
        </form>
    </div>
    <?php 
    if(isset($_POST['register'])){
        $email = $_POST['email'];
        // echo $email;
        $password = $_POST['password'];
        // echo $password;
        $sql ="INSERT INTO customer (email,password)VALUES('$email','$password')";
        mysqli_query($koneksi, $sql);

        header("location:index.php ?menu=login");

        echo $sql;
       
       
    }



    ?>
