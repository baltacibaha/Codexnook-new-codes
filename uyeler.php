<?php
session_start();
include 'ayar.php';
include 'ukas.php';
include 'func.php';
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="main.css" />

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3809740976001286"
        crossorigin="anonymous"></script>
    <title>Üyelerimiz</title>
    <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
</head>

<body>
    <center>
        <?php include 'header.php'; ?>
        <br><br>
        <center>
            <table>
                <tr>
                    <td colspan="2">
                        <h2>Üyelerimiz:</h2>
                        <style>
                         {
                             text-decoration:none;
                         }
                        </style>

                        <ul>
                            <?php
                            $dataList = $db->prepare("SELECT * FROM uyeler");
                            $dataList->execute();
                            $dataList = $dataList->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($dataList as $row) {
                                echo '<li><a href="profil.php?kadi=' . $row["uye_kadi"] . '">' . $row["uye_adsoyad"] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </center>
    </center>
</body>
</html>