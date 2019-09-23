<?php
	session_start();
	include './config/database.php';
	$_SESSION[page] = "camera";
	if (empty($_SESSION[username]))
		header("Location: ../login.php?status=Please login to access this page");
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $dbh->prepare('SELECT * FROM posts WHERE username = :uname ORDER BY id DESC');
		$query->bindParam(':uname', $_SESSION[username], PDO::PARAM_STR);
		$query->execute();
		// $data = array();
		// while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
		// 	print_r($data['picture']);
		// 	echo "   /   ";
		// }
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
		<div id="page-content" class="card border-0 justify-content-center">
			<div class="parent-container d-flex px-md-4">
				<div class="container card bg-light">
					<div class="row py-md-4">
					<div class="col-md-6">
					<video class="img-fluid border border-dark" id="video"></video>
					<br/>
					<hr>
					<button type="button"  id="startbutton" class="btn btn-sm btn-primary mt-auto" disabled>Take Picture</button><br/><br/>
					<div class="input-group">
  					<div class="custom-file">
    					<input type="file" disabled accept="image/*" class="custom-file-input" id="imginput" onclick="clear();" onchange="return ShowImagePreview(this.files);"/>
    					<label class="custom-file-label" for="inputGroupFile01" style="font-size:1vw;">Choose file</label>
  					</div>
					</div>
					<hr>
					<div class="row justify-content-center">
						<div>
							<input id="1" type="radio" name="img" value="1" onclick="stickclick(this.value, this.id)">
							<img class="img-fluid" src="stickers/1.png" style="max-width:30px"></img>
						</div>
						<div>
							<input id="2" type="radio" name="img" value="2" onclick="stickclick(this.value, this.id)">
							<img class="img-fluid" src="stickers/2.png" style="max-width:30px"></img>
						</div>
						<div>
							<input id="3" type="radio" name="img" value="3" onclick="stickclick(this.value, this.id)">
							<img class="img-fluid" src="stickers/3.png" style="max-width:30px"></img>
						</div>
						<div>
							<input id="4" type="radio" name="img" value="4" onclick="stickclick(this.value, this.id)">
							<img class="img-fluid" src="stickers/4.png" style="max-width:30px"></img>
						</div>
 				</div>
					<br/>
					<br/>
					</div>
					<div class="col-md-6">
						<img id="camwithstick" class="imgoncam img-fluid" src="http://10.12.7.13/stickers/1.png" alt="sticker" style="position:absolute;width:30%;height:auto;display:none">
						<canvas class="img-fluid border border-dark" id="canvas"></canvas>
						<br/>
						<hr>
						<form class="uploadform" action="control/upload.php" method="post">
							<input id="monatge" name="montage" type="hidden"/>
							<input id="filter" name="filter" type="hidden"/>
							<button class="btn btn-success" id="upload" disabled>Submit</button>
						</form>
					</div>
			</div>
	</div>

	<div class="container card bg-light">
		<div class="row py-md-4">
			<?php
			$data = array();
			while ($data = $query->fetch(PDO::FETCH_ASSOC)) {0
				?>
				<div class="col-md-6 bg-light">
					<img class="img-fluid border border-dark" <?php echo "src='./images/".$data['picture'].".png'" ?> ></img>
					<form class="" action="control/delete.php" method="post">
						<input id="monatge"<?php echo "value='".$data['picture']."'" ?> value="" name="montage" type="hidden"/>
						<button type="submit" class="btn btn-danger btn-block rounded-0">Delete</button>
					</form>

				</div>
				<?php
			}
			 ?>

		</div>
</div>





</div>
		</div>
		<script type="text/javascript" src="cam.js"></script>
		<script type="text/javascript">
    function ShowImagePreview(files) {
			if(!(window.File && window.FileReader && window.FileList && window.Blob)) {
      	return false;
    	}
      var file = files[0];
			if(!(/image/i).test(file.type)){
				return false;
			}
      reader = new FileReader();
      reader.onload = function(event){
        var img = new Image;
        img.onload = UpdatePreviewCanvas;
        img.src = event.target.result;
      }
      reader.readAsDataURL(file);
		}


		function UpdatePreviewCanvas()
		{
    var img = this;
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext( '2d' );

    var world = new Object();
    world.width = 1024;
    world.height = 768;
    //----------------- calculate the value of scaling --------

    var WidthDif = img.width - world.width;
    var HeightDif = img.height - world.height;
    var Scale = 0.0;
    if( WidthDif > HeightDif ) {
      Scale = world.width / img.width;}
    else {
        Scale = world.height / img.height;}
    if(Scale > 1)
        Scale = 1;
    //----------------- calculate the width and height of the image --------
    var UseWidth = Math.floor( img.width * Scale );
    var UseHeight = Math.floor( img.height * Scale );


    //----------------- center the image inside the canvas -----------------
    var x = Math.floor( ( world.width - UseWidth ) / 2 );
    var y = Math.floor( ( world.height - UseHeight ) / 2 );
	 	context.clearRect(0, 0, canvas.width, canvas.height);
		context.fillStyle = "white";
		context.fillRect(0, 0, canvas.width, canvas.height);
    context.drawImage(img, x, y, UseWidth, UseHeight);
		document.getElementById("camwithstick").style.display = "block";
		document.getElementById("upload").disabled = false;
		document.getElementById('monatge').value = canvas.toDataURL('image/png');
		// clear();
	}
	function clear(){
		console.log(document.getElementById("imginput").value);
		document.getElementById("imginput").value = "";
	}
    </script>
		<script type="text/javascript">
			function stickclick(stick, id)
			{
				if (id == stick) {
					document.getElementById("startbutton").disabled = false;
					document.getElementById("imginput").disabled = false;
					if (stick == "1" || stick == "2" || stick == "3" || stick == "4") {
						document.getElementById("camwithstick").src = "http://10.12.7.13/stickers/"+stick+".png";
					}
					document.getElementById('filter').value = stick;
				}
			}
		</script>

		<?php include_once "views/footer.php"; ?>
	</body>
	<!-- <div class="col-md-6 card">
		<img class="img-fluid border border-dark" src="./images/4eb887c4f8800e470ae100529f8d2159.png"></img>
	</div>
	<div class="col-md-6 card">
		<img class="img-fluid border border-dark" src="./images/cde59b41437f1441967e3f6398049c70.png"></img>
	</div> -->
</html>
