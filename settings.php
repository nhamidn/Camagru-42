<?php
	session_start();
	include './config/database.php';
	// if(session_status() == PHP_SESSION_ACTIVE)
	// 	session_regenerate_id();
  $_SESSION['page'] = "settings";
	if (empty($_SESSION['username']))
		header("Location: ./index.php");
  	// include_once "views/header.php";
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $dbh->prepare('SELECT * FROM users WHERE username = :uname');
		$query->bindParam(':uname', $_SESSION['username'], PDO::PARAM_STR);
		$query->execute();
		$data = array();
		$data = $query->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo 'Error: '.$e->getMessage();
		exit();
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
		 	<form action="/control/settings.php" method="post">
				<div class="form-group">
				 	<label for="InputUname">New Username</label>
				 	<input type="text" class="form-control" name="nuname" id="exampleInputEmail1" placeholder="Enter Username">
			 	</div>
        <div class="form-group">
				 	<label for="InputEmail">New Email address</label>
				 	<input type="email" class="form-control" name="nemail" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email">
			 	</div>
			 	<button type="submit" class="btn btn-warning" style="color: white">Submit</button>
				<button type="button" class="btn btn-danger" onclick="window.location='password.php'" style="color: white">Change your password</button>
		 	</form>
			<hr>
			<div class="custom-control custom-switch">
  			<input type="checkbox" class="custom-control-input" id="customSwitches" onclick="notification()">
  			<label class="custom-control-label" for="customSwitches">Email Notifications</label>
			</div>
			</div>
		</div>
		</div>
		<?php include_once "views/footer.php"; ?>
  </body>
	<script type="text/javascript">
	<?php if ($data['notification'] == 'Y') {
	echo "document.getElementById('customSwitches').checked = true;";
	} else echo "document.getElementById('customSwitches').checked = false;";?>
	function notification() {
	  var checkBox = document.getElementById("customSwitches");
		var notification;
	  if (checkBox.checked == true){
			notification = "Y";
	  } else {
			notification = "N";
	  }
		var xhttp = new XMLHttpRequest();
		var params = "notification=" + notification;
		xhttp.open('POST', 'http://localhost/control/notification.php');
		xhttp.withCredentials = true;
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send(params);
	}
	</script>
</html>
