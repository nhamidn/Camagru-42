<?php
session_start();
include '../config/database.php';
if (empty($_SESSION[username]))
  header("Location: ../login.php?status=Please login to access this page");
if ($_POST['filter'] != "1" && $_POST['filter'] != "2" && $_POST['filter'] != "3" && $_POST['filter'] != "4") {
  header("Location: ../camera.php");
  exit();
}
$_SESSION[page] = "camera";
if (empty($_POST['montage']) && empty($_POST['filter']))
  header("Location: ../camera.php");
$upload_dir = "../images/";  //implement this function yourself
$img = $_POST['montage'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir."image_name.png";
file_put_contents($file, $data);
list($width, $height, $type, $attr) = getimagesize($file);
$src = imagecreatefrompng("../stickers/".$_POST['filter'].".png");
$dest = imagecreatefrompng($file);
imagecopy($dest, $src, 0, 0, 0, 0, 307, 230);
imagepng($dest, $file, 9);
move_uploaded_file($dest, $file);
header("Location: ../camera.php");
?>
