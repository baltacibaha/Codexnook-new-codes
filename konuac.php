<!DOCTYPE html>
<html>
<link rel="stylesheet" href="konuac.css" />

<head>
    <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3809740976001286"
     crossorigin="anonymous"></script>
    <title>CodexNook.com/Konu aç</title>
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

    if (!@$_SESSION["uye_id"]) {
        // Üye olmayanlar burayı görebilir
    
        echo '<center><h1>// Konu paylaşabilmek için <a href="uyelik.php">giriş yap</a>ın yada <a href="uyelik.php?q=kayit">kayıt ol</a>un.</h1></center>';
        // Alttakileri gösterme
        exit;
    }

    // Kategori linki
    $kategori = @$_GET["kategori"];

    ?>

    <center>
        <div class="container">
            <?php include 'header2.php'; // Header / Üst bilgi ?>
            <br><br>
            <h2>Konu Paylaşma</h2>
            <?php

            if ($_POST) {
                $ad = htmlspecialchars($_POST["ad"]);
                $mesaj = htmlspecialchars($_POST["mesaj"]);

                $link = permalink($ad) . "-" . rand(000, 999);

                $dataAdd = $db->prepare("INSERT INTO konular SET
                konu_ad=?,
                konu_link=?,
                konu_mesaj=?,
                konu_uye_id=?,
                konu_kategori_link=?
            ");
                $dataAdd->execute([
                    $ad,
                    $link,
                    $mesaj,
                    @$_SESSION["uye_id"],
                    $kategori
                ]);

                if ($dataAdd) {
                    echo '<p class="alert alert-success">Başarıyla konunuz paylaşıldı. :)</p>';

                    header("REFRESH:1;URL=konu.php?link=" . $link);
                } else {
                    echo '<p class="alert alert-danger">Hay aksi bir hata ile karşılaştık, lütfen tekrar deneyiniz. :/</p>';

                    header("REFRESH:1;URL=konuac.php");
                }
            }

            ?>
            <strong>
                <?= kategori_linkten_kategori_adi($kategori) ?> Kategorisinde Konu Açmaktasınız:
            </strong>
            <form action="" method="post">
                <strong>Konu Adı:</strong>
                <input type="text" name="ad" required><br>
                <strong>Konu Mesajı:</strong><br>
                <textarea name="mesaj" cols="30" rows="10" required></textarea>
                <br>
                <input type="submit" value="Konuyu Aç">
            </form>

    </center>