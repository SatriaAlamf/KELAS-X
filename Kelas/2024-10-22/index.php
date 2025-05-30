<?php 
    $data = "Saya Belajar PHP di SMKN 2 BUDURAN";
    echo $data;

    $isi = "Hari ini saya belajar PHP";
    $materi = "Materi Belajar PHP";
    $sekolah = ["TK Mashito", "SDN Candi", "SMPN 2 Jabon",  "SMKN 2 Buduran."];
    $identitas = ["Satria", "Jl. Kenanga No.4, Ds. Bligo, Kec. Candi, Kab. Sidoarjo."];
    $judul = "Curiculum Vitae";
    $hobies = [];
    $skil = ["HTML Expert", "CSS Expert", "PHP Newbie"];
    $list1 = "variabel";
    $list2 = "Array";
    $list3 = "Pengujian";
    $list4 = "Pengulangan";
    $list5 = "Function";
    $list6 = "Class";
    $list7 = "Object";
    $list8 = "Framework";
    $list9 = "PHP dan MySQL";

    $list = [
        "variabel", 
        "Array", 
        "Pengujian", 
        "Pengulangan", 
        "Function", 
        "Class", 
        "Object", 
        "Framework", 
        "PHP dan MySQL"]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .kamar{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $judul; ?></h1>
    </div>
    <div class="identitas">
        <table>
            <thead>

            </thead>
            <tbody>
                <tr>
                    <th>Identitas</th>
                </tr>
                <tr>
                    <th>Nama</th>
                    <th><?= $identitas[0]; ?></th>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th><?=  $identitas[1]; ?></th>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="kamar">
    <h1><?=$data; ?></h1>
    <p><?=$isi; ?></p>
    <h2><?=$materi; ?></h2>
    <ol>
        <li><?=$list[0]; ?></li>
        <p>Variabel adalah wadah atau tempat menyimpan data</p>
        <p>Data bisa berupa text atau string bisa juga angka atau numeric, Data juga bisa gabungan antara text, angka, dan simbol</p>
        <li><?=$list[1]; ?></li>
        <li><?=$list[2]; ?></li>
        <li><?=$list[3]; ?></li>
        <li><?=$list[4]; ?></li>
        <li><?=$list[5]; ?></li>
        <li><?=$list[6]; ?></li>
        <li><?=$list[7]; ?></li>
        <li><?=$list[8]; ?></li>
    </ol>
    </div>
</body>
</html>