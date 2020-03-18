<?php
    require_once("includes/startSession_inc.php"); //very important that this is first!
    include("includes/header_inc.php");
    include("includes/navigation_inc.php");
 ?>

    <div class="g1-container">
        <!-- Container holds content -->
        <?php
  echo '<h2 class="g-minion-c">Minions Club</h2>';
  ?>
            <p class="notice">Edit Profile</p>
            <div class="form-content">
                <!-- Container holds form -->
                <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
                    <p>Personal Information</p>
                    <fieldset>
                        <label for="minionname">Minion name</label>
                        <br>
                        <input type="text" id="minionname" name="minionname" value="<?php if (!empty($minion_name)) echo $minion_name; ?>" />
                        <br>
                        <label for="codename">Code name</label>
                        <br>
                        <input type="text" id="codename" name="codename" value="<?php if (!empty($code_name)) echo $code_name; ?>" />
                        <br>
                        <label for="cloned">Cloned</label>
                        <br>
                        <input type="text" id="cloned" name="cloned" value="<?php if (!empty($cloned)) echo $cloned; ?>" />
                        <br>
                        <label for="recruited">Recruited</label>
                        <br>
                        <input type="text" id="recruited" name="recruited" value="<?php if (!empty($recruited)) echo $recruited; else echo 'YYYY-MM-DD'; ?>" />
                        <br>
                        <label for="location">Location</label>
                        <br>
                        <input type="text" id="location" name="location" value="<?php if (!empty($location)) echo $location; ?>" />
                        <br>
                        <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
                        <br>
                        <label for="new_picture">Picture</label>
                        <br>
                        <input type="file" id="new_picture" name="new_picture" />
                        <?php if (!empty($old_picture)) {
  echo '<img class="minionmates" src="' . MM_UPLOADPATH . $old_picture . '" alt="minionmates Picture" />';
} ?>
                    </fieldset>
                    <br>
                    <input type="submit" value="Save Profile" name="submit" />
                </form>

                <?php
// Make sure the user is logged in before going any further.
// Create a link for them to do so, all helpful like!
if (!isset($_SESSION['minion_id'])) {
echo '<p class="login">Please <a href="login.php">log in </a> to access this page.</p>';
exit();
}
else {
echo('<p class="login">You are logged in as ' . $_SESSION['minion_name'] .  '. <a href="logout.php">Log out</a>.</p>');
//echo ('<p> Why not fill in our <a href="response_form.php">questionnaire</a></p>');
//echo $_SESSION['minion_id'];
}

?>

                    <?php


  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  // Connect the database as usual

   //Has someone press the submit button???
   if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $minion_name = mysqli_real_escape_string($dbc, trim($_POST['minionname']));
    $code_name = mysqli_real_escape_string($dbc, trim($_POST['codename']));
    $cloned = mysqli_real_escape_string($dbc, trim($_POST['cloned']));
    $recruited = mysqli_real_escape_string($dbc, trim($_POST['recruited']));
    $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size'];
    list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
        ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
        if ($_FILES['file']['error'] == 0) {
          // Move the file to the target upload folder If there are no errors stop
          $target = MM_UPLOADPATH . basename($new_picture);
            if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(MM_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
          }
        }
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['new_picture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
          ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    }

    // Update the minionmates data in the database
    if (!$error) {// All good, talk to the database
      if (!empty($minion_name) && !empty($code_name) && !empty($cloned) && !empty($recruited) && !empty($location)) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
          $query = "UPDATE minionmates SET minion_name = '$minion_name', code_name = '$code_name', cloned = '$cloned', " .
            " recruited = '$recruited', location = '$location',  picture = '$new_picture' WHERE minion_id = '" . $_SESSION['minion_id'] . "'";
        }
        else {
          $query = "UPDATE minionmates SET minion_name = '$minion_name', code_name = '$code_name', cloned = '$cloned', " .
            " recruited = '$recruited', location = '$location'   WHERE minion_id = '" . $_SESSION['minion_id'] . "'";
        }
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your minionmates has been successfully updated. Would you like to <a href="minion_profile.php">view your profile</a>?</p>';
        echo $query;

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the minionmates data from the database
    $query = "SELECT minion_name, code_name, cloned, recruited, location,  picture FROM minionmates WHERE minion_id = '" .  $_SESSION['minion_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $minion_name = $row['minion_name'];
      $code_name = $row['code_name'];
      $cloned = $row['cloned'];
      $recruited = $row['recruited'];
      $location = $row['location'];
      $old_picture = $row['picture'];
    }
    else {
      echo '<p class="error">There was a problem accessing your Profile.</p>';
      echo '<p>Why not create your <a href="minion_profile.php">Profile</a>?</p>';
    }
  }

  mysqli_close($dbc);
?>
                        </a>


            </div>
    </div>

    <?php include("includes/footer_inc.php"); ?>