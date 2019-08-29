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
  echo "Database created successfully<br>";
  } catch (PDOException $e) {
    echo "ERROR CREATING DB: \n".$e->getMessage()."\nAborting process<br>";
    // die();
  }
  // CREATE TABLES
try {
  // Connect to DATABASE
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE TABLE `users` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `token` VARCHAR(255) NOT NULL,
        `verified` VARCHAR(1) NOT NULL DEFAULT 'N'
      )";
  $dbh->exec($sql);
  echo "USERS table created !<br>";
  $sql = null;
  $sql = "CREATE TABLE `posts` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL,
        `picture` VARCHAR(255) NOT NULL
      )";
  $dbh->exec($sql);
  echo "PICTURES table created !<br>";
  $sql = null;
  $sql = "CREATE TABLE `comments` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL,
        `picture_id` VARCHAR(255) NOT NULL,
        `comment` VARCHAR(255) NOT NULL
      )";
  $dbh->exec($sql);
  echo "COMMENTS table created !<br>";
  $sql = null;
  $sql = "CREATE TABLE `likes` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL,
        `picture_id` VARCHAR(255) NOT NULL
      )";
  $dbh->exec($sql);
  echo "COMMENTS table created !<br>";
  $sql = null;
  } catch (PDOException $e) {
    echo "ERROR CREATING TABLES :".$e->getMessage()."<br>";
  }
?>
