<?php
session_start();
include '../config/database.php';

if (empty($_SESSION['token'])) {
  if (empty($_SESSION['username'])) {
    header ("Location: ../index.php");
    exit();
  }
}
if (!empty($_SESSION['token']) || !empty($_SESSION['username'])) {
  if (empty($_POST["rpass2"]) || empty($_POST["rpass"])) {
    // if (!empty($_SESSION[token])) {
    //   header("Location: ../password.php?token=" . $_SESSION[token] . "&error=Please enter a new password !");
    // } else {
    //     header("Location: ../password.php?error=Please enter a new password !");
    // }
      header("Location: ../index.php");
      exit();
  }
  if (!empty($_SESSION['token']) && !empty($_SESSION['username'])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("SELECT * FROM users WHERE username = :user");
      $query->bindParam(':user', $_SESSION['username'], PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      if ($_SESSION['token'] != $data['token']) {
        header("Location: ../index.php");
        exit();
      }
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  }
  if ($_POST["rpass2"] != $_POST["rpass"]) {
    if (!empty($_SESSION['token'])) {
      header("Location: ../password.php?token=" . $_SESSION['token'] . "&error=Passwords does not match !");
      exit();
    } else {
      header("Location: ../password.php?error=Passwords does not match !");
      exit();
    }
  } else if (strlen($_POST["rpass"]) < 8 || strlen($_POST["rpass"]) > 15) {
    if (!empty($_SESSION['token'])) {
      header("Location: ../password.php?token=" . $_SESSION['token'] . "&error=Passwords must have a lenght between 8 and 15 !");
      exit();
    } else {
      header("Location: ../password.php?error=Passwords must have a lenght between 8 and 15 !");
      exit();
    }
  }
  else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\\!@#\$%\^&\*\[\]"\';:_\-<>\., =\+\/]).{8,}$/', $_POST["rpass"])) {
    if (!empty($_SESSION['token'])) {
      header("Location: ../password.php?token=" . $_SESSION['token'] . "&error=Passwords must have [0-9] [a-z] [A-Z] and special characters!");
      exit();
    } else {
      header("Location: ../password.php?error=Passwords must have [0-9] [a-z] [A-Z] and special characters!");
      exit();
    }
  } else {
    $pass = hash(Whirlpool, $_POST["rpass"]);
    if (!empty($_SESSION['token'])) {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare("UPDATE users SET password = :rpass WHERE token = :rtoken");
        $query->bindParam(':rpass', $pass, PDO::PARAM_STR);
        $query->bindParam(':rtoken', $_SESSION['token'], PDO::PARAM_STR);
        $query->execute();
        $null = "";
        try {
          $query = $dbh->prepare("UPDATE users SET token = :notoken WHERE token = :rtoken");
          $query->bindParam(':rtoken', $_SESSION['token'], PDO::PARAM_STR);
          $query->bindParam(':notoken', $null, PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
        // redirect to login page
        session_destroy();
        header ("Location: /login.php?status=Password changed, you can login now");
        // --------------------
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
    } else {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare("UPDATE users SET password = :rpass WHERE username = :ruser");
        $query->bindParam(':rpass', $pass, PDO::PARAM_STR);
        $query->bindParam(':ruser', $_SESSION['username'], PDO::PARAM_STR);
        $query->execute();
        $null = "";
        try {
          $query = $dbh->prepare("UPDATE users SET token = :notoken WHERE username = :user");
          $query->bindParam(':user', $_SESSION['username'], PDO::PARAM_STR);
          $query->bindParam(':notoken', $null, PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
        // redirect to login page
        session_destroy();
        header ("Location: /login.php?status=Password changed, you can login now");
        // --------------------
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
    }
  }
}

?>
