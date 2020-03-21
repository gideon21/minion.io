<?php 
require_once("includes/startSession_inc.php");
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
      

  // Connect to the database
  require_once("includes/connectvars_inc.php");
  //echo DB_HOST, DB_USER ,DB_PASSWORD, DB_NAME;
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the user data from MySQL - This can be tested in PHP my admin before you hardcode it
  $query = "SELECT minion_id, minion_name, picture FROM minionmates WHERE minion_name IS NOT NULL ORDER BY recruited DESC LIMIT 10";
  // Pay attention to the syntax and structure, this is easily modified

  $data = mysqli_query($dbc, $query);
  //Run the query!

  // Loop through the array of user data, formatting it as HTML

 //Start the HTML for a table, but outside of the main loop that brings the results back from the database
echo ('<h2>Welcome back ' . $_SESSION['minion_name'] . '</h2>');
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) {
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
    
      echo '<td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['minion_name'] . '" /><br><button><a href="delete_record.php">Delete item</a></button></td>';
    }// So if we can find a minion Record, their mugshot will be shown by default

    else
    {
      echo '<td><img src="' . MM_UPLOADPATH . 'profile1.png' . '" alt="' . $row['minion_name'] . '" /><br><button><a href="delete_record.php">Delete item</a></button></td>';
      echo '<br>';
    }// This bit of code puts in a default image if there is no profile picture

    if (isset($_SESSION['minion_id']))
    {
      echo '<td><a href="minion_profile.php?minion_id=' . $row['minion_id'] . '">' . $row['minion_name'] . '</a></td></tr>';
    }// If we are logged in, this generates a clickable link that takes you through to their edit profile page
    else
    {
    echo '<td>' . $row['minion_name'] . '</td></tr>';//Shows you the minion name
  }
  }
  echo '</table>';
  echo '</div>';
        

  mysqli_close($dbc);
        

    echo ' <div class="main-content">';
    // Shows logged in user ($_SESSION['minion_name'])
    echo('<p class="login">You are logged in as ' . $_SESSION['minion_name'] . '. <a href="logout.php">Log out</a>.</p>');
    echo('<p>You are more than welcome to be here, as this site is secured by sessions and cookies<p>
        <p>Even if you accidentally close your browser, the cookie should let you back in until you <strong>logout</strong></p>');
      
      echo '</div>';
  }
      ?>
          
          </div>
</div>
    
    <?php include("includes/footer_inc.php"); ?>