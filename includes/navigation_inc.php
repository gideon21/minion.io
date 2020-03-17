<!-- Start navigation here -->
<div id="header">
    <nav class="g-nav">
        <ul class="g-ul">
            <li class="g-a"><a href="index.php">Home</a></li>
            <li class="g-b"><a href="login.php">Login</a></li>
              <li style="float:right"><a class="active" href="noaccess.php">My profile</a></li>
              <?php
              // isset Is just for checking if a value has been set, it's a boolean in disguise
              if (!isset($_SESSION['minion_id'])) {
              echo '<li class="g-c"><a href="register.php">Register</a></li>
              ';
            }// Therefore this link only appears if you are not logged in and haven't generated
              ?>

              <?php
              if (isset($_SESSION['minion_id'])) {
                  echo '<li><a href="logout.php" id="matchup">Dynamic Logout link based on being logged in</a></li>
                  ';
              }// This is the flipside to your statement, a logout button is Displayed if you are logged in and a session variable has been set
               // This mechanism can be extended to include any form of navigation you want dependent on the session being set
               // Like a custom dark mode or something interesting
              ?>
        </ul>
    </nav>
</div>
<!-- End of navigation -->
