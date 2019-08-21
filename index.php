<?php
	session_start();
	// if(session_status() == PHP_SESSION_ACTIVE)
  //   session_regenerate_id();
	// session_regenerate_id();
	$_SESSION[page] = "public";
	// $_SESSION[username] = null;
	// echo session_id();
	// if (empty($_SESSION[username]))
	// 	header('Location: /login.php');
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
		<title>Camagru</title>
		<style media="screen">
		html, body {
			margin: 0;
			height: 100%;
		}
		#page-content {
		flex: 1 0 auto;
		}
		</style>
	</head>
	<body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div id="page-content">

		</div>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
