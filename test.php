<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Camagru login</title>
    <style media="screen">
    /* Sticky Footer Classes */

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
  /* margin: 0 auto; */
  overflow: hidden;
  padding: 10px 0;
  align-items: center;
  justify-content: center;
  display: flex;
  float: none;
}
    </style>
  </head>
  <body class="d-flex flex-column">
    <?php include_once "views/header.php"; ?>

  <div id="page-content">
    <div id="justify">
    <div class="card card-body col-md-6 mb-4 bg-light" >
    <form>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-warning" style="color: white">Log in</button>
    </form>
    </div>
    </div>
  </div>
  <?php include_once "views/footer.php"; ?>

</body>

</html>
