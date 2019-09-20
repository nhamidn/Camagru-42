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
					<button type="button"  id="startbutton" class="btn btn-sm btn-primary mt-auto">Take Picture</button><br/><br/>
					<!-- <input id="imginput" type="file" accept="image/*" onclick="clear();" onchange="return ShowImagePreview(this.files);" /> -->
					<div class="input-group">
  					<div class="custom-file">
    					<input type="file" accept="image/*" class="custom-file-input" id="imginput" onclick="clear();" onchange="return ShowImagePreview(this.files);"/>
    					<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
  					</div>
					</div>
					<br/>
					<br/>
					<!-- <div class="stickers fluid">
						<ul class="list-group list-group-horizontal fluid">
							<li class="list-group-item" id="1" onclick="stickclick(this.id)">
								<img src="http://10.12.7.13/stickers/1.png" class="img-fluid" alt="quixote" style="min-width:5px;max-width:30px">
							</li>
							<li class="list-group-item" id="2" onclick="stickclick(this.id)">
								<img src="http://10.12.7.13/stickers/2.png" class="img-fluid" alt="quixote" style="min-width:5px;max-width:30px">
							</li>
							<li class="list-group-item" id="3" onclick="stickclick(this.id)">
								<img src="http://10.12.7.13/stickers/3.png" class="img-fluid" alt="quixote" style="min-width:5px;max-width:30px">
							</li>
							<li class="list-group-item" id="4" onclick="stickclick(this.id)">
								<img src="http://10.12.7.13/stickers/4.png" class="img-fluid" alt="quixote" style="min-width:5px;max-width:30px">
							</li>
						</ul>
					</div> -->
					<br/>
					<br/>
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
		<script type="text/javascript">
    function ShowImagePreview(files) {
			if(!(window.File && window.FileReader && window.FileList && window.Blob)) {
      	return false;
    	}
      var file = files[0];
      reader = new FileReader();
      reader.onload = function(event){
        var img = new Image;
        img.onload = UpdatePreviewCanvas;
        img.src = event.target.result;
      }
			console.log("test");
      reader.readAsDataURL(file);
}


function UpdatePreviewCanvas()
{
    var img = this;
    var canvas = document.getElementById('canvas');
		// var stick = document.getElementById('camwithstick');
    var context = canvas.getContext( '2d' );

    var world = new Object();
    world.width = 520;
    world.height = 390;
    // console.log(world.width);
    // console.log(world.height);

    // canvas.width = world.width;
    // canvas.height = world.height;
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



		// if (UseWidth < world.width) {
		// 	var margin = (world.width - UseWidth) - 20;
		// 	document.getElementById("camwithstick").style.marginLeft = margin+"px";
		// }
		// if (UseHeight < world.height) {
		// 	var margin = (world.height - UseHeight) - 20;
		// 	document.getElementById("camwithstick").style.marginTop = margin+"px";
		// }
    //----------------- center the image inside the canvas -----------------
    var x = Math.floor( ( world.width - UseWidth ) / 2 );
    var y = Math.floor( ( world.height - UseHeight ) / 2 );
		// if (document.getElementById("imgvideo").style.display == "block") {
		//  document.getElementById("camwithstick").style.display = "block";
		//  document.getElementById("camwithstick").src = document.getElementById("imgvideo").src
	 // }
	 	context.clearRect(0, 0, canvas.width, canvas.height);
		context.fillStyle = "white";
		context.fillRect(0, 0, canvas.width, canvas.height);
    context.drawImage(img, x, y, UseWidth, UseHeight);
}
    </script>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
