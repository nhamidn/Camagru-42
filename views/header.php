<?php
  session_start();
  if (empty($_SESSION[username]))
  {
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost/">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation" onclick="toggle_btn()">
    <span class="navbar-toggler-icon"></span>
  </button>
  <script type="text/javascript "src="js\button.js"></script>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <?php if ($_SESSION[page] === "login") echo '<a class="nav-link" href="/register.php">Register</a>';
                else if ($_SESSION[page] === "register") echo '<a class="nav-link" href="/login.php">login</a>'; ?>
        </li>
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
  <script type="text/javascript "src="js\button.js"></script>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="#">Explorer</a>';?>
      </li>
      <li class="nav-item active">
        <?php echo '<a class="nav-link" href="#">' . $_SESSION[username] . '</a>';?>
      </li>
    </ul>
  </div>
</nav>
</header>
<?php } ?>
