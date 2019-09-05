<?php
session_start();
include '../config/database.php';
if (empty($_SESSION[username])) {
  header ("Location: ../index.php");
  exit();
} else if (empty($_POST["nuname"]) && empty($_POST["nemail"])) {
  header ("Location: ../settings.php?error=Nothing done!");
  exit();
} else {
  if (!empty($_POST["nuname"])) {
    if (strlen($_POST["nuname"]) < 6 || strlen($_POST["nuname"]) > 50)
      header("Location: ../settings.php?error=Username must have a lenght between 6 and 50!");
    if ($_POST["nuname"] == $_SESSION[username]) {
      header ("Location: ../settings.php?error=This is your current Username!");
      exit();
    }
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE username = :uname');
      $query->bindParam(':uname', $_POST["nuname"], PDO::PARAM_STR);
      $query->execute();
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
    if ($query->fetchColumn()) {
      header("Location: ../settings.php?error=Username already taken!");
      exit();
    }
  }
  if (!empty($_POST["nemail"])) {
    $mail = strtolower($_POST["nemail"]);
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      header("Location: ../settings.php?error=Please enter a valid email address!");
      exit();
    }
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("SELECT * FROM users WHERE username = :uname");
      $query->bindParam(':uname', $_SESSION[username], PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      if ($data['email'] == $mail) {
        header("Location: ../settings.php?error=This is your current email address!");
        exit();
      }
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE email = :nemail');
      $query->bindParam(':nemail', $mail, PDO::PARAM_STR);
      $query->execute();
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
    if ($query->fetchColumn()) {
      header("Location: ../settings.php?error=email already associated with another account!");
      exit();
    }
  }
  // Updating informations
  // -----> Updating username
  if (!empty($_POST["nuname"])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("UPDATE users SET username = :newuser WHERE username = :olduser");
      $query->bindParam(':newuser', $_POST["nuname"], PDO::PARAM_STR);
      $query->bindParam(':olduser', $_SESSION[username], PDO::PARAM_STR);
      $query->execute();
      $_SESSION[username] = $_POST["nuname"];
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  }
  // -----> Updating email address
  if (!empty($_POST["nemail"])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("UPDATE users SET email = :newemail WHERE username = :user");
      $query->bindParam(':newemail', $mail, PDO::PARAM_STR);
      $query->bindParam(':user', $_SESSION[username], PDO::PARAM_STR);
      $query->execute();
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  }
  header("Location: ../settings.php?error=informations changed successfully!");
  exit();
}
?>
