<!DOCTYPE html>
<html>
<link rel="stylesheet" href="main.css" />

<head>
     <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3809740976001286"
     crossorigin="anonymous"></script>
    <title>CodexNook.com/Profilim</title>
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

    // Kullanıcı adı
    $kadi = @$_GET["kadi"];

    // Üye bilgilerini çek
    $data = $db->prepare("SELECT * FROM uyeler WHERE
        uye_kadi=?
    ");
    $data->execute([
        $kadi
    ]);
    $_data = $data->fetch(PDO::FETCH_ASSOC);

    ?>

    <center>
        <?php include 'header.php'; // Header / Üst bilgi ?>
        <br><br>
        <h2>
            <?= $_data["uye_adsoyad"] ?>
        </h2>
        <strong>Eposta:</strong>
        <?= $_data["uye_eposta"] ?>
        <hr>
        <table border="1" width="100%">
            <tr>
                <td>
                    <strong>Açtığı Konular:</strong>
                    <ul>
                        <?php

                        $dataList = $db->prepare("SELECT * FROM konular WHERE konu_uye_id=?");
                        $dataList->execute([
                            $_data["uye_id"]
                        ]);
                        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

                        foreach ($dataList as $row) {
                            echo '<li><a href="konu.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
                        }

                        ?>
                    </ul>
                </td>
                <td>
                    <strong>Yorumlar:</strong>
                    <ul>
                        <?php

                        $dataList = $db->prepare("SELECT * FROM yorumlar WHERE y_uye_id=? LIMIT 50");
                        $dataList->execute([
                            $_data["uye_id"]
                        ]);
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
        </table>
    </center>