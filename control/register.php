<?php
session_start();
if(session_status() == PHP_SESSION_ACTIVE)
  session_regenerate_id();
include '../config/database.php';
if (empty($_POST[runame]) || empty($_POST[remail]) || empty($_POST[rpass]) || empty($_POST[rpass2])) {
    header("Location: ../register.php?error=Please fill all the form !.");
    // echo "please enter a valid information\n";
    exit();
}
else {
  if (strcmp($_POST[rpass], $_POST[rpass2]) != 0)
    header("Location: ../register.php?error=Passwords does not match !");
  else
    echo "hello world";
}

?>
