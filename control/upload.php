<?php
$upload_dir = "../images/";  //implement this function yourself
$img = $_POST['montage'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir."image_name.png";
$success = file_put_contents($file, $data);

list($width, $height, $type, $attr) = getimagesize($file);
$src = imagecreatefrompng("../stickers/".$_POST['filter'].".png");
$dest = imagecreatefrompng($file);
echo $width." / ";
echo $height." / ";
$marginw = (3 * $width / 100) * (-1);
$marginh = (3 * $height / 100) * (-1);
echo $marginw." / ";
echo $marginw." / ";
// echo $marge_left." / ";
// echo $marge_top." / ";
// $stick_width = 30 * $width / 100;
// $stick_height = 30 * $height / 100;
// echo $stick_width." / ";
// echo $stick_height." / ";
// $sx = imagesx($stamp);
// $sy = imagesy($stamp);
// echo $sx." / ";
// echo $sy." / ";
imagecopy($dest, $src, 0, 0, 0, 0, 156, 117);
imagepng($dest, $file, 9);
move_uploaded_file($dest, $file);
// header("Location: ../camera.php");
?>
