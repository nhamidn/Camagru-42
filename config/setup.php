<?php
// Include of Database Informations
include 'database.php';
// CREATE DATABASE
try {
  // Connect to Mysql server
  $dbh = new PDO("mysql:host=$HOST", $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE DATABASE `".$DB_NAME."`";
  $dbh->exec($sql);
  echo "Database created successfully\n";
  } catch (PDOException $e) {
    echo "ERROR CREATING DB: \n".$e->getMessage()."\nAborting process\n";
    // echo "Database re-created successfully\n";
    // $sql = "DROP DATABASE `".$DB_NAME."`";
    // $dbh->exec($sql);
    // $sql = "CREATE DATABASE `".$DB_NAME."`";
    // $dbh->exec($sql);
    // die();
  }
  // CREATE TABLES
  try {
    // Connect to DATABASE
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE `users` (
          `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` VARCHAR(50) COLLATE utf8_bin NOT NULL,
          `email` VARCHAR(100) COLLATE utf8_bin NOT NULL,
          `password` VARCHAR(255) COLLATE utf8_bin NOT NULL,
          `token` VARCHAR(50) NOT NULL,
          `verified` VARCHAR(1) NOT NULL DEFAULT 'N'
        )";
    $dbh->exec($sql);
    echo "USERS table created !\n";
    $sql = null;
    } catch (PDOException $e) {
      echo "ERROR CREATING TABLES\n";
    }
?>
