
<?php

 // SQL injection protection function - useful for logins
 // I haven't implemented this function in the application, so bonus time here
function mysql_entities_fix_string($string) {
    return htmlentities(mysql_fix_string($string));
}

 //html hack protection function - useful for text entry boxes
//Same again, another sanitisation function that I haven't implemented
function mysql_fix_string($string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return mysql_real_escape_string($string);
}

//You can add your own functions and here including ones as simple as trim();

?>
