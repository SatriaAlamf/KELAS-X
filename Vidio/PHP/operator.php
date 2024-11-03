<?php 

    // OP aritmatika

    $a = 2;
    $b = 2;

    $c =  $a + $b;
    echo $c.'<br>';

    $c = $a  - $b;
    echo $c.'<br>';

    $c = $a  * $b;
    echo $c.'<br>';

    $c =  $a  / $b;
    echo floor($c).'<br>';

    $c = $a % $b;
    echo  $c.'<br>';

    // OP logika

    $c = $a <  $b;
    echo $c;

    $c = $a >   $b;
    echo $c;

    $c  = $a ==  $b;
    echo $c;

    $c = $a != $b;
    echo $c.'<br>';

    //Increment

    $a++;
    echo $a.'<br>';

    //OP string

    $kata = "Sura";
    $kota = "Baya";

    $hasil = $kata.$kota;
    $hasil .=' KOTA PAHLAWAN';
    echo $hasil;


?>