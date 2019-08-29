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
}

?>
