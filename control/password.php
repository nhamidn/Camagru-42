<?php
session_start();
include '../config/database.php';

if (empty($_SESSION[token])) {
  if (empty($_SESSION[username])) {
    header ("Location: /index.php");
    exit();
  }
}
if (!empty($_SESSION[token]) || !empty($_SESSION[username])) {
  if (empty($_POST["rpass2"]) || empty($_POST["rpass"])) {
    // if (!empty($_SESSION[token])) {
    //   header("Location: ../password.php?token=" . $_SESSION[token] . "&error=Please enter a new password !");
    // } else {
    //     header("Location: ../password.php?error=Please enter a new password !");
    // }
      header("Location: ../index.php");
      exit();
  }
  if (!empty($_SESSION[token]) && !empty($_SESSION[username])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("SELECT * FROM users WHERE username = :user");
      $query->bindParam(':user', $_SESSION[username], PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      if ($_SESSION[token] != $data['token']) {
        header("Location: ../index.php");
        exit();
      } else {
        // code...
      }
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  }
  if ($_POST["rpass2"] != $_POST["rpass"]) {
    if (!empty($_SESSION[token])) {
      header("Location: ../password.php?token=" . $_SESSION[token] . "&error=Passwords does not match !");
      exit();
    } else {
      header("Location: ../password.php?error=Passwords does not match !");
      exit();
    }
  }
}

?>
