<?php
	session_start();
	$_SESSION[page] = "public";
	$_SESSION[username] = "nhamid";
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
	</head>
	<body>
		<?php include_once "views/header.php"; ?>

	</body>
</html>
