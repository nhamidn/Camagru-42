<?php
$upload_dir = "../images/";  //implement this function yourself
$img = $_POST['montage'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir."image_name.png";
$success = file_put_contents($file, $data);
header("Location: ../camera.php");
?>
