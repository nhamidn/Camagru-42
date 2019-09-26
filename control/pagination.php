<?php
session_start();
include '../config/database.php';
if (empty($_SESSION[username])) {
  header("Location: ../index.php");
  exit();
}
 ?>
