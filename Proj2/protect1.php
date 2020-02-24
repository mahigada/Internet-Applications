<?php
include("config.php"); 
session_set_cookie_params(0, $path, "web.njit.edu"); 
session_start();
print "<br>Successfully got to Protected page1. <br>";

if(! isset($_SESSION['logged'])){

    echo "<br>Please Login. <br><br>";
    header("refresh:2; url = login.html");
    exit();

}

echo "<br>You are allowed onto protected1.php <br><br>"; 


echo "Ucid: "."".$_SESSION["ucid"]; 
echo "<br><br>"; 

?> 

<a href = "protect2.php"> Click here to enter protected2.php! </a><br>
<a href = "logout.php"> Click here to Logout! </a>
