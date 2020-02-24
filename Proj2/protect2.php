<?php
include("config.php"); 
session_set_cookie_params(0, $path, "web.njit.edu"); 
session_start();
print "<br>Successfully got to Protected page2. <br>";
if(! isset($_SESSION['logged'])){

    echo "<br>Please Login. <br><br>";
    header("refresh:2; url = login.html");
    exit();

}

echo "<br>You are allowed onto protect2.php <br><br>"; 


echo "Ucid: "."".$_SESSION["ucid"]; 
echo "<br><br>"; 

?> 

<a href = "protect1.php"> Click here to enter protect1.php! </a><br>
<a href = "logout.php"> Click here to Logout! </a>
