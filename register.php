<?php
    include("includes/header_inc.php"); //bring in the CSS etc
    include("includes/navigation_inc.php");
?>


    <div class="g1-container">
        <!-- Container holds content -->
        <?php
    echo '<h2 class="g-minion-c">Minions Club</h2>';
    echo '<p class = "notice">Register now to become a memeber</p>';
    ?>
            <div class="form-content">
                <!-- Container holds form -->
                <p>Your details</p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- Sensitive data so best to use  $_POST-->
                    <fieldset>
                        <label for="username">Username</label>
                        <br>
                        <input type="text" id="minionname" name="minionname" value="<?php if (!empty($minionname)) echo $minionname; ?>" required />
                        <br>
                        <label for="email">Email address</label>
                        <br>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" onblur="this.value=removeSpaces(this.value);" required />
                        <br>
                        <label for="password1">Set a password</label>
                        <br>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password1" name="password1" required title="8 characters minimum" />
                        <br>
                        <label for="password2">Confirm password</label>
                        <br>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password2" name="password2" required title="8 characters minimum" />
                        <br>
                    </fieldset>

                    <fieldset>
                        <label for="title">Title *</label>
                        <br>
                        <select>
                            <option selected disabled>Choose Your title</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                            <option value="Miss">Miss</option>
                            <option value="Dr">Dr</option>
                            <option value="Sir">Sir</option>
                        </select>
                        <br>
                        <label for="fname">First name</label>
                        <br>
                        <input type="text" id="fname" name="fname" onblur="this.value=removeSpaces(this.value);" required />
                        <br>
                        <label for="lname">Last name</label>
                        <br>
                        <input type="text" id="lname" name="lname" onblur="this.value=removeSpaces(this.value);" required />
                        <br>
                        <label for="DOB">Date of Birth</label>
                        <br>
                        <input type="date" id="DOB" name="Date of Birth" required />
                        <br>
                        <label for="gender">Gender</label>
                        <br>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <br>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                        <br>
                    </fieldset>

                    <fieldset>
                        <label for="mobile">Mobile Number</label>
                        <br>
                        <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" required />
                        <br>
                        <label for="tmobile">Telephone Number</label>
                        <br>
                        <input type="text" id="tphone" name="telephone" placeholder="Enter your telephone number" required />
                        <br>
                        <label for="address">Address</label>
                        <br>
                        <input type="text" id="address" name="address" placeholder="Address" required />
                        <br>
                        <label for="town">Town</label>
                        <br>
                        <input type="text" id="town" name="town" placeholder="Town" required />
                        <br>
                        <label for="county">County</label>
                        <br>
                        <input type="text" id="county" name="county" placeholder="County">
                        <br>
                        <label for="pcode">Post code</label>
                        <br>
                        <input type="text" id="pcode" name="postcode" placeholder="Enter your postcode" required />
                    </fieldset>

                    <br>
                    <input type="submit" value="Join Up" name="submit" />
                </form>


                <?php

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (isset($_POST['submit'])) {
        // Has someone press the submit button?
        // If they have...
        // Grab the profile data from the POST super global, while making sure no nasty inputs get through to the database
        $minionname = mysqli_real_escape_string($dbc, trim($_POST['minionname']));
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

        // Make sure everything is nicely filled in, no exceptions
        if (!empty($minionname) && !empty($email) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {

        // Make sure someone isn't already registered using this username
        $query = "SELECT * FROM minionmates WHERE minion_name = '$minionname'";
        $data = mysqli_query($dbc, $query);
        // Make sure someone isn't already registered using this email
        $query = "SELECT * FROM minionmates WHERE user_email = '$email'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 0) {
        // The username is unique, In other words doesn't return the result, insert the data into the database
          $query = "INSERT INTO minionmates (minion_name, user_email, password, recruited) VALUES ('$minionname', '$email', sha1('$password1'), now())";
          mysqli_query($dbc, $query);

          // Confirm success with the user, not forgetting to use slashes to escape the apostrophies in the English
          echo '<p>Your new account has been successfully created. You\'re now ready to take over the world and
          <a href="login.php">log in </a>.</p>';

        }
        else {
          // An account already exists for this username, so display an error message and persuade the minion to choose a different name
          echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
          $username = "";
        }
      }
      else {//another helpful message?!
        echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
      }
    }
   mysqli_close($dbc);
                

  ?>


            </div>
            <!-- Close form container -->

    </div>
    <!-- End of container -->

    <?php include("includes/footer_inc.php"); ?>