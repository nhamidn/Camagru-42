function toggle_btn() {
  var nav = document.getElementById("navbarNav");
  var header = document.getElementById("myheader");
  if (nav.className === "collapse navbar-collapse") {
    nav.className = "collapse.show navbar-collapse";
    header.className = "card heighminp";
  } else {
    nav.className = "collapse navbar-collapse";
    header.className = "card heighmin";
  }
}
