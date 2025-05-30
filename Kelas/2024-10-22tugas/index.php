<?php 
    $judul = "Curriculum Vitae";
    $identitas = [
        "Nama : Satria Alam Fajar W.", 
        "Alamat : Jl. Kenanga No.4, Ds. Bligo, Kec. Candi, Kab. Sidoarjo",
        "Email : satriaalm09@gmail.com"
    ];

   
    $sekolah = [
        "TK Mashito" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png",
        "SDN Candi" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png",
        "SMPN 2 Jabon" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png",
        "SMKN 2 Buduran" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png"
    ];

   
    $hobies = [
        "Membaca Buku" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png",
        "Menonton Film" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png",
        "Coding" => "https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png"
    ];

    $skills = [
        ["name" => "HTML", "level" => "Expert", "image" => "https://1.bp.blogspot.com/-AvM-a6R_nnI/WnPeZ9VrfZI/AAAAAAAABZM/VhubjScBvuAC01MszE8j_c4RqczEWziCwCLcBGAs/s1600/2000px-HTML5_logo_and_wordmark.svg.png"],
        ["name" => "CSS", "level" => "Expert", "image" => "https://1000logos.net/wp-content/uploads/2020/09/CSS-Logo.jpg"],
        ["name" => "PHP", "level" => "Newbie", "image" => "https://pngimg.com/uploads/php/php_PNG43.png"]
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portfolio - <?= $judul; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, Helvetica, sans-serif;
        }
        .title {
            height: 140px;
            color: white;
            justify-content: center;
            align-items: center;
            display: flex; 
        }
        .profile-img {
            width: 250px; 
            height: 250px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #343a40;
            margin-right: 20px;
        }
        .identitas-container {
            font-size: 1.25rem; 
        }
        .school-img, .hobby-img {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .skill-icon {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-right: 15px;
        }
        .skill-container {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .skill-container:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="title bg-dark">
        <h1 class="m-0"><?= $judul ?></h1> 
    </div>
    <div class="container mt-5">
       
        <div class="card p-4">
            <div class="d-flex align-items-center">
                <img src="https://w7.pngwing.com/pngs/716/896/png-transparent-window-graphic-paper-frames-graphy-window-furniture-photography-rectangle.png" alt="Profile Photo" class="profile-img">
                <div class="identitas-container">
                    <h1 class="display-5 mb-4">Identitas</h1>
                    <ul class="list-unstyled">
                        <?php foreach ($identitas as $info): ?>
                            <li><?= $info; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-6 col-md-12">
                <div class="card p-3">
                    <h2 class="card-title mb-4">Sekolah</h2>
                    <?php foreach ($sekolah as $school => $image): ?>
                        <img src="<?= $image; ?>" alt="<?= $school; ?>" class="school-img">
                        <h5 class="text-center"><?= $school; ?></h5>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card p-3">
                    <h2 class="card-title mb-4">Hobi</h2>
                    <?php foreach ($hobies as $hobby => $image): ?>
                        <img src="<?= $image; ?>" alt="<?= $hobby; ?>" class="hobby-img">
                        <h5 class="text-center"><?= $hobby; ?></h5>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card p-3 mt-4">
            <h2 class="card-title mb-3">Skill</h2>
            
            <?php foreach ($skills as $skill): ?>

                <div class="skill-container">
                    <img src="<?= $skill['image']; ?>" alt="<?= $skill['name']; ?> icon" class="skill-icon">
                    <div>
                        <h5><?= $skill['name']; ?></h5>
                        <p>Level: <?= $skill['level']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="container text-center mt-5">
        <p>&copy; <?= date("Y"); ?> Satria Alam. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
