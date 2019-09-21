<?php
session_start();
// if(session_status() == PHP_SESSION_ACTIVE)
//   session_regenerate_id();
if (empty($_SESSION[username]))
  header("Location: ../login.php?status=Please login to access this page");
$_SESSION[page] = "profile";
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

    /* Base Styles */


		</style>
  </head>
  <body class="d-flex flex-column">
    <?php include_once "../views/header.php"; ?>
    <div id="page-content">
      <main>
        <div class="container">





        </div>
      </main>
    </div>
    <?php include_once "../views/footer.php"; ?>
  </body>
</html>
