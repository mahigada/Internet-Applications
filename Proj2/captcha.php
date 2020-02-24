<?php
//include ("config.php");
session_set_cookie_params(0, "/~mg657/Assignment_2/", "web.njit.edu");
session_start();
$font = 'LaBelleAurore.ttf';
$font2 = 'TimesNewRoman.ttf';
header('Content-Type: image/png');
$im=imagecreatetruecolor(300, 120);
$black=imagecolorallocate($im,0,0,0);
$greyish=imagecolorallocate($im, 215, 215, 215);
$pink = imagecolorallocate($im, 255,182,193);
$purple = imagecolorallocate($im, 148,0,211); 
$green = imagecolorallocate($im, 34,139,34);
$blue = imagecolorallocate($im, 0,191,255);
imagefilledrectangle($im, 8, 8, 290, 110, $pink);
$length = 2;
$text = substr(str_shuffle(md5(time() )), 0, $length);
$_SESSION["captcha"] = $text;
$sidvalue = session_id();
imagettftext($im, 20, 0, 15, 30, $purple, $font, $text);
$text2 = substr(str_shuffle(md5(time() )), 0, $length);
$_SESSION["captcha"] = $text2; 
imagettftext( $im, 20, -45, 180, 70, $green, $font, $text2); 
$captcha_text = $text ."". $text2;
for( $count=0; $count<7; $count++ )
{
imageline($im,mt_rand(0,270), mt_rand(0,90), mt_rand(0,270), mt_rand(0,90), $blue);
}
$_SESSION["captcha"] = $captcha_text; 
imagettftext( $im, 10, 0, 10, 90, $black, $font2, $captcha_text); 
$text3 = "session ID: "."".$sidvalue; 
imagettftext( $im, 10, 0, 10, 100, $black, $font2, $text3); 
imagepng($im);
imagedestroy($im);
?>
