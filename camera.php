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
		<div id="page-content" style="background:red" class=" border-0 justify-content-center">
        <div class="row" id="main-side">
          <div class="col-8" style="background:white">


<form method="POST" action="storeImage.php">
<div class="row">
						<div class="col-md-6" style="background:yellow">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6" style="background:black">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button class="btn btn-success">Submit</button>
            </div>
						<!-- Configure a few settings and attach camera -->
						<script language="JavaScript">
						    Webcam.set({
						        width: 490,
						        height: 390,
						        image_format: 'jpeg',
						        jpeg_quality: 90
						    });

						    Webcam.attach( '#my_camera' );

						    function take_snapshot() {
						        Webcam.snap( function(data_uri) {
						            $(".image-tag").val(data_uri);
						            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
						        } );
						    }
						</script>

</div>
</form>


          </div>
          <div class="col-4" style="background:green">
            col-4
          </div>
        </div>
		</div>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
