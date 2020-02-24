<?php
include("config.php");
session_set_cookie_params(0, $path);
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
$sidvalue = session_id();
echo "<br>Session ID was: " . $sidvalue . "<br>"; 
$_SESSION = array();
session_destroy();
setcookie("PHPSESSID", "", time()-3600, '/~mg657/Assignment_2/', "", 0, 0); 
echo "Your session is terminated";
?>

