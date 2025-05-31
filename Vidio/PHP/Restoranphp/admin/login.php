<?php 

    session_start();
    require_once "../dbcontroller.php";
    $db = new DB;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Login Restoran</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="mx-auto mt-4 col-4">
                <h2>Login Restoran</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" value="LOGIN" name="Login">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php 

    if (isset($_POST['Login'])) {
        $email = $_POST['email'];
        $password = hash('sha256',$_POST['password']);
        $sql = "SELECT * FROM tbluser WHERE email='$email' AND password='$password'";
        $count = $db->rowCOUNT($sql);
        if ($count == 0) {
            echo "<center><h3>Email atau Password Salah!!</h3></center>";
        }else{
            $sql = "SELECT * FROM tbluser WHERE email='$email' AND password='$password'";
            $row = $db->getITEM($sql);
            $_SESSION['user'] = $row['email'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['iduser'] = $row['iduser'];
            header("Location:index.php");
        }
    }
?>