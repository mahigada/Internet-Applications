<?php
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
function authenticate($ucid, $pass){
  global $db;
  $s = "select * from users where ucid = '$ucid'";
  ($t = mysqli_query($db,$s)) or die (mysqli_error($db));
  $num = mysqli_num_rows($t);
  if($num == 0){
    return false;
  }
 
  $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
  //$DBpin = $r["pin"];
  $hash = $r["hash"]; 
  if( password_verify($pass, $hash) )
  {
      return true; 
  }
}

?>