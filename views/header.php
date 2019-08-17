<?php
  session_start();
  if(session_status() == PHP_SESSION_ACTIVE)
    session_regenerate_id();
  if (empty($_SESSION[username]))
  {
?>
<header class="card">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost/" style="color: #ffc107;-webkit-text-stroke-width: thin">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation" onclick="toggle_btn()">
    <span class="navbar-toggler-icon"></span>
  </button>
  <script type="text/javascript "src="js\button.js"></script>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <?php if ($_SESSION[page] === "public") { ?>
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
<?php }
else if (!empty($_SESSION[username]))
{
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost/">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation" onclick="toggle_btn()">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php if ($_SESSION[page] = "profile") {?>
  <script type="text/javascript "src="../js/button.js"></script>
<?php } else {?>
  <script type="text/javascript "src="js/button.js"></script>
<?php } ?>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="#">Camera</a>';?>
      </li>
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="#">Explorer</a>';?>
      </li>
      <!-- <form class='nav-item active' action='user/ft_disconnect.php' method='post'>
           <?php //echo '<a type='submit' class="nav-link" href="#">Disconnect</a>';?>
        <button type='submit'>Disconnect</button>
      </form> -->
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="../users/profile.php">' . $_SESSION[username] . '</a>';?>
      </li>
    </ul>
  </div>
</nav>
</header>
<?php } ?>