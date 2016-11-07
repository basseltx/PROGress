<?php
require './toolbox.php';
$datastrng = $_POST["inputstring"];
$x_array = explode("_",$datastrng);
if (!isset($x_array[4])){
$x_array[4] = "";
}
 // (1) Open the database connection
   $mysqli = openMysqli();

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
$result = $mysqli->query("SELECT `mrn_pt` From `name_table` where `mrn_pt` = '$x_array[0]' and `status` = '0'");
$rowcount = $result->num_rows;
$result->close();
if ($rowcount < 1){
$query = "INSERT INTO `name_table` (`mrn_pt`,`f_name`,`pt_age`,`pt_sex`,`loc_care`) VALUES ('$x_array[0]','$x_array[1]','$x_array[2]','$x_array[3]','$x_array[4]')";
$result = $mysqli->query($query);
ECHO $x_array[0]."> ".$x_array[1]."> ".$x_array[2]."> ".$x_array[3]."> ".$x_array[4];
$mysqli->close();
}

?>


