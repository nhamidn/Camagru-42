<?php
  include '../config/database.php';
  session_start();

  if (isset($_GET["token"])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE token = :rtoken');
      $query->bindParam(':rtoken', $_GET["token"], PDO::PARAM_STR);
      $query->execute();
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
    }
    if ($query->fetchColumn()) {
      try {
        $query = $dbh->prepare("SELECT * FROM users WHERE token = :vtoken");
        $query->bindParam(':vtoken', $_GET["token"], PDO::PARAM_STR);
        $query->execute();
        $data = array();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $who = $data['username'];
        $verified = $data['verified'];
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
      }
      if ($verified == "N") {
        $var = 'Y';
        $null = null;
        try {
          $query = $dbh->prepare("UPDATE users SET verified = :verify, token = :notoken WHERE username = :user");
          $query->bindParam(':user', $who, PDO::PARAM_STR);
          $query->bindParam(':verify', $var, PDO::PARAM_STR);
          $query->bindParam(':notoken', $null, PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
        }
      } else {
        header("Location: ../register.php?error=Page not found, or link expired !");
      }
    } else {
      header("Location: ../register.php?error=Page not found, or link expired !");
      exit();
    }
  } else {
    header("Location: ../register.php?error=Page not found !");
  }
?>
