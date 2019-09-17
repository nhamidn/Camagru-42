<?php
session_start();
// if(session_status() == PHP_SESSION_ACTIVE)
//   session_regenerate_id();
if (empty($_SESSION[username]))
  header("Location: ../login.php?status=Please login to access this page");
$_SESSION[page] = "profile";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Camagru Profile</title>
    <style media="screen">
		html, body {
		  margin: 0;
		  height: 100%;
		}
		#page-content {
		flex: 1 0 auto;
		}
    .heighmin {
      min-height:58px;
    }
    .heighminp {
      min-height:258px;
    }
    @media only screen and (min-width: 992px) {
      .heighminp {
        min-height:58px;
      }
    }
    @media only screen and (max-width: 992px) {
      .heighminp {
        min-height:258px;
      }
    }
		</style>
  </head>
  <body class="d-flex flex-column">
    <?php include_once "../views/header.php"; ?>
    <div id="page-content">
			<!-- <div id="justify">
			<div class="card card-body col-md-6 mb-4 bg-light" >
		 	<form action="/control/login.php" method="post">
				<div class="form-group">
				 	<label for="InputUname">Username</label>
				 	<input type="text" class="form-control" name="luname" id="exampleInputEmail1" placeholder="Enter Username" required>
			 	</div>
			 	<div class="form-group">
				 	<label for="InputPassword">Password</label>
				 	<input type="password" class="form-control" name="lpass" id="exampleInputPassword1" placeholder="Password" required>
			 	</div>
			 	<button type="submit" class="btn btn-warning" style="color: white">Log in</button>
		 	</form>
			<br>
			<medium>Forgot password ? <a href="./reset.php">Reset it</a></medium>
			</div>
		</div> -->
		</div>
    <?php include_once "../views/footer.php"; ?>
  </body>
</html>
