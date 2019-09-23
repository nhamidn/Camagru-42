<?php
include '../config/database.php';
session_start();

if (empty($_POST["luname"]) || empty($_POST["lpass"])) {
    header("Location: ../login.php?status=Please enter you username and your password !");
    exit();
}
else {
  $who = strtolower(trim($_POST["luname"]));
  $pass = hash(Whirlpool, $_POST["lpass"]);
  try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE username = :luser');
    $query->bindParam(':luser', $who, PDO::PARAM_STR);
    $query->execute();
  } catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
    exit();
  }
  if ($query->fetchColumn()) {
    try {
      $query = $dbh->prepare("SELECT * FROM users WHERE username = :luser");
      $query->bindParam(':luser', $who, PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      $upass = $data['password'];
      $verified = $data['verified'];
      if ($upass == $pass) {
        if ($verified == 'Y') {
          $_SESSION[user_mail] = $data['email'];
          $_SESSION[username] = $who;
          $_SESSION[logout] = hash(Whirlpool, bin2hex(uniqid($_SESSION[username], true)));
          header("Location: ../index.php");
        } else {
          header("Location: ../login.php?status=Account not activated yet !");
          exit();
        }
      } else {
        header("Location: ../login.php?status=Incorrect Password !");
        exit();
      }
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  } else {
    header("Location: ../login.php?status=No account with this username !");
    exit();
  }
}

?>
