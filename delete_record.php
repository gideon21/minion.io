<?php include("includes/header_inc.php"); ?>
    <?php include("includes/navigation_inc.php"); ?>


        <div class="g1-container">

            <div class="form-content">

                <h2>Delete profile</h2>

    <?php
        
    session_start(); // Start session to see who is logged in
        
    include_once ('includes/connectvars_inc.php');
 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); // Connect to the database
        
    $sessionid = $_SESSION['minion_id']; // get session id which is equal to the current super global called session with the name minion_id
    
    // find a file in uploads folder that as this base name (profile)           
    $filename = "uploads/profile1".$sessionid."*";
    $fileinfo = glob($filename);
    $fileext = explode(".", $fileinfo[0]);
    $fileactualext = $fileext[1];
                
    $file = "uploads/profile1".$sessionid.".".$fileactualext;
                
    // Remove file
    if (!unlink($file)) {
        echo "File was not deleted!";
    }else {
         echo "File was deleted!";
    }
     
    // Update this in the database
    $query = "UPDATE minionmates SET picture = '$picture' WHERE minion_name = '$sessionid';";

    mysqli_query($dbc, $query);
                
		
?>
            </div>

        </div>