<?php
  //This is another utility page that you don't actually see visibly, but processes the data sent to it
  // If the user is logged in, delete the session vars to log them out
  session_start();
  if (isset($_SESSION['minion_id'])) {
    // Delete the session vars by clearing the $_SESSION array
    $_SESSION = array();

    // Delete the session cookie by setting its expiration to an hour ago (3600)
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Destroy the session
    session_destroy();
  }

  // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
  setcookie('minion_id', '', time() - 3600);
  setcookie('minion_name', '', time() - 3600);

  // Redirect to the home page-
 // This bit defines the home URL, so you can change that here quite simply if you don't want to go back to the index page
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  //This is the redirect in action
  header('Location: ' . $home_url);
?>
