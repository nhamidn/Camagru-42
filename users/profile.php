<?php
session_start();
include '../config/database.php';
if (empty($_SESSION[username])) {
  header("Location: ../login.php?status=Please login to access this page");
  exit();
}
$_SESSION[page] = "profile";
try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbh->prepare('SELECT * FROM posts WHERE username = :uname ORDER BY id DESC');
  $query->bindParam(':uname', $_SESSION[username], PDO::PARAM_STR);
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
    <title>Camagru Profile</title>
    <style media="screen">
		html, body {
		  margin: 0;
		  height: 100%;
		}
		#page-content {
		flex: 1 0 auto;
		}
    .heighmin {
      min-height:58px;
    }
    .heighminp {
      min-height:258px;
    }
    @media only screen and (min-width: 992px) {
      .heighminp {
        min-height:58px;
      }
    }
    @media only screen and (max-width: 992px) {
      .heighminp {
        min-height:258px;
      }
    }


		</style>
  </head>
  <body class="d-flex flex-column">
    <?php include_once "../views/header.php"; ?>
    <div id="page-content" class="bg-white">

      <?php
      $data = array();
      while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>

      <main style="margin-top:15px" id="posts_list">
        <div class="container">


          <div class="row justify-content-center">
            <div class="card card-body col-md-6 bg-light">
              <img class="img-fluid border rounded-top" <?php echo "src='../images/".$data['picture'].".png'" ?> ></img>
              <form class="" action="../control/delete.php" method="post">
    						<input id="monatge"<?php echo "value='".$data['picture']."'" ?> value="" name="montage" type="hidden"/>
    						<button type="submit" class="btn btn-danger btn-block rounded-0 border">Delete</button>
    					</form>
              <div class="cardbox-comments mt-2">

                <textarea id="<?php echo $data['picture'];?>" class="form-control w-100 mb-2" placeholder="write a comment..." rows="1" style="resize: none;"></textarea>

                <button id="likebtn_<?php echo $data['picture'];?>" name="<?php echo $data['picture'];?>" onclick="like(this.name)" class="btn"><i class="fas fa-heart"></i></button>
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
    <script type="text/javascript">
    function comment(post)
    {
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
            document.getElementById("page-content").innerHTML = this.responseText;
            }
        };
        var params = "cpicture=" + post + "&ccontent=" + comment;
        xhttp.open('POST', 'http://localhost/control/comment.php');
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
    function like(post)
    {
      // console.log('likebtn_'+post);

      // var comment = document.getElementById(post).value;
      var str = post;
      // console.log(comment);
      if (str.trim().length == 0) {
        return false;
      }
      var xhttp = new XMLHttpRequest();

      var params = "lpicture=" + post;
      xhttp.open('POST', 'http://localhost/control/like.php');
      xhttp.withCredentials = true;
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);
      document.getElementById('likebtn_'+post).style.color = 'red';

    }
    </script>

    <?php include_once "../views/footer.php"; ?>
  </body>
</html>
