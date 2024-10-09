<?php 

    // array dimensi

    // $nama = array("Iwan", "Bintang",  "Rian",  "Hayis", 100, 2.5);
    
    // var_dump($nama);

    // echo "<br>";

    // echo  $nama[5];

    // echo "<br>";

    // for ($i=0; $i < 6 ; $i++) { 
    //     // echo $i;
    //     echo $nama[$i].'<br>';
    // }

    // foreach ($nama as $key) {
    //     echo  $key.'<br>';
    // }

    // array asosiatif

    $nama = array(
        "Arya" => "Surabayacoret",
        "Rian" => "Surabaya",
        "Hayis" => "Sidoarjo",
    );

    var_dump($nama);

    echo '<br>';

    // echo $nama['Fajar'];

    foreach ($nama as $a => $b) {
    echo $a.' : '.$b.'<br>';
    }
?>