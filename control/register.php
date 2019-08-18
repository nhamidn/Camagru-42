<?php
session_start();
if(session_status() == PHP_SESSION_ACTIVE)
  session_regenerate_id();
include '../config/database.php';
if (empty($_POST[runame]) || empty($_POST[remail]) || empty($_POST[rpass]) || empty($_POST[rpass2])) {
    header("Location: ../register.php?error=Please fill the form with a valid informations!");
    exit();
}
else {
  if (strcmp($_POST[rpass], $_POST[rpass2]) != 0) {
    header("Location: ../register.php?error=Passwords does not match !");
  } else {
    if (strlen($_POST[rpass]) < 8)
      header("Location: ../register.php?error=Passwords must have a least lenght 8 !");
    else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\\!@#\$%\^&\*\[\]"\';:_\-<>\., =\+\/]).{8,}$/', $_POST[rpass]))
    {
      header("Location: ../register.php?error=Passwords must have [0-9] [a-z] [A-Z] and special characters!");
    } else {
      echo 'Secure enough';
    }
  }
}

?>
