<?php
	session_start();
	$_SESSION[page] = "camera";
	if (empty($_SESSION[username]))
		header('Location: ./login.php');
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
    #main-side {
      max-width:100%;
      margin: 0 auto;
      min-height: 100%;
      background:blue;
    }
		</style>
	</head>
	<body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div id="page-content" style="background:red">
        <div class="row" id="main-side">
          <div class="col-8" style="background:white">
            col-8
          </div>
          <div class="col-4" style="background:green">
            col-4
          </div>
        </div>
		</div>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
