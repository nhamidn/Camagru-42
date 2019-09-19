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
		.row {
			min-width: 100%;
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
		@media (max-width: 1000px) {
			.hello {

    		flex: 0 0 50%;
    max-width: 50%;
}
}
		</style>
	</head>
	<body class="d-flex flex-column">
		<?php include_once "views/header.php"; ?>
		<div id="page-content" style="background:red" class="card border-0 justify-content-center">
			<div class="parent-container d-flex">
				<div class="container bg-danger">
			<div class="row">
					<div class="col-md-6">
					<video class="img-fluid " id="video"></video>
					<br/>
					<button type="button"  id="startbutton" class="btn btn-sm btn-primary mt-auto">Get started</button><br/><br/>
					</div>
					<div class="col">
					<canvas class="img-fluid" id="canvas"></canvas>
					</div>
			</div>
	</div>

	<div class="container bg-primary">
			<div class="row">
					<div class="col">
							Container Right
					</div>
			</div>
	</div>
</div>
		</div>
		<script type="text/javascript" src="cam.js"></script>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
