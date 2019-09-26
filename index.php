<?php
	session_start();
	include './config/database.php';
	$_SESSION['page'] = "public";
	try {
	  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $dbh->prepare('SELECT COUNT(*) FROM posts ORDER BY id DESC LIMIT 5');
	  $query->execute();
		$postlen = $query->fetchColumn();

	  $query = $dbh->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT 5');
	  $query->execute();
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
		<title>Camagru</title>
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
			<?php if (empty($_SESSION['username'])) {?>
			min-height:138px;
			<?php } else { ?>
			min-height:218px;
			<?php } ?>
		}
		@media only screen and (min-width: 992px) {
			.heighminp {
				min-height:58px;
			}
		}
		@media only screen and (max-width: 992px) {
			.heighminp {
				<?php if (empty($_SESSION['username'])) {?>
				min-height:138px;
				<?php } else { ?>
				min-height:218px;
				<?php } ?>
			}
		}
		</style>
	</head>
	<body id="body" class="d-flex flex-column">
		<?php include_once "./views/header.php"; ?>
		<div id="page-content" class="bg-white">
			<p class="text-center" style="color:#ffc107;margin-bottom: 0rem;font-size:2vw">GALLERY</p>
			<hr style="margin-top: 0rem;margin-bottom: 0.5rem;">

			<?php
			$data = array();
			while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
				?>

			<main style="margin-top:15px" id="posts_list">
				<div class="container">


					<div class="row justify-content-center">
						<div class="card card-body col-md-6 bg-light shadow">
							<p class="bg-light" style="color:black;margin-bottom: 0rem;margin-top: 0rem;font-size:1.5vw"><strong><?php echo $data['username']; ?></strong></p>
							<hr style="margin-top: 0rem;margin-bottom: 0.5rem;">

							<img class="img-fluid border rounded-top" <?php echo "src='../images/".$data['picture'].".png'" ?> ></img>
							<div class="cardbox-comments mt-2">

								<textarea id="<?php echo $data['picture'];?>" class="form-control w-100 mb-2" placeholder="write a comment..." rows="1" style="resize: none;"></textarea>
								<?php

								try {
									$newdbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
									$newdbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$like = $newdbh->prepare('SELECT COUNT(*) FROM likes WHERE picture_id = :lpicture');
									$like->bindParam(':lpicture', $data['picture'], PDO::PARAM_STR);
									$like->execute();
									$totallikes = $like->fetchColumn();
									$isliker = $newdbh->prepare('SELECT COUNT(*) FROM likes WHERE username = :liker AND picture_id = :lphoto');
									$isliker->bindParam(':liker', $_SESSION['username'], PDO::PARAM_STR);
									$isliker->bindParam(':lphoto', $data['picture'], PDO::PARAM_STR);
									$isliker->execute();
									$liker = $isliker->fetchColumn();
								} catch (PDOException $e) {
									echo 'Error: '.$e->getMessage();
									exit();
								}


								 ?>
								<button id="likebtn_<?php echo $data['picture'];?>" name="<?php echo $data['picture'];?>" onclick="like(this.name)" class="btn" <?php if ($liker) echo "style='color: red;'"; ?>><i id="counter_<?php echo $data['picture'];?>" class="fas fa-heart"> <?php if ($totallikes>0) {echo $totallikes;} ?> </i></button>
								<button name="<?php echo $data['picture'];?>" onclick="comment(this.name)" class="btn"><i class="fas fa-paper-plane"></i></button>
								<br/>
							</div>
						<div id="comment_list">
							<?php
							try {
								$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$com = $dbh->prepare('SELECT * FROM comments WHERE picture_id = :picture ORDER BY id DESC');
								$com->bindParam(':picture', $data['picture'], PDO::PARAM_STR);
								$com->execute();
							} catch (PDOException $e) {
								echo 'Error: '.$e->getMessage();
								exit();
							}
							$content = array();
							while ($content = $com->fetch(PDO::FETCH_ASSOC)) {
								?>
								<hr style="margin-top: 0.2rem;margin-bottom: 0.5rem;">
								<strong style="color:green"><?php echo $content['username'].": ";?></strong><?php  echo $content['comment'];  ?>
								<?php
							}
							?>
						</div>
						</div>
					</div>



				</div>
			</main>
			<br/>
			<?php } ?>

		</div>

			<nav aria-label="Page navigation example">
  			<ul class="pagination justify-content-center">
    			<li class="page-item" style="color:blue"><a id="precedent" class="page-link" onclick="previous();">Previous</a></li>
    			<li class="page-item" style="color:blue"><a class="page-link" onclick="next();">Next</a></li>
  			</ul>
			</nav>

		<?php include_once "./views/footer.php"; ?>
	</body>
	<script type="text/javascript">
	var page = 5;
	var total = <?php echo $postlen; ?>;
	function next() {
		var diff = total - page;
		var load;
		if (diff >= 5) {
			load = 5;
		} else {
			load = diff;
		}
		console.log(load);
		// var xhttp = new XMLHttpRequest();
		// xhttp.onreadystatechange = function() {
		// 	if (this.readyState == 4 && this.status == 200) {
		// 		document.getElementById("body").innerHTML = this.responseText;
		// 		}
		// };
		// var params = "number=" + page;
		// xhttp.open('POST', 'http://localhost/control/pagination.php');
		// xhttp.withCredentials = true;
		// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// xhttp.send(params);
	}

	function previous() {
		console.log("previous");
		console.log(page);
		if (page > 5)
			page -= 5;
		console.log(page);
	}

	function comment(post) {
		// console.log(post);
		var comment = document.getElementById(post).value;
		var str = comment;
		// console.log(comment);
		if (str.trim().length == 0) {
			document.getElementById(post).value = "";
			return false;
		}

		if (document.getElementById(post).value != "" && post != "") {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("body").innerHTML = this.responseText;
					}
			};
			var params = "cpicture=" + post + "&ccontent=" + comment;
			xhttp.open('POST', 'http://localhost/control/commentpublic.php');
			xhttp.withCredentials = true;
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(params);
			var xmail = new XMLHttpRequest();
			var paramsmail = "cpicture=" + post + "&ccontent=" + comment;
			xmail.open('POST', 'http://localhost/control/commentmail.php');
			xmail.withCredentials = true;
			xmail.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmail.send(paramsmail);
		}
		document.getElementById(post).value = "";

	}

	function like(post) {
		var str = post;
		if (str.trim().length == 0) {
			return false;
		}
		var node = document.getElementById('counter_'+post);
		var icon = document.getElementById('likebtn_'+post);
		var htmlContent;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200) {
				if (this.responseText === "like") {
					htmlContent = node.innerHTML.trim();
					htmlContent++;
					icon.style.color = 'red';
				} else if (this.responseText === "dislike"){
					htmlContent = node.innerHTML.trim();
					htmlContent--;
					icon.style.color = '';
				} else if (this.responseText === "not logged") {
					window.location.replace("http://localhost/login.php?status=Please login or create an account to like and comment picture !");
			}
			if (htmlContent > 0)
				node.innerHTML = " "+htmlContent+" ";
			else
				node.innerHTML = " ";
		}
		};
		var params = "lpicture=" + post;
		xhttp.open('POST', 'http://localhost/control/like.php');
		xhttp.withCredentials = true;
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send(params);


	}
	</script>
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
</html>
