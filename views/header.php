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
  <script type="text/javascript">
  function toggle_btn() {
    var nav = document.getElementById("navbarNav");
    if (nav.className === "collapse navbar-collapse") {
      nav.className = "collapse.show navbar-collapse";
    } else {
      nav.className = "collapse navbar-collapse";
    }
  }
  </script>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Login</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Register</a>
      </li>
    </ul>
  </div>
</nav>
</header>
<?php } ?>
