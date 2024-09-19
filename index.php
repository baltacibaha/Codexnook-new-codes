<!DOCTYPE html>
<html>
<link rel="stylesheet" href="main.css" />

<head>
    <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CodexNook.com/Anasayfa</title>
    <meta name="description" content="Merhaba Yeni Açılan Forum Sitemizi Ziyaret Edin!">
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

    ?>

    <center>
        <?php include 'header.php'; // Header / Üst bilgi ?>
        <br><br>
        <table border="1">
            <tr>
                <td>
                    <strong>Yeni Açılan Konular:</strong>
                    <style>
                        a {
                            color:black;
                            text-decoration:none;
                            border-radius:5px;
                            
                        }
                    </style>
                    <hr>
                    <ul>
                        <?php
                        $dataList = $db->prepare("SELECT * FROM konular ORDER BY konu_id DESC LIMIT 20");
                        $dataList->execute();
                        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

                        foreach ($dataList as $row) {
                            echo '<li><a href="konu.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
                        }
                        ?>

                    </ul>
                </td>
                <td>
                    <strong>Son Cevaplar:</strong>
                    <hr>
                    <ul>
                        <?php
                        $dataList = $db->prepare("SELECT * FROM yorumlar ORDER BY y_id DESC LIMIT 50");
                        $dataList->execute();
                        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

                        // Konu ID'ler diye dizi oluşturdum
                        $konu_idler = [];

                        foreach ($dataList as $row) {
                            // Konu ID'lere eleman / ID ekliyorum
                            array_push($konu_idler, $row["y_konu_id"]);

                        }

                        // Aynı ID'leri sil / bir defa göster / benzersiz liste oluştur
                        $konu_idler = array_unique($konu_idler);

                        foreach ($konu_idler as $konuid) {
                            $konu_cek = $db->prepare("SELECT * FROM konular WHERE
                                konu_id=?
                            ");
                            $konu_cek->execute([
                                $konuid
                            ]);
                            $_konu_cek = $konu_cek->fetch(PDO::FETCH_ASSOC);

                            echo '<li><a href="konu.php?link=' . $_konu_cek["konu_link"] . '">' . $_konu_cek["konu_ad"] . '</a></li>';

                            // 10'dan fazla olunca döngüyü durdur.
                            @$i++;
                            if ($i == 10) {
                                break;
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <h2>Kategoriler:</h2>

                    <ul>
                        <?php
                        $dataList = $db->prepare("SELECT * FROM kategoriler LIMIT 20");
                        $dataList->execute();
                        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

                        foreach ($dataList as $row) {
                            echo '<li><a href="kategori.php?q=' . $row["k_kategori_link"] . '">' . $row["k_kategori"] . '</a></li>';
                        }
                        ?>
                    </ul>
                </td>
            </tr>
        </table>
    </center>