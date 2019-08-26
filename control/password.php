<?php
session_start();
include '../config/database.php';
if (empty($_POST["token"])) {
  if (empty($_SESSION[username])) {
    header ("Location: /index.php");
  }
}
?>
