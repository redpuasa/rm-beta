<?php
// Show lockscreen if user locked the screen
if (isset($_SESSION["lockscreen"]) && $_SESSION["lockscreen"] == TRUE) {
  header("Location: " . LOCKSCREEN_PAGE);
}

// Show login page if user is not logged in
if (!isset($_SESSION['loggedIn'])) {
  header("Location: " . LOGIN_PAGE ."?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>