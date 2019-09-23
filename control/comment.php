<?php
  session_start();
  include '../config/database.php';
  if (empty($_SESSION[username])) {
    header("Location: ../login.php?status=Please login to make comments and likes");
    exit();
  }
  if(!empty($_POST['cpicture']) and !empty($_POST['ccontent'])){
    if (!empty($_SESSION[username])) {
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
          try {
            $query = $dbh->prepare("SELECT * FROM posts WHERE picture = :cpicture");
            $query->bindParam(':cpicture', $_POST['cpicture'], PDO::PARAM_STR);
            $query->execute();
            $infos = array();
            $infos = $query->fetch(PDO::FETCH_ASSOC);
            try {
              $query = $dbh->prepare("SELECT * FROM users WHERE username = :uname");
              $query->bindParam(':uname', $infos['username'], PDO::PARAM_STR);
              $query->execute();
              $mailinfos = array();
              $mailinfos = $query->fetch(PDO::FETCH_ASSOC);


              // Send mail notification

              $subject = "User Notification";
              $headers = 'From: <nhamid@student.1337.ma>';
              $message = 'Hello ' . $mailinfos['username'] . ", " . $_SESSION[username] . ' has just left a comment on one of your pictures.';
              mail($mailinfos['email'], $subject, $message, $headers);

              //-----------------------

            } catch (PDOException $e) {
              echo 'Error: '.$e->getMessage();
              exit();
            }
          } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
            exit();
          }
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
  $query = $dbh->prepare('SELECT * FROM posts WHERE username = :uname ORDER BY id DESC');
  $query->bindParam(':uname', $_SESSION[username], PDO::PARAM_STR);
  $query->execute();
} catch (PDOException $e) {
  echo 'Error: '.$e->getMessage();
  exit();
}?>


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
            <button name="<?php echo $data['picture'];?>" onclick="comment(this.name)" class="btn btn-warning" style="color:white">comment</button>
            <br/>

        </div>
        <div class="mt-2" id="comment_list">
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
            <hr style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
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
