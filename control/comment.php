<?php
  session_start();
  include '../config/database.php';
  if (empty($_SESSION[username])) {
    header("Location: ../login.php?status=Please login to make comments and likes");
    exit();
  }
  if(!empty($_POST['cpicture']) and !empty($_POST['ccontent'])){
    if (!empty($_SESSION[username])) {
      echo $_POST['cpicture'];
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare('SELECT COUNT(*) FROM posts WHERE picture = :cpic');
        $query->bindParam(':cpic', $_POST['cpicture'], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
      if ($query->fetchColumn()) {
        try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = $dbh->prepare("INSERT INTO comments (username, picture_id, comment) VALUES (:cuname, :cpicture, :content)");
          $query->bindParam(':cuname', $_SESSION[username], PDO::PARAM_STR);
          $query->bindParam(':cpicture', $_POST['cpicture'], PDO::PARAM_STR);
          $query->bindParam(':content', $_POST['ccontent'], PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
    }
  }
?>
