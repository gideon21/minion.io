<!-- Start navigation here -->
<div id="header">
    <nav class="g-nav">
        <ul class="g-ul">
           <li class="g-b"><a href="login.php">Login</a></li>
            <li class="g-a"><a href="index.php">Minions club</a></li>
              <?php
              // isset Is just for checking if a value has been set, it's a boolean in disguise
              if (!isset($_SESSION['minion_id'])) {
              echo '<li style="float:right"><a class="active" href="register.php">Register</a></li>
              ';
            }// Therefore this link only appears if you are not logged in and haven't generated
              ?>

              <?php
              if (isset($_SESSION['minion_id'])) {
                  echo '<li style="float:right"><a class="active" href="logout.php" id="matchup">Log out</a></li>
                  ';
              }// This is the flipside to your statement, a logout button is Displayed if you are logged in and a session variable has been set
               // This mechanism can be extended to include any form of navigation you want dependent on the session being set
               // Like a custom dark mode or something interesting
              ?>
              

        </ul>
    </nav>
    <div class="minion-logo">
      <img src="images/film.png" width="50" height="50">
    </div>
</div>
<!-- End of navigation -->
