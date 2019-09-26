<?php
session_start();
include '../config/database.php';
if (empty($_SESSION['username'])) {
  header("Location: ../login.php?status=Please login to access this page");
  exit();
}
if ($_POST['filter'] != "1" && $_POST['filter'] != "2" && $_POST['filter'] != "3" && $_POST['filter'] != "4" && $_POST['filter'] != 'nostick') {
  header("Location: ../camera.php");
  exit();
}
if (empty($_POST['montage']) && empty($_POST['filter'])) {
  header("Location: ../camera.php");
  exit();
}
$usern = $_SESSION['username'];
$upload_dir = "../images/";
$name = md5(uniqid($usern, true));
$img = $_POST['montage'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir.$name.".png";
file_put_contents($file, $data);
if ($_POST['filter'] != 'nostick') {
  list($width, $height, $type, $attr) = getimagesize($file);
  $src = imagecreatefrompng("../stickers/".$_POST['filter'].".png");
  $dest = imagecreatefrompng($file);
  imagecopy($dest, $src, 0, 0, 0, 0, 307, 230);
  imagepng($dest, $file, 0);
}
try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbh->prepare("INSERT INTO posts (username, picture) VALUES (:author, :pic)");
  $query->bindParam(':author', $_SESSION['username'], PDO::PARAM_STR);
  $query->bindParam(':pic', $name, PDO::PARAM_STR);
  $query->execute();
} catch (PDOException $e) {
  echo 'Error: '.$e->getMessage();
  exit();
}
header("Location: ../camera.php");
?>
