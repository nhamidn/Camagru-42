<?php
  session_start();
  include '../config/database.php';
  if (empty($_SESSION[username])) {
    ?>
    <?php include_once "../views/header.php"; ?>
    <div id="errtext" class="justify-content-center align-self-center" style="text-align:center;padding: 10px 0; color: red; -webkit-text-stroke-width: thin;">
					Please login or create an account to like and comment picture  !
		</div>
    <div id="page-content" class="card border-0 justify-content-center">
			<div id="justify">
			<div class="card card-body col-md-6 mb-4 bg-light">
		 	<form action="/control/login.php" method="post">
				<div class="form-group">
				 	<label for="InputUname">Username</label>
				 	<input type="text" class="form-control" name="luname" id="exampleInputEmail1" placeholder="Enter Username" required>
			 	</div>
			 	<div class="form-group">
				 	<label for="InputPassword">Password</label>
				 	<input type="password" class="form-control" name="lpass" id="exampleInputPassword1" placeholder="Password" required>
			 	</div>
			 	<button type="submit" class="btn btn-warning" style="color: white">Log in</button>
				<button type="button" class="btn btn-danger" onclick="recover()" style="color: white">Reset your password</button>
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
		 	</form>
			</div>
		</div>
		</div>
    <?php include_once "../views/footer.php"; ?>
    <?php
    exit();
  }
  if(!empty($_POST['cpicture']) && !empty($_POST['ccontent'])) {
    // $comm = $_POST['ccontent']
    // $len = $comm;
    if (!empty($_SESSION[username]) && strlen($_POST['ccontent']) <= 255) {
      try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $dbh->prepare('SELECT COUNT(*) FROM posts WHERE picture = :cpic');
        $query->bindParam(':cpic', $_POST['cpicture'], PDO::PARAM_STR);
        $query->execute();
      } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit();
      }
      if ($query->fetchColumn()) {
        try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = $dbh->prepare("INSERT INTO comments (username, picture_id, comment) VALUES (:cuname, :cpicture, :content)");
          $query->bindParam(':cuname', $_SESSION[username], PDO::PARAM_STR);
          $query->bindParam(':cpicture', $_POST['cpicture'], PDO::PARAM_STR);
          $query->bindParam(':content', htmlspecialchars($_POST['ccontent']), PDO::PARAM_STR);
          $query->execute();
        } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit();
        }
      }

    }
  }

?>
<?php
try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbh->prepare('SELECT * FROM posts ORDER BY id DESC');
  $query->execute();
} catch (PDOException $e) {
  echo 'Error: '.$e->getMessage();
  exit();
}
?>

<?php include_once "../views/header.php"; ?>
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
        <div class="card card-body col-md-6 bg-light">
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
              $isliker->bindParam(':liker', $_SESSION[username], PDO::PARAM_STR);
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
  <?php } ?>
</div>
<?php include_once "./views/footer.php"; ?>
