<?php
include '../config/database.php';
session_start();
if (empty($_POST["runame"]) || empty($_POST["remail"]) || empty($_POST["rpass"]) || empty($_POST["rpass2"])) {
    header("Location: ../register.php?error=Please fill the form with a valid informations!");
    exit();
}
else {
  $mail = strtolower($_POST["remail"]);
  if (strcmp($_POST["rpass"], $_POST["rpass2"]) != 0) {
    header("Location: ../register.php?error=Passwords does not match !");
  } else {
    if (strlen($_POST["runame"]) < 6)
      header("Location: ../register.php?error=Username must have a least lenght 6 !");
    else if (strlen($_POST["rpass"]) < 8)
      header("Location: ../register.php?error=Passwords must have a least lenght 8 !");
    else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\\!@#\$%\^&\*\[\]"\';:_\-<>\., =\+\/]).{8,}$/', $_POST["rpass"]))
    {
      header("Location: ../register.php?error=Passwords must have [0-9] [a-z] [A-Z] and special characters!");
    } else {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE username = :uname');
        $query->bindParam(':uname', $_POST["runame"], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
      }
      if ($query->fetchColumn()) {
        header("Location: ../register.php?error=Username already taken.");
        exit();
      }
      else {
        try {
          $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE email = :reemail');
          $query->bindParam(':reemail', $mail, PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
        }
        if ($query->fetchColumn()) {
          header("Location: ../register.php?error=Email already associated with an existing account.");
          exit();
        }
      }
      $usern = $_POST["runame"];
      $pass = hash(Whirlpool, $_POST["rpass"]);
      // $token = bin2hex(openssl_random_pseudo_bytes(24));
      $token = uniqid($usern, true);
      try {
        $query = $dbh->prepare("INSERT INTO users (username, email, password, token) VALUES (:runame, :rmail, :rpassword, :rtoken)");
        $query->bindParam(':runame', $usern, PDO::PARAM_STR);
        $query->bindParam(':rmail', $mail, PDO::PARAM_STR);
        $query->bindParam(':rpassword', $pass, PDO::PARAM_STR);
        $query->bindParam(':rtoken', $token, PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
      }

      //------------------------------------- MAIL -----------------------------

      $subject = "CAMAGRU mail verification";
      $headers = 'From: <nhamid@student.1337.ma>';
      $message = 'Hello ' . $usern . ', to activate your account click this link : http://localhost/control/verify.php?token=' . $token . '.';
      if (mail($_POST["remail"], $subject, $message, $headers)) {
        header("Location: ../login.php?status=Account created, please activate it using the link sent to your email !");
      } else {
        header("Location: ../login.php?status=Error sending verification mail !");
      }
    }
  }
}

?>
