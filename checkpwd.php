<?php
require './toolbox.php';
$loc = $_POST["loc"];
if (isset($_POST["usrn"])) {
$usrn = $_POST["usrn"];
}
if (($_POST["loc"]) == ""){

$mssgstrng = "Be sure to select location!";
$targetstr = "./login.php";
}
if ($_POST["usrn"] == "" ){
$mssgstrng = "Remember to enter your Baylor username!";
$targetstr = "./login.php";
}
if ($_POST["psswrd"] ==""){
$mssgstrng = "Remember to enter password!";
$targetstr = "./login.php";
}
if (($_POST["psswrd"] != "") and ($_POST["loc"] != "") and ($_POST["usrn"] != "")){
$psswd = $_POST["psswrd"];
$usrnam = 'bhcs\\'.$usrn;


$ldap = ldap_connect("ldap.bhcs.pvt");
if($bind = ldap_bind($ldap, $usrnam, $psswd)){
	$mssgstrng = "Success";
   $targetstr = "./list4.php";
}
else{
  $mssgstrng = "Invalid login. Try again:";
   $targetstr = "./login.php";
}

    }
setcookie('loc',$loc,time()+36000);
setcookie("htname",$usrn, time()+36000);
$url = $targetstr."?mssg=".$mssgstrng."&loc=".$loc."&usrn=".$usrn;
  header('Location: '.$url);
 // Echo $loc." ".$psswd." ".$row_cnt."  ".$mssgstrng;

    ?>
