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
		.stickers {
			justify-content: center;
      display: flex;
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
							<img id="imgvideo" class="imgoncam" src="http://10.12.7.13/stickers/1.png" alt="sticker" style="max-width:100px; max-height:100px; position:absolute; margin-top: 20px; margin-left:10px;display:none">
            	<video id="video"></video>
              <br/>
              <button class="btn btn-success" id="startbutton">Take Picture</button>
              <br/>
              <br/>
              <!-- <input type="file" name="fileToUpload"> -->
              <!-- <input type="file" accept="image/*" onchange="loadFile(event)"> -->
              <input type="file" accept="image/*" onchange="return ShowImagePreview(this.files);" />
							<br/>
							<br/>
							<div class="stickers" style="background:red;min-height:30px">
								<ul class="list-group list-group-horizontal">
  								<li class="list-group-item" id="1" onclick="stickclick(this.id)">
										<img src="http://10.12.7.13/stickers/1.png" class="img-fluid" alt="quixote" style="max-width:30px">
									</li>
  								<li class="list-group-item" id="2" onclick="stickclick(this.id)">
										<img src="http://10.12.7.13/stickers/2.png" class="img-fluid" alt="quixote" style="max-width:30px">
									</li>
  								<li class="list-group-item" id="3" onclick="stickclick(this.id)">
										<img src="http://10.12.7.13/stickers/3.png" class="img-fluid" alt="quixote" style="max-width:30px">
									</li>
									<li class="list-group-item" id="4" onclick="stickclick(this.id)">
										<img src="http://10.12.7.13/stickers/4.png" class="img-fluid" alt="quixote" style="max-width:30px">
									</li>
								</ul>
							</div>
            </div>
          </div>

          <div id="justify">
            <div class="demo">
              <!-- <img id="output"/> -->
							<img id="camwithstick" class="imgoncam" src="http://10.12.7.13/stickers/3.png" alt="sticker" style="max-width:100px; max-height:100px; position:absolute; margin-top: 20px; margin-left:10px;display:none">
              <canvas id="canvas"></canvas>
              <br/>
              <button class="btn btn-success" id="submitbutton" disabled>Submit</button>
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
    <!-- <script>
      var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('canvas');
          output.width = 320;
          output.getContext('2d').drawImage(reader.result, 0, 0, width, height);
          // output.src = reader.result;
        };
        // reader.readAsDataURL(event.target.files[0]);
      };
    </script> -->






    <script type="text/javascript">
    function ShowImagePreview(files)
    {
			if(!(window.File && window.FileReader && window.FileList && window.Blob))
    	{
      	return false;
    	}

    // if( typeof FileReader === "undefined" )
    // {
    //     alert( "Filereader undefined!" );
    //     return false;
    // }
      var file = files[0];
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
		// var stick = document.getElementById('camwithstick');
    var context = canvas.getContext( '2d' );

    var world = new Object();
    world.width = canvas.offsetWidth;
    world.height = canvas.offsetHeight;
    // console.log(world.width);
    // console.log(world.height);

    canvas.width = world.width;
    canvas.height = world.height;
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



		if (UseWidth < world.width) {
			var margin = (world.width - UseWidth) - 20;
			document.getElementById("camwithstick").style.marginLeft = margin+"px";
		}
		if (UseHeight < world.height) {
			var margin = (world.height - UseHeight) - 20;
			document.getElementById("camwithstick").style.marginTop = margin+"px";
		}
    //----------------- center the image inside the canvas -----------------
    var x = Math.floor( ( world.width - UseWidth ) / 2 );
    var y = Math.floor( ( world.height - UseHeight ) / 2 );
		document.getElementById("camwithstick").style.display = "block";
    context.drawImage( img, x, y, UseWidth, UseHeight );
}
    </script>


    <script type="text/javascript" src="cam.js"></script>
		<script type="text/javascript">
			function stickclick(stick)
			{
				document.getElementById("imgvideo").style.display = "block";
				document.getElementById("imgvideo").src = "http://10.12.7.13/stickers/"+stick+".png";
				document.getElementById("camwithstick").src = "http://10.12.7.13/stickers/"+stick+".png";
				console.log(stick);
			}
		</script>
		<?php include_once "views/footer.php"; ?>
	</body>
</html>
