<?php
	session_start();
	// if(session_status() == PHP_SESSION_ACTIVE)
	// 	session_regenerate_id();
  $_SESSION['page'] = "login";
	if (!empty($_SESSION['username']))
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
			min-height:98px;
		}
		@media only screen and (min-width: 992px) {
			.heighminp {
				min-height:58px;
			}
		}
		@media only screen and (max-width: 992px) {
			.heighminp {
				min-height:98px;
			}
		}
		</style>
		<?php
		if (!empty($_GET['p']) == "2") {
			?>
			<script type="text/javascript">
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						elem = document.getElementById("justify").innerHTML;
						document.getElementById("justify").innerHTML = this.responseText;
						}
				};
				xhttp.open("GET", "./reset.php", true);
				xhttp.send();
			</script>
			<?php
		} ?>
  </head>


  <body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div id="errtext" class="justify-content-center align-self-center" style="text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;">
					<?php if (!empty($_GET['status'])) echo $_GET['status']; ?>
		</div>
		<div id="page-content" class="card border-0 justify-content-center">
			<div id="justify">
			<div class="card card-body col-md-6 mb-4 bg-light">
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
				<button type="button" class="btn btn-danger" onclick="recover()" style="color: white">Reset your password</button>
				<script>
				var elem;
				function recover() {
				  var xhttp = new XMLHttpRequest();
				  xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
							elem = document.getElementById("justify").innerHTML;
							document.getElementById("errtext").innerHTML = "<div id='errtext' class='justify-content-center align-self-center' style='text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;'></div>";
				      document.getElementById("justify").innerHTML = this.responseText;
				      }
				  };
				  xhttp.open("GET", "./reset.php", true);
				  xhttp.send();
				}
				function login() {
					document.getElementById("errtext").innerHTML = "<div id='errtext' class='justify-content-center align-self-center' style='text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;'></div>";
					document.getElementById("justify").innerHTML = elem;
				}
				</script>
		 	</form>
			</div>
		</div>
		</div>
		<?php include_once "views/footer.php"; ?>
  </body>
</html>
