<?php
	session_start();
	// if(session_status() == PHP_SESSION_ACTIVE)
	// 	session_regenerate_id();
  $_SESSION[page] = "register";
	if (!empty($_SESSION[username]))
		header("Location: ./index.php");
  	// include_once "views/header.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Camagru register</title>
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
		</style>
  </head>
  <body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div class="justify-content-center align-self-center" style="text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;">
				<?php if ($_GET[error]) echo $_GET[error]; ?>
		</div>
		<div id="page-content" class="card border-0 justify-content-center">
			<div id="justify">
			<div class="card card-body col-md-6 mb-4 bg-light" >
		 	<form action="/control/register.php" method="post">
			 	<div class="form-group">
				 	<label for="InputUname">Username</label>
				 	<input type="text" class="form-control" name="runame" id="exampleInputUserName" placeholder="Enter Username" required>
			 	</div>
				<div class="form-group">
				 	<label for="InputEmail">Email address</label>
				 	<input type="email" class="form-control" name="remail" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email" required>
			 	</div>
			 	<div class="form-group">
				 	<label for="InputPassword">Password</label>
				 	<input type="password" class="form-control" name="rpass" id="exampleInputPassword" placeholder="Password" required>
			 	</div>
				<div class="form-group">
					<label for="InputPassword">Retype Password</label>
					<input type="password" class="form-control" name="rpass2" id="exampleInputPassword2" placeholder="Password" required>
				</div>
			 	<button type="submit" class="btn btn-warning" style="color: white">Register</button>
		 	</form>
			</div>
		</div>
		</div>
		<?php include_once "views/footer.php"; ?>
  </body>
</html>
