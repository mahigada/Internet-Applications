<?php

function see($ucid, $account){

    global $db;
     
    $s1 = "select * from transactions where ucid = '$ucid' and account = '$account'";
  
    ($t = mysqli_query($db,$s1)) or die (mysqli_error($db));
    $t = mysqli_query($db, $s1);
    $num1 = mysqli_num_rows($t);
    $s2 = "select * from accounts where ucid = '$ucid' and account = '$account'";
    ($t2 = mysqli_query($db,$s2)) or die (mysqli_error($db));
    $t2 = mysqli_query($db, $s2);
    $num2 = mysqli_num_rows($t2);
    print "<br>$num1 rows retrieved from transactions. <br>";
    print "$num2 rows retrieved from accounts. <br><hr>";
    echo "<br>Account information follows";
   while ( $r2 = mysqli_fetch_array($t2, MYSQLI_ASSOC)){
      $account =  $r2["account"];
      $balance = $r2["balance"];
      $recent = $r2["recent"];
      if($balance > 0){
     print "<br>Account is: $account || Balance is: \$$balance || Recent is: $recent <hr>";
      } else{
     $balance *= -1;
         print "<br>Account is: $account || Balance is: -\$$balance || Recent is: $recent <hr>";
      }
    }
   print "<br> transactions for $ucid follow <br>";
    while ( $r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
      $amount =  $r["amount"];
      $timestamp = $r["timestamp"];
      $email = $r["mail"];
      if($amount > 0){
     print "<br>Timestamp is: $timestamp || Amount is: \$$amount || Email is: $email ";
      } else{
     $amount *= -1;
     print "<br>Timestamp is: $timestamp || Amount is: -\$$amount || Email is: $email ";
      }
    }
     print "<hr><br>Interaction complete.<br>";
}

function get($fieldname, $dataOK){
    global $db, $warning;
    $v=$_GET[$fieldname];
    if(!isset($fieldname)){
      return $v;
  } 
    $v = trim($v);
    $v=mysqli_real_escape_string($db,$v);
    if (($v =="") && ($fieldname == "ucid")) {$warning ="<br>Empty u"; $dataOK = false;}
     if (($v =="") && ($fieldname == "pass")) {
      $warning .="<br>Empty p"; $dataOK = false;}
      if ($v !="" && $fieldname == "amount" && !is_numeric($v)) 
        {

         $warning = "<br>Non-numeric amount"; 
         $dataOK = false;

       }
      echo "<br> The value of $fieldname is $v";
    return $v;
}
function transact($ucid, $account, $amount){
    global $db;
    echo "<br> Before: <br>";
    see($ucid, $account);
    $s1 = "UPDATE accounts SET balance = balance + '$amount', recent = NOW() where ucid = '$ucid' and balance + '$amount' >=0";
    ($t = mysqli_query($db,$s1)) or die (mysqli_error($db));
    $num = mysqli_affected_rows($db);
    if($num == 0){echo "<br>Either overdraft or invalid account"; return;}
    $s2 = "INSERT into transactions values ('$ucid', '$account', '$amount', NOW(), 'N')";
    ($t = mysqli_query($db,$s2)) or die (mysqli_error($db));
    echo "Completed interaction";
    echo "<br>$s1 <br>";
    echo "<br>$s2 <br>";
    echo "<br> After: <br>";
    see($ucid, $account);
}

function clear($ucid, $account, $db){
    $s1 = "UPDATE accounts SET balance ='0.00' where ucid = '$ucid' and account = '$account'";
    echo "<br>$s1 <br>";
    $s2 = "DELETE from transactions where ucid = '$ucid' and account = '$account'";
    echo "<br> $s2 <br>";
    ($t = mysqli_query($db,$s2)) or die (mysqli_error($db));
    see($ucid, $account);
}
function authenticate($ucid, $pass, &$DBpin){
  global $db;
  $s = "select * from users where ucid = '$ucid' and pass = '$pass'";
  ($t = mysqli_query($db,$s)) or die (mysqli_error($db));
  $num = mysqli_num_rows($t);
  if($num == 0){
    return false;
  }
 
  $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
  $DBpin = $r["pin"];
  return true;
}

function theEmail($newpin){
  $to = "mg657@njit.edu";
  $subject = "Your new pin";
  $message = $newpin;
  mail($to, $subject, $message);
}


function randomPIN(){
  global $db, $ucid;
  $newpin = mt_rand(1000,9999);
  $s = "update users set pin = '$newpin' where ucid = '$ucid'";
  ($t = mysqli_query ($db, $s)) or die (mysqli_error($db));
  return $newpin;
}

function super_auth($ucid, $pass, &$state, &$pin){
  if(!authenticate($ucid, $pass, $DBpin)){
    $state = 0;
    return false;
  } 
  
  else{
    if( !isset($_GET["pin"]) || $_GET["pin"] == "" || $_GET["pin"] != $DBpin){
      $pin = randomPIN();
      theEmail($pin);
      $state = 1;
      return false;
    } 
    else{
      return true;
    }
  }
 
}

?>
