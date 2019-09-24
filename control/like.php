<?php
  session_start();
  include '../config/database.php';
  if (empty($_SESSION[username])) {
    header("Location: ../login.php?status=Please login to make comments and likes");
    exit();
  }
  if(!empty($_POST['lpicture'])) {
    if (!empty($_SESSION[username])) {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare('SELECT COUNT(*) FROM posts WHERE picture = :lphoto');
        $query->bindParam(':lphoto', $_POST['lpicture'], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
      if (!$query->fetchColumn()) {
        exit();
      }
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare('SELECT COUNT(*) FROM likes WHERE username = :liker AND picture_id = :lpic');
        $query->bindParam(':liker', $_SESSION[username], PDO::PARAM_STR);
        $query->bindParam(':lpic', $_POST['lpicture'], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
      if (!$query->fetchColumn()) {
        try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = $dbh->prepare("INSERT INTO likes (username, picture_id) VALUES (:luname, :lpicture)");
          $query->bindParam(':luname', $_SESSION[username], PDO::PARAM_STR);
          $query->bindParam(':lpicture', $_POST['lpicture'], PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
      else {
        try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = $dbh->prepare("DELETE FROM likes WHERE  username = :luname AND picture_id = :lpicture");
          $query->bindParam(':luname', $_SESSION[username], PDO::PARAM_STR);
          $query->bindParam(':lpicture', $_POST['lpicture'], PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
    }
  }

?>
