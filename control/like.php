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
          $query = $dbh->prepare("INSERT INTO comments (username, picture_id, comment) VALUES (:cuname, :cpicture, :content)");
          $query->bindParam(':cuname', $_SESSION[username], PDO::PARAM_STR);
          $query->bindParam(':cpicture', $_POST['cpicture'], PDO::PARAM_STR);
          $query->bindParam(':content', htmlspecialchars($_POST['ccontent']), PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
    }
  }

?>
