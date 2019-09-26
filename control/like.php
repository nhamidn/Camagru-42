<?php
  session_start();
  include '../config/database.php';
  if (empty($_POST['lpicture'])) {
    header("Location: ../index.php");
    exit();
  }
  if (empty($_SESSION[username])) {
    echo "not logged";
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
          echo "like";
          try {
            $query1 = $dbh->prepare("SELECT * FROM posts WHERE picture = :thephoto");
            $query1->bindParam(':thephoto', $_POST['lpicture'], PDO::PARAM_STR);
            $query1->execute();
            $datax = array();
            $datax = $query1->fetch(PDO::FETCH_ASSOC);
            try {
              $query2 = $dbh->prepare("SELECT * FROM users WHERE username = :userpic");
              $query2->bindParam(':userpic', $datax['username'], PDO::PARAM_STR);
              $query2->execute();
              $maildata = array();
              $maildata = $query2->fetch(PDO::FETCH_ASSOC);

              $who = $maildata['username'];
              $whomail = $maildata['email'];

              // Send mail notification
              $subject = "User Notification";
              $headers = 'From: <nhamid@student.1337.ma>';
              $message = 'Hello ' . $maildata['username'] . ", " . $_SESSION[username] . ' has just liked one of your pictures.';
              // if ($maildata['notification'] == 'Y')
              //   mail($whomail, $subject, $message, $headers);
              //-----------------------


            } catch (PDOException $e) {
              echo 'Error: '.$e->getMessage();
              exit();
            }
          } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
            exit();
          }
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
          echo "dislike";
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }
    } else {
      echo "not logged";
    }
  }

?>
