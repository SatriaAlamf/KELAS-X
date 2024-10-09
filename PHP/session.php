<ul>
    <li><a href="?menu=isi">Isi</a></li>
    <li><a href="?menu=hapus">Hapus</a></li>
    <li><a href="?menu=destroy">Destroy</a></li>
</ul>


<?php 

    session_start();


    if (isset($_GET['menu'])) {
        $menu = $_GET['menu'];
        echo $menu;

        switch ($menu) {
            case 'isi':
                isisession();
                break;
            case 'hapus':
                unset($_SESSION['user']);
                break;
            case 'destroy':
                session_destroy();
                break;
            
            default:
                # code...
                break;
        }
    }
    echo '<br>';
    var_dump($_SESSION);

    function isisession(){
    $_SESSION['user'] = 'windah';
    $_SESSION['nama']  = 'tol cipularang';
    $_SESSION['alamat'] = 'Sidoarjo';
    }

?>