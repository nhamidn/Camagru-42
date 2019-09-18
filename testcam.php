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
    margin-left: auto;
    margin-right: auto;
    min-width: 90%;
    align-items: center;
		}
    #justify {
      width: 100%;
      overflow: hidden;
      padding: 10px 0;
      justify-content: center;
      display: flex;
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
      .col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 100%;
        max-width: 100%;
      }
      .mypics {
        margin-top: 20px;
      }
    }
		</style>
	</head>
	<body class="d-flex flex-column justify-content-center">
		<?php include_once "views/header.php"; ?>
		<div id="page-content" style="background:red;max-width:90%" class="card border-0 justify-content-center">
      <div class="row" style="min-width:100%">
        <div class="col-sm-6" style="background-color:yellow;">
          <div id="justify">
            <div class="video_player">
              <video id="video"></video>
              <br/>
              <button class="btn btn-success" id="startbutton">Take Picture</button>
            </div>
          </div>
          <br/>
          <div id="justify">
            <div class="demo">
              <canvas id="canvas"></canvas>
              <br/>
              <button class="btn btn-success" id="submitbutton">Submit</button>
            </div>
            <br/>
          </div>
        </div>
        <div class="col-sm-6 mypics" style="background-color:orange;">50%</div>
      </div>

          <!-- <video id="video"></video>
          <button id="startbutton">Prendre une photo</button>
          <canvas id="canvas"></canvas>
          <script type="text/javascript" src="cam.js">
          </script> -->


		</div>
    <script type="text/javascript" src="cam.js"></script>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
