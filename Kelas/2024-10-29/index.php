<?php
$sekolah = ["TK Mashito", "SDN Candi", "SMPN 2 Jabon", "SMKN 2 Buduran", "UNESA"];
$sekolahs = ["TK" => "TK Mashito", "SD" => "SDN Candi", "SMP" => "SMPN 2 Jabon", "SMK" => "SMKN 2 Buduran", "univ" => "UNESA"];
$skills = ["C++"=>"Expert", "HTML" => "Newbie", "CSS"=>"Newbie", "PHP"=>"Intermediate", "Java script"=> "Intermediate"];
$identitas = ["Nama" => "Satria", "Alamat" => "Ds. bLigo", "Email" => "sartriaalm@gmail.com"];
$hobi= ["Membaca Buku", "Memancing", "Menonton Film"];
// echo $sekolah[0];
// echo "<br>";
// echo $sekolahs["TK"];
// echo "<br>";
// echo $sekolah[1];
// echo "<br>";
// echo $sekolahs["SD"];
// echo "<br>";

// for ($i = 0; $i < 4; $i++) {
//     echo $sekolah[$i];
//     echo "<br>";
// }

// foreach ($sekolah as $key) {
//     echo $key;
//     echo "<br>";
// }

// foreach ($sekolahs as $key => $value) {
//     echo $key . " = " . $value;
//     echo "<br>";
//}
if(isset($_GET [$menu])){
    $menu = $_get ["menu"];
    echo $menu;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<ul>
    <li><a href="#">Home</a></li>
    <li><a href="?menu=cv">CV</a></li>
    <li><a href="?menu=project">Project</a></li>
    <li><a href="?menu=contact">Contact</a></li>
</ul>
  
    <h2>Identitas</h2>
    <table border="1">
        
        <tbody>
            <?php
            foreach ($identitas as $key => $value) {
                echo "<tr>";
                echo "<td>" . $key . "</td>";
                echo "<td>" . $value . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <hr>
    </table>
    <h2>Riwayat Sekolah</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Jenjang</th>
                <th>Nama Sekolah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($sekolahs as $key => $value) {
                echo "<tr>";
                echo "<td>" . $key . "</td>";
                echo "<td>" . $value . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <hr>
    <h2>Skill</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Skill</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($skills as $key => $value) {
                echo "<tr>";
                echo "<td>" . $key . "</td>";
                echo "<td>" . $value . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <hr>
            <h2>HOBI</h2>
            <ol>
            <?php
            foreach ($hobi as $key) {
               
                echo "<li>" . $key . "</li>";
                
               
            }
            ?>
            </ol>
</body>
</html>
