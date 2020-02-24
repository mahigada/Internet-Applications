<?php
error_reporting(E_ERROR |  E_WARNING | E_PARSE | E_NOTICE);
ini_set('display error',1); 
include ("account.php");
include("myFunctions.php");
$db = mysqli_connect($hostname , $username , $password , $project);
if (mysqli_connect_errno())
{
	echo "Failed to connect to MYSQL: " .mysqli_connect_error();
	exit();
}
print "<br> Successfully connected to MYSQL .<br><br><br>";

mysqli_select_db ($db , $project);


$ucid = get("ucid", $dataOK);
$pass = get("pass", $dataOK);
$account = get("account", $dataOK);
$amount = get("amount", $dataOK);
$pin = get("pin", $dataOK);
$choice = get("choose", $dataOK);
echo"<hr>";

$dataOK = true;
$warning = "";


if($ucid == "" || $pass == "" || $account == ""){
  $state = -1;
  $dataOK = false;
} else{
  $state = -2;
}

if($dataOK && super_auth($ucid,$pass, $state, $newpin)){

  if($choice == "t"){
		transact($ucid, $account, $amount);
		exit();
	}
	if($choice == "r"){
		see($ucid, $account);
		exit();
	}
	if($choice == "cl"){
		clear($ucid, $account, $db);
		exit();
	}

} 

else{
	if ($state == -1){
    print "<br> This is invalid input";
  }
  elseif($state == 0){
    print "<br> These are bad credentials";
  } 
  elseif ($state == 1){
    print "<br> You put in the wrong pin ";
  }
  echo "$warning";

  print "<br>(For testing) PIN: $newpin <br><br>";
}

?>
<style>	div   {   border-style: solid;
  border-color: red;
    display: none;    }
</style>
<form action = "Script.php" method="get">
<input type = text name = "ucid" value = "<?php print $ucid; ?>">Enter the ucid
<br><br>
<input type = text name = "pass" value = "<?php print $pass; ?>">Enter the password<br><br>
<input type = text name = "account" value = "<?php print $account; ?>">Enter the account number<br><br>
<input type = text name = "pin" value = "<?php print $pin; ?>">Enter your pin<br><br>
    <select id="choose" name = "choose" onchange = F()>
        <option name = "c" value = "c" <?php if ($choice == 'c') echo 'selected';?> >Choose </option>
        <option name = "r" value = "r" <?php if ($choice == 'r') echo 'selected';?> >See </option>
        <option name = "t" value = "t" <?php if ($choice == 't') echo 'selected';?> >Transaction </option>
        <option name = "cl" value = "cl" <?php if ($choice == 'cl') echo 'selected';?> > Clear </option>
    </select>
    <br><br>
    <div id = "amount">
        <input type =text name="amount"> Enter transact amount<br>
    </div><br><br>
<input type = submit>
</form>
<script>
    "use strict"
    var choose = document.getElementById("choose")
    var ptrAmount = document.getElementById("amount")
    ptrAmount.addEventListener("blur", F)
    function F(){
        if (choose.value =="t"){ptrAmount.style.display='block'}
        else{ptrAmount.style.display='none'}
    }
</script>

