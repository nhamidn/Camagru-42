<?php
  session_start();
  include '../config/database.php';
  if (empty($_SESSION[username])) {
    header("Location: ../login.php?status=Please login to make comments and likes");
    exit();
  }
  if(!empty($_POST['cpicture']) and !empty($_POST['ccontent'])) {
    if (!empty($_SESSION[username])) {
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
          $query = $dbh->prepare("SELECT * FROM posts WHERE picture = :cpicture");
          $query->bindParam(':cpicture', $_POST['cpicture'], PDO::PARAM_STR);
          $query->execute();
          $infos = array();
          $infos = $query->fetch(PDO::FETCH_ASSOC);
          try {
            $query = $dbh->prepare("SELECT * FROM users WHERE username = :uname");
            $query->bindParam(':uname', $infos['username'], PDO::PARAM_STR);
            $query->execute();
            $mailinfos = array();
            $mailinfos = $query->fetch(PDO::FETCH_ASSOC);

            $who = $mailinfos['username'];
            $whomail = $mailinfos['email'];

            // Send mail notification
            $subject = "User Notification";
            $headers = 'From: <nhamid@student.1337.ma>';
            $message = 'Hello ' . $who . ", " . $_SESSION[username] . ' has just left a comment on one of your pictures.';
            if ($mailinfos['notification'] == 'Y')
              mail($whomail, $subject, $message, $headers);
            //-----------------------

          } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
            exit();
          }
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
    }
  }

?>
