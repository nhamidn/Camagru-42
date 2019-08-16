function toggle_btn() {
  var nav = document.getElementById("navbarNav");
  if (nav.className === "collapse navbar-collapse") {
    nav.className = "collapse.show navbar-collapse";
  } else {
    nav.className = "collapse navbar-collapse";
  }
}
