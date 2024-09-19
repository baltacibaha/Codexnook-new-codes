<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>CodexNook</h1>
                </a>
            </div>
            <div class="menu">
                <?php
                session_start();
                if (@$_SESSION["uye_id"]) {
                    echo '
      <a href="index.php" class="button">Anasayfa</a>
      <a href="uyeler.php" class="button">Üyelerimiz</a>
      <a href="profil.php?kadi=' . @$_SESSION["uye_kadi"] . '"class="button">Profilime Git</a>
      <a href="uyelik.php?p=cikis" class="button">Çıkış</a>
      ';
                } else {
                    echo '
      <a href="index.php" class="button">Anasayfa</a>
      <a href="uyeler.php" class="button">Üyelerimiz</a>
      <a href="uyelik.php?p=kayit" class="button">Üye Ol</a>
      <a href="uyelik.php" class="button">Giriş Yap</a>';
                }
                ?>
            </div>
        </div>
    </header>
</body>

</html>