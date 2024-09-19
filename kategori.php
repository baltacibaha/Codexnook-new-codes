<!DOCTYPE html>
<html>
<link rel="stylesheet" href="kategori.css" />

<head>
     <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3809740976001286"
     crossorigin="anonymous"></script>
    <title>CodexNook.com/Kategori</title>
  <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
</head>

<body>

    <?php

    // Oturumu başlat
    session_start();

    // Veritabanı ayarları
    include 'ayar.php';

    // Ukas PHP
    include 'ukas.php';

    // Fonksiyonlar
    include 'func.php';

    // Quert, sorgu, kategori link
    $q = @$_GET["q"];

    $data = $db->prepare("SELECT * FROM kategoriler WHERE
        k_kategori_link=?
    ");
    $data->execute([
        $q
    ]);
    $_data = $data->fetch(PDO::FETCH_ASSOC);

    ?>
    <center>
        <?php include 'header.php'; // Header / Üst bilgi ?>
        <br><br>
        <h2>
            <?= $_data["k_kategori"] ?>
        </h2>
        <a href="konuac.php?kategori=<?= $_data["k_kategori_link"] ?>"><button>Konu Aç</button></a>
        <ul>
            <?php

            $dataList = $db->prepare("SELECT * FROM konular WHERE konu_kategori_link=? ORDER BY konu_id DESC");
            $dataList->execute([
                $q
            ]);
            $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

            foreach ($dataList as $row) {
                echo '<li><a href="konu.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
            }

            ?>
        </ul>
    </center>