<?php
include '../config/database.php';
session_start();

if (empty($_POST["eemail"])) {
    header("Location: ../login.php?status=Please enter your recovery email !&p=2");
    exit();
} else {
  $email = strtolower($_POST["eemail"]);
  try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE email = :remail');
    $query->bindParam(':remail', $email, PDO::PARAM_STR);
    $query->execute();
  } catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
    exit;
  }
  if ($query->fetchColumn()) {
    try {
      $query = $dbh->prepare("SELECT * FROM users WHERE email = :remail");
      $query->bindParam(':remail', $email, PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      $who = $data['username'];
      $verified = $data['verified'];
      if ($verified == 'Y') {
        try {
          $rtoken = bin2hex(uniqid($who, true));
          $query = $dbh->prepare("UPDATE users SET token = :rtoken WHERE email = :remail");
          $query->bindParam(':rtoken', $rtoken, PDO::PARAM_STR);
          $query->bindParam(':remail', $email, PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }

        //------------------------------------- MAIL -----------------------------

        $subject = "CAMAGRU account recovery";
        $headers = 'From: <nhamid@student.1337.ma>';
        $message = 'Hello ' . $who . ', to reset your password click this link : http://localhost/control/password.php?token=' . $rtoken . '.';
        if (mail($email, $subject, $message, $headers)) {
          header("Location: ../login.php?status=Please reset your password using the link sent to your mail !&p=2");
        } else {
          header("Location: ../login.php?status=Error sending mail !&p=2");
        }

      } else {
        header("Location: ../reset.php?error=Account not activated yet !");
        exit();
      }

    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
    }
  } else {
    header("Location: ../reset.php?error=No account using this email address !");
    exit();
  }
}
 ?>
