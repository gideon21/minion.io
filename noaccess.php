<?php require_once("includes/startSession_inc.php");
include("includes/header_inc.php");
include("includes/navigation_inc.php");
?>

<div class="g1-container">
  <?php
  echo '<h2 class="g-minion-c">Minions Club</h2>';
  ?>
  <div class="form-content">

 <?php
 // Make sure the user is logged in before going any further.
 // This shows you the you can't get any further if you have no session set

  if (!isset($_SESSION['minion_id'])) {
      echo '<h2>ACCESS DENIED</h2>';

    echo '<p class="login">Please <a href="login.php">log in</a> to access your profile.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['minion_name'] . '. <a href="logout.php">Log out</a>.</p>');
    echo('<p>You are more than welcome to be here, as this site is secured by sessions and cookies<p>
        <p>Even if you accidentally close your browser, the cookie should let you back in until you <strong>logout</strong></p>');
  }

?>
</div>
</div>
<?php include("includes/footer_inc.php"); ?>
