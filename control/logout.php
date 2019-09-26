<?php
session_start();
if ($_GET['token'] != $_SESSION['logout']) {
  header ("Location: /index.php");
  exit();
} else if (empty($_GET['token'])) {
  header ("Location: /index.php");
  exit();
} else {
  $_SESSION['username'] = "";
  session_destroy();
  header ("Location: /index.php");
}
?>
