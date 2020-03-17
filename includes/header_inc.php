<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Minion.io</title>

    <link  rel="stylesheet" type="text/css" href="css/g_main.css"/>
    <link  rel="stylesheet" type="text/css" href="css/g_nav.css"/>
  <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Roboto&display=swap" rel="stylesheet">
    <?php require_once("includes/appvars_inc.php"); ?> <!-- Image loading stuff -->
    <?php require_once("includes/connectvars_inc.php"); ?> <!-- Database connection stuff -->
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="js/minion-validations.js"></script>
    <script type="text/javascript">
    // This will trim spaces in a string
       function removeSpaces(string) {
           return string.split(' ').join('');
       }
   </script>


</head>

<body id="<?= basename($_SERVER['PHP_SELF'], ".php")?>">
