<?php
include '../config/database.php';
session_start();
if (empty($_POST["runame"]) || empty($_POST["remail"]) || empty($_POST["rpass"]) || empty($_POST["rpass2"])) {
    header("Location: ../register.php?error=Please fill the form with a valid informations!");
    exit();
}
else {
  if (strcmp($_POST["rpass"], $_POST["rpass2"]) != 0) {
    header("Location: ../register.php?error=Passwords does not match !");
  } else {
    if (strlen($_POST["rpass"]) < 8)
      header("Location: ../register.php?error=Passwords must have a least lenght 8 !");
    else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\\!@#\$%\^&\*\[\]"\';:_\-<>\., =\+\/]).{8,}$/', $_POST["rpass"]))
    {
      header("Location: ../register.php?error=Passwords must have [0-9] [a-z] [A-Z] and special characters!");
    } else {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sth = $dbh->prepare('SELECT COUNT(*) FROM users WHERE username = :uname');
        $sth->bindParam(':uname', $_POST["runame"], PDO::PARAM_STR);
        $sth->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
      }
      if ($sth->fetchColumn()) {
        header("Location: ../register.php?error=Username already taken.");
        exit();
      }
      else {
        try {
          $sth = $dbh->prepare('SELECT COUNT(*) FROM users WHERE email = :reemail');
          $sth->bindParam(':reemail', $_POST["remail"], PDO::PARAM_STR);
          $sth->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
        }
        if ($sth->fetchColumn()) {
          header("Location: ../register.php?error=Email already associated with an existing account.");
          exit();
        }
      }
      $usern = $_POST["runame"];
      echo $usern;
      ?>
      <br>
      <?php
      $email = $_POST["remail"];
      echo $email;
      ?>
      <br>
      <?php
      $pass = $_POST["rpass"];
      $pass = hash(Whirlpool, $_POST["rpass"]);
      echo $pass;
      ?>
      <br>
      <?php
      echo 'Secure enough';
    }
  }
}

?>
