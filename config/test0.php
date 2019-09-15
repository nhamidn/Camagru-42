<?php
include 'database.php';
try {
  // Connect to Mysql server
  $dbh = new PDO("mysql:host=127.0.0.1;port=3306", "root", "tiger");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "connected successfully<br>";
} catch (PDOException $e) {
  echo $e->getMessage();
}
// phpinfo();
 ?>
