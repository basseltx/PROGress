<?php
$mr_number = $_GET["mrn"];
$con=mysqli_connect("127.0.0.1","php","PHP!23php","pt_data");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_query($con,"DELETE FROM `form_parts` WHERE `mrn_pt` = '$mr_number'");
mysqli_query($con,"DELETE FROM `name_table` WHERE `mrn_pt` = '$mr_number'");
mysqli_close($con);
Echo "Patient Removed: ".$mr_number;
Echo "<br><br><a href=\"./list2.php\">Back to patient list</a>";
?>