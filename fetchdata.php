
<?php
$mr_number = $_POST["mrn"];
   // (1) Open the database connection
   $mysqli = new mysqli("localhost", "php", "PHP!23php", "pt_data");
   if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
// echo "Connected to: " . $mysqli->host_info . "\n\n";
   // (2) Run the query through the
   //  connection


  $query = "SELECT  `obs_term`, `obs_value` FROM form_parts WHERE `mrn_pt` = '$mr_number' and `status` = '0'";
  $value = "begin data";
if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
       $value = $value."|".$row["obs_term"]."|".$row["obs_value"];
    }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();
$value = $value."|end data";
echo $value;
$con=mysqli_connect("localhost","paulbas","Htpn8080","pt_data");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
   mysqli_query($con,"Update `form_parts` set `status` = '1' WHERE `mrn_pt` = '$mr_number'");

mysqli_query($con,"update `name_table` set `status` = '1' WHERE `mrn_pt` = '$mr_number'");
mysqli_close($con);

?>