    <div id="nav_top"> <!-- a bit Old school, Needs fixing -->
      <ul>
        <li><a href="index.php" id="home" >Home </a></li>
        <li><a href="login.php" id="log">Login</a></li>

        <?php
        // isset Is just for checking if a value has been set, it's a boolean in disguise
        if (!isset($_SESSION['minion_id'])) {
        echo '<li><a href="register.php" id="sign">Join the cause</a></li>
        ';
      }// Therefore this link only appears if you are not logged in and haven't generated
        ?>

        <li><a href="noaccess.php" id="log">Denied Access</a></li>

        <?php
        if (isset($_SESSION['minion_id'])) {
            echo '<li><a href="logout.php" id="matchup">Dynamic Logout link based on being logged in</a></li>
            ';
        }// This is the flipside to your statement, a logout button is Displayed if you are logged in and a session variable has been set
         // This mechanism can be extended to include any form of navigation you want dependent on the session being set
         // Like a custom dark mode or something interesting
        ?>

      </ul>
    </div>
