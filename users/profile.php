<?php
session_start();
include '../config/database.php';
// if(session_status() == PHP_SESSION_ACTIVE)
//   session_regenerate_id();
if (empty($_SESSION[username]))
  header("Location: ../login.php?status=Please login to access this page");
$_SESSION[page] = "profile";
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

      <main style="margin-top:15px">
        <div class="container">


          <div class="row justify-content-center">
            <div class="card card-body col-md-6 bg-light">
              <img class="img-fluid border rounded-top" <?php echo "src='../images/".$data['picture'].".png'" ?> ></img>
              <form class="" action="../control/delete.php" method="post">
    						<input id="monatge"<?php echo "value='".$data['picture']."'" ?> value="" name="montage" type="hidden"/>
    						<button type="submit" class="btn btn-danger btn-block rounded-0 border">Delete</button>
    					</form>
              <form class="form-inline" role="form">
                <div class="form-group" style="width:80%">
                  <input class="form-control" style="width:100%" type="text" placeholder="Your comments" />
                </div>
                <div class="form-group" style="width:20%">
                  <button class="btn btn-white border" style="width:100%">Add</button>
                </div>
              </form>
            </div>
          </div>



        </div>
      </main>

      <?php } ?>

    </div>
    <?php include_once "../views/footer.php"; ?>
  </body>
</html>
