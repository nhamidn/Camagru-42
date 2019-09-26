<?php
session_start();
include '../config/database.php';
if (empty($_SESSION['username'])) {
  header("Location: ../login.php?status=Please login to access this page");
  exit();
}
if (empty($_POST['montage'])) {
  header("Location: ../camera.php");
  exit();
}
try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbh->prepare('SELECT COUNT(*) FROM posts WHERE picture = :dpicture');
  $query->bindParam(':dpicture', $_POST['montage'], PDO::PARAM_STR);
  $query->execute();
} catch (PDOException $e) {
  echo 'Error: '.$e->getMessage();
  exit();
}
if ($query->fetchColumn()) {
  try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $dbh->prepare("SELECT username FROM posts WHERE picture = :picture");
    $query->bindParam(':picture', $_POST['montage'], PDO::PARAM_STR);
    $query->execute();
    $data = $query->fetch();
    // echo $data['username'];
    if ($data['username'] == $_SESSION['username']) {
      $query = $dbh->prepare("DELETE FROM posts WHERE picture = :dpic");
      $query->bindParam(':dpic', $_POST['montage'], PDO::PARAM_STR);
      $query->execute();
      $link = "../images/".$_POST['montage'].".png";
      unlink($link);
    }
  } catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
    exit();
  }
}
if ($_SESSION['page'] == "profile")
  header("Location: ../users/profile.php");
else if ($_SESSION['page'] == "camera")
  header("Location: ../camera.php");
?>
