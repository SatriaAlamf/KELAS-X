<?php 

    function belajar(){
        echo "Saya sedang belajar PHP";
    }

   
    function Luaspersegi($p = 10,$l = 5){
        $luas = $p * $l;
        echo $luas;
    }

    function Luas($p = 10,$l = 5){
        $luas = $p * $l;
        return $luas;
    }

    function output(){
        return "Belajar Function";
    }
   
    echo Luas(100,3) * 5;
?>