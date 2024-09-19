<?php

$host = "localhost";
$dbname = "forumsitesi";
$charset = "utf8";
$root = "baha";
$password = "990088Bb";

try {
	$db = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset;", $root, $password);
} catch (PDOException $error) {
	echo $error->getMessage();
}
if(
    @$_COOKIE["uye_eposta"]
    ) {
        $uyecek = $db -> prepare("SELECT * FROM uyeler WHERE uye_eposta=?");
        $uyecek -> execute(array(
            $_COOKIE["uye_eposta"]
            ));
            $fetch  =  $uyecek -> fetch(PDO::FETCH_ASSOC);
    }
?>