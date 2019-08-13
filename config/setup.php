<?php
// Include of Database Informations
include 'database.php';
// CREATE DATABASE
try {
  // Connect to Mysql server
  $dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE DATABASE `".$DB_NAME."`";
  $dbh->exec($sql);
  echo "Database created successfully\n";
  } catch (PDOException $e) {
    //echo "ERROR CREATING DB: \n".$e->getMessage()."\nAborting process\n";
    echo "Database re-created successfully\n";
    $sql = "DROP DATABASE `".$DB_NAME."`";
    $dbh->exec($sql);
    $sql = "CREATE DATABASE `".$DB_NAME."`";
    $dbh->exec($sql);
    exit(-1);
  }
?>
