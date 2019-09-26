<?php
  session_start();
  include '../config/database.php';
  if (empty($_POST['notification'])) {
    header("Location: ../index.php");
    exit();
  }
  if (empty($_SESSION['username'])) {
    exit();
  }
  if(!empty($_POST['notification'])){
    if ($_POST['notification'] == "Y" || $_POST['notification'] == "N") {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare("UPDATE users SET notification = :state WHERE username = :user");
        $query->bindParam(':state', $_POST['notification'], PDO::PARAM_STR);
        $query->bindParam(':user', $_SESSION['username'], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
    }
  }
?>
