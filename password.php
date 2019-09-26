<?php
session_start();
include './config/database.php';
if (empty($_GET["token"])) {
  if (empty($_SESSION['username'])) {
    header ("Location: /index.php");
    exit();
  }
}
if (!empty($_GET["token"])) {
  if (!empty($_SESSION['username'])) {
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = $dbh->prepare("UPDATE users SET password = :rpass WHERE token = :rtoken");
      $query->bindParam(':user', $_SESSION['username'], PDO::PARAM_STR);
      $query->execute();
      $data = array();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      if ($_GET["token"] != $data['token']) {
        header("Location: ../index.php");
        exit();
      }
    } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit();
    }
  }
  try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $dbh->prepare('SELECT COUNT(*) FROM users WHERE token = :rtoken');
    $query->bindParam(':rtoken', $_GET["token"], PDO::PARAM_STR);
    $query->execute();
  } catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
    exit();
  }
  if (!$query->fetchColumn()) {
    header("Location: ../index.php");
  }
  $_SESSION['token'] = $_GET["token"];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Camagru login</title>
		<style media="screen">
		html, body {
		  margin: 0;
		  height: 100%;
		}
		#page-content {
		flex: 1 0 auto;
		}
		#justify {
  		width: 100%;
			min-height: 100%;
  		margin: 0 auto;
  		overflow: hidden;
  		padding: 10px 0;
  		align-items: center;
  		justify-content: center;
  		display: flex;
  		float: none;
		}
    .heighmin {
      min-height:58px;
    }
    .heighminp {
      min-height:218px;
    }
    @media only screen and (min-width: 992px) {
      .heighminp {
        min-height:58px;
      }
    }
    @media only screen and (max-width: 992px) {
      .heighminp {
        min-height:218px;
      }
    }
		</style>
  </head>


  <body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div id="errtext" class="justify-content-center align-self-center" style="text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;">
					<?php if (!empty($_GET['error'])) echo $_GET['error']; ?>
		</div>
		<div id="page-content" class="card border-0 justify-content-center">
			<div id="justify">
			<div class="card card-body col-md-6 mb-4 bg-light" <?php// if ($_GET[p] == "2") echo "style='display:none'";?>
		 	<form action="/control/password.php" method="post">
        <div class="form-group">
				 	<label for="InputPassword">New Password</label>
				 	<input type="password" class="form-control" name="rpass" id="exampleInputPassword1" placeholder="Password" required>
			 	</div>
			 	<div class="form-group">
				 	<label for="InputPassword">Confirm New Password</label>
				 	<input type="password" class="form-control" name="rpass2" id="exampleInputPassword2" placeholder="Password" required>
			 	</div>
			 	<button type="submit" class="btn btn-warning" style="color: white">Change Password</button>

		 	</form>
			</div>
		</div>
		</div>
		<?php include_once "views/footer.php"; ?>
  </body>
</html>
