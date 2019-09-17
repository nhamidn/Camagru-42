<?php
  session_start();
  if (empty($_SESSION[username]))
  {
?>

<header class="card heighmin" id="myheader">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost/" style="color: #ffc107;-webkit-text-stroke-width: thin">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation" onclick="toggle_btn()">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <?php if ($_SESSION[page] === "public" || $_SESSION[page] === "reset") { ?>
        <li class="nav-item active">
          <?php echo '<a class="nav-link" href="/register.php">Register</a>';?>
        </li>
        <li class="nav-item active">
          <?php echo '<a class="nav-link" href="/login.php">login</a>';?>
        </li>
      <?php } else { ?>
        <li class="nav-item active">
          <?php if ($_SESSION[page] === "login") echo '<a class="nav-link" href="/register.php">Register</a>';
                else if ($_SESSION[page] === "register") echo '<a class="nav-link" href="/login.php">login</a>'; ?>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>
</header>
<script type="text/javascript "src="js\button.js"></script>
<?php }
else if (!empty($_SESSION[username]))
{
?>
<header class="card heighmin" id="myheader">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost/" style="color: #ffc107;-webkit-text-stroke-width: thin">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation" onclick="toggle_btn()">
    <span class="navbar-toggler-icon"></span>
  </button>
  <script type="text/javascript "src="../js/button.js"></script>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="../camera.php">Camera</a>';?>
      </li>
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="../index.php">Explorer</a>';?>
      </li>
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="../control/logout.php?token=' . $_SESSION[logout] . '">Disconnect</a>';?>
      </li>
      <?php
      if ($_SESSION[page] == "profile") {
        ?>
        <li class="nav-item active">
          <?php echo '<a class="nav-link" href="../settings.php">Edit Info</a>';?>
        </li>
        <?php
      }
      ?>
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="../users/profile.php">' . $_SESSION[username] . '</a>'; ?>
      </li>
    </ul>
  </div>
</nav>
</header>
<?php } ?>
