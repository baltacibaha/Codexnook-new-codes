<!DOCTYPE html>
<html>
<link rel="stylesheet" href="konu.css" />

<head>
    <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3809740976001286"
     crossorigin="anonymous"></script>
    <title>CodexNook.com/Konu</title>
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

    // Konu Link buraya gelecek
    $link = @$_GET["link"];

    $data = $db->prepare("SELECT * FROM konular WHERE
        konu_link=?
    ");
    $data->execute([
        $link
    ]);
    $_data = $data->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="container">
        <?php include 'header2.php'; // Header / Üst bilgi ?>
        <br><br>
        <h2>
            <?= $_data["konu_ad"] ?>
        </h2>
        <strong>Konu Sahibi:</strong>
        <a href="profil.php?kadi=<?= uye_ID_den_kadi($_data["konu_uye_id"]) ?>">
            <?= uye_ID_den_isme($_data["konu_uye_id"]) ?>
        </a>
        <p>
            <?= $_data["konu_mesaj"] ?>
        </p>
        <small>
            <?= $_data["konu_tarih"] ?>
        </small>
        <hr>
        <h3>Yorumlar:</h3>
        <?php

        $dataList = $db->prepare("SELECT * FROM yorumlar WHERE y_konu_id=?");
        $dataList->execute([
            $_data["konu_id"]
        ]);
        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

        foreach ($dataList as $row) {
            echo '
                <a href="profil.php?kadi=' . uye_ID_den_kadi($row["y_uye_id"]) . '" >
                    <strong id="yorum' . $row["y_id"] . '">
                        ' . uye_ID_den_isme($row["y_uye_id"]) . '
                    </strong>
                </a><br>
                <p>
                    ' . $row["y_yorum"] . '
                </p>
                <small><b>Tarih:</b> ' . $row["y_tarih"] . '</small>
                <hr>';
        }

        ?>

        <?php

        if (@$_SESSION["uye_id"]) {
            # Üye Olanlar Görebilir
        
            // Yorum yapma
            if ($_POST) {
                $yorum =htmlspecialchars($_POST["yorum"]); // Yorum ne?
        
                $dataAdd = $db->prepare("INSERT INTO yorumlar SET
                        y_uye_id=?,
                        y_konu_id=?,
                        y_yorum=?
                    ");
                $dataAdd->execute([
                    $_SESSION["uye_id"],
                    $_data["konu_id"],
                    $yorum
                ]);

                if ($dataAdd) {
                    $yorumcek = $db->prepare("SELECT * FROM yorumlar WHERE
                            y_uye_id=?
                            &&
                            y_konu_id=?

                            ORDER BY y_id DESC
                        ");
                    $yorumcek->execute([
                        $_SESSION["uye_id"],
                        $_data["konu_id"]
                    ]);
                    $_yorumcek = $yorumcek->fetch(PDO::FETCH_ASSOC);

                    echo '<p class="alert alert-success">Yorumunuz başarıyla eklendi. :)</p>';

                    // Yönlendirme
                    header("REFRESH:1;URL=konu.php?link=" . $link . "#yorum" . $_yorumcek["y_id"]);
                } else {
                    echo '<p class="alert alert-danger">Hay aksi bir hata ile karşılaştık. Lütfen
                        tekrar dener misiniz? :/</p>';

                    header("REFRESH:1;URL=konu.php?link=" . $link . "#yorumyap");
                }
            }

            echo '<h4 id="yorumyap">Yorum Yap:</h4>
                <form action="" method="post">
                    <textarea name="yorum" cols="30" rows="10" required></textarea>
                    <br>
                    <input type="submit" value="Yorum Yap">
                </form>';
        } else {
            # Ziyaretçiler Görebilir (Üye Olmayanlar Yani)
            echo '// Yorum yapabilmek için <a href="uyelik.php">giriş yap</a>ın yada <a href="uyelik.php?q=kayit">kayıt ol</a>un.';
        }

        ?>