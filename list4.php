<script>
function toggleDec(evt) {
            evt = (evt) ? evt : event;
            var target = (evt.target) ? evt.target : evt.srcElement;
            var block = document.getElementById("pediatric");
            if (target.id == "DecFlag1") {
                block.style.display = "block";
            } else {
                block.style.display = "none";
            }
        }
</script>

<?php
require './toolbox.php';
if (isset($_POST["option100"])){
		$number_name = $_POST['mrn_fname'];
		$MRN = explode("|",$number_name);
		$mrnum = $MRN[0];
		$con=mysqli_connect("127.0.0.1","php","PHP!23php","pt_data");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
   
	mysqli_query($con,"update `name_table` set `status` = '2' WHERE `mrn_pt` = '$mrnum'");
	mysqli_close($con);
	unset($_POST["mrn_fname"]);
	unset($_POST["option100"]);
			}
$n = 1;
while ($n <= $item_total) {
$choice_array[$n] = 0;
$n++;
}

if (isset($_POST["mrn_fname"])){
	$number_name = $_POST['mrn_fname'];
	$MRN = explode("|",$number_name);
	$mrnum = $MRN[0];
	//echo $mrnum;
	if (count($MRN) > 1) {
	$fname = $MRN[1];
    $ptage = $MRN[2];
	$ptsex = $MRN[3];
}
else {
    $fname = "";
    $ptage = "";
	$ptsex = "";
	}
	$mysqli = openMysqli();
	$query = "select selected_forms from pt_data.name_table where mrn_pt = '$mrnum'";


	$select_array[0] = 0;
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
		//Echo $row['selected_forms'];
		$select_array = explode("|",$row['selected_forms']);
   		}

   		$i = 0;
   		while ($i < count($select_array)) {
   			if (isset($select_array[$i])){
   			$x = $select_array[$i];
   			//Echo $select_array[$i];
   			$choice_array[$x] = $x;
   			//echo $choice_array[$x];
   			}
   			$i++;
   		}


   		$mysqli->close();
	}
	else { echo "Failed query prevents getting selected forms";
		$mysqli->close();
		}

	}
	else {
	$mrnum = "";
	$ptage = 225;
	$ptsex = "";

	}

if (isset($_POST["pedsDecision"])){
$pedsdecision = $_POST["pedsDecision"];
}
Else {
$pedsdecision = "none";
}
if ($ptage < 216) {$pedsdecision = "block";}
if ($ptage > 252) {$pedsdecision = "none"; }

if (isset($_GET["save_forms"])){
	unset($choice_array);
	//Asthma questionnaire
	if (isset($_POST['option1'])){$choice_array[1] = $_POST['option1'];} else {$choice_array[1] = 0;}
	//Peds Health questionnaire
	if (isset($_POST['option2'])){$choice_array[2] = $_POST['option2'];}else {$choice_array[2] = 0;}
	//Newborn History
	if (isset($_POST['option5'])){$choice_array[5] = $_POST['option5'];}else {$choice_array[5] = 0;}
	//peds devel/behavior
	if (isset($_POST['option6'])){$choice_array[6] = $_POST['option6'];}else {$choice_array[6] = 0;}
	//MCHAT
	if (isset($_POST['option7'])){$choice_array[7] = $_POST['option7'];}else {$choice_array[7] = 0;}
	//Adult Health Questionnaire
	if (isset($_POST['option8'])){$choice_array[8] = $_POST['option8'];}else {$choice_array[8] = 0;}
	//PHQ 2 - 9 screen
	if (isset($_POST['option9'])){$choice_array[9] = $_POST['option9'];}else {$choice_array[9] = 0;}
	//Review of Systems
	if (isset($_POST['option10'])){$choice_array[10] = $_POST['option10'];}else {$choice_array[10] = 0;}
	if (isset($_POST['option11'])){$choice_array[11] = $_POST['option11'];}else {$choice_array[11] = 0;}

	if (isset($_POST['option12'])){$choice_array[12] = $_POST['option12'];}else {$choice_array[12] = 0;}
	if (isset($_POST['option13'])){$choice_array[13] = $_POST['option13'];}else {$choice_array[13] = 0;}
	//if (isset($_POST['option3'])){$choice1 = $_POST['option3'];}
	//if (isset($_POST['option4'])){$choice1 = $_POST['option4'];}
	$choices = "$choice_array[1]|$choice_array[2]|$choice_array[5]|$choice_array[6]|$choice_array[7]|$choice_array[8]|$choice_array[9]|$choice_array[10]|$choice_array[11]|$choice_array[12]|$choice_array[13]";
	//echo $choices;
	$mysqli = openMysqli();
	$query = "update `name_table` set `selected_forms` = '$choices' where `mrn_pt` = '$mrnum'";
	if ($result = $mysqli->query($query)){
		}
		Else {
			Echo "An error has prevented saving the selections to the database";
			}
		$mysqli->close();

	}


if (isset($_GET["loc"])){
$LOC = $_GET["loc"];
}

if (isset($_POST["loc"])){
$LOC = $_POST["loc"];
}

//Echo $choice1.$choice2.$choice5.$choice6;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript">
window.history.forward();
function noBack(){ window.history.forward(); }
</script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Patient List - HTPN</title>
<meta name="generator" content="Quick 'n Easy Web Builder - http://www.quickandeasywebbuilder.com">
<style type="text/css">
body
{
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<style type="text/css">
a
{
   color: #0000FF;
   text-decoration: underline;
}
a:visited
{
   color: #800080;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #0000FF;
   text-decoration: underline;
}
p, span, div, ol, ul, li, input, textarea, form
{
   margin: 0;
   padding: 0;
}
</style>
<style type="text/css">
#wb_Form1
{
   //background-color: #ADD8E6;
   background-color: #05C5FF;
   border: 0px #000000 solid;
}
#wb_Text1
{
   background-color: transparent;
   border: 0px #C0C0C0 solid;
}
#Combobox1
{
   border: 1px #C0C0C0 solid;
   background-color: #FFFFFF;
   color: #000000;
   font-family: Arial;
   font-size: 13px;
}
</style>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
<table>
<tr>
<td style="text-align:center;width:500px"><img src="./PROGress-logo.jpg" alt="PROGress"></td>
<td>
<table>
<tr>
<td ><img src="./id2_htpn_small.jpg" alt="HTPN Logo"></td>
<tr>
<td style="text-align:center"><img src="./BSWH_Logo_RGB_120.jpg" alt="BSWH"></td>

</tr>
</table>
</td>
</tr>
</table>
<hr style='position:absolute;left:30px;width:920px'>
<?php
If (isset($LOC)){
Echo "
<br>
<table style='font-family:lucida grande;font-size:20px;width:800px;position:absolute;left:30px'>
<tr><td><b>Select patient by first name and MRN:</b></td>
<td style='text-align:right'><a href=\"http://progress.screenstepslive.com/s/9044/m/28403\" target='_blank'>PROGress Manual</a></td></tr></table>

<div id=\"wb_Form1\" style=\"font-family:Lucida Grande;font-size:24px;position:absolute;left:30px;top:170px;width:920px;height:500px;z-index:2;\">
<form name=\"Patient_select\" method=\"post\" action=\"./createform3-c.php\" enctype=\"multipart/form-data\" id=\"Form1\">
<script>
    function submitForm(action)
    {
        document.getElementById('Form1').action = action;
        document.getElementById('Form1').submit();
    }
</script>
<input type=\"submit\" id=\"Button1\" name=\"save_forms\" value=\"Save Choices\" onclick=\"submitForm('./list4.php?save_forms=yes')\" style=\"position:absolute;left:120px;top:450px;width:180px;font-family:Lucida Grande;font-size:20px;height:36px;z-index:5;\">
<input type=\"submit\" id=\"Button2\" name=\"load_forms\" value=\"Create forms\" onclick=\"submitForm('./createform3-c.php')\" style=\"position:absolute;left:320px;top:450px;width:180px;font-family:Lucida Grande;font-size:20px;height:36px;z-index:5;\">
<div id=\"wb_Text1\" style=\"font-family:Lucida Grande;font-size:24px;padding:0;position:absolute;left:0px;top:15px;width:120px;height:20px;text-align:left;z-index:0;border:0px #C0C0C0 solid;overflow-y:hidden;background-color:transparent;\">
<div style=\"font-family:Lucida Grande;font-size:16px;color:#000000;\">
<div style=\"text-align:left\"><b>Patient:</b></div>
</div>
</div>
<input style='left:220px' type=\"hidden\" name=\"loc\" value=\"$LOC\">
<select name=\"mrn_fname\" size=\"1\" id=\"mrn_fname\" onchange=\"submitForm('./list4.php')\" style=\"font-size:24px;position:absolute;left:120px;top:15px;width:400px;height:32px;z-index:1;\">
<option value = '' >Select a patient</option>"
;

$mysqli = openMysqli();

$query = "Select mrn_pt, f_name, pt_age, pt_sex,selected_forms from name_table where `loc_care` = '$LOC' and `status` = '0'";

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    $n = 1;
    $select_flag = "";
    while ($row = $result->fetch_assoc()) {
    if ($row['mrn_pt'] == $mrnum) {
    	$select_flag = "selected";
    	}
     echo "<option value=\"".$row['mrn_pt']."|".$row['f_name']."|".$row['pt_age']."|".$row['pt_sex']."\" $select_flag >".$row['f_name']." ____ ".$row['mrn_pt']."</option>";
	$n++;
	$select_flag = "";
    }

}
$result->close();
    $mysqli->close();

Echo "
</select>
<br></br>
<div id='contentshow' style='font-family:Lucida Grande;font-size:18px'>
 <p>Content categories:";

if ($mrnum <> "") {
if (($ptage < 216) or ($ptage > 252)) {
Echo " Auto - age specific";  }
else {
 echo "
		<input type='radio' id='DecFlag0' name='pedsDecision' value='none'
            onclick='toggleDec(event)' />Hide Pediatric
        <input type='radio' id='DecFlag1' name='pedsDecision' value='block'
            onclick='toggleDec(event)' />Show Pediatric";
}
if ($choice_array[1] == "1") {$checked1 = "checked";} else {$checked1 = "";}
if ($choice_array[2] == "2") {$checked2 = "checked";$pedsdecision = "block";} else {$checked2 = "";}
if ($ptage <= 4 ) {
if ($choice_array[5] == "5") {$checked5 = "checked";$pedsdecision = "block";} else {$checked5 = "";}}
if ($choice_array[6] == "6") {$checked6 = "checked";$pedsdecision = "block";} else {$checked6 = "";}
if (($ptage > 12) and ($ptage < 60)) {
if ($choice_array[7] == "7") {$checked7 = "checked";$pedsdecision = "block";} else {$checked7 = "";}}
If ($ptage > 215) {
if ($choice_array[8] == "8") {$checked8 = "checked";} else {$checked8 = "";}}
if ($ptage > 143) {
if ($choice_array[9] == "9") {$checked9 = "checked";} else {$checked9 = "";}}
if ($choice_array[10] == "10") {$checked10 = "checked";} else {$checked10 = "";}
if ($choice_array[11] == "11") {$checked11 = "checked";} else {$checked11 = "";}
if ($ptage > 779){
if ($choice_array[12] == "12") {$checked12 = "checked";} else {$checked12 = "";}}
if ($ptage > 119){
if ($choice_array[13] == "13") {$checked13 = "checked";} else {$checked13 = "";}}

echo "</p>
</div>
<div id='primarycare' style='font-family:Lucida Grande;font-size:24px;left:30px'>
<br>Confirm or select the patient entry items needed:<br><br>";

echo "<input type=\"checkbox\" $checked1 name=\"option1\" value=\"1\"> Asthma Questionnaire<br>";

if ($ptage > 203) {
echo "<input type=\"checkbox\" $checked11 name=\"option11\" value=\"11\"> Adult Review of Systems<br>";
}
if ($ptage > 203) {
echo "<input type=\"checkbox\" $checked8 name=\"option8\" value=\"8\"> Adult Health Questionnaire<br>";
}
if ($ptage >143){
echo "<input type=\"checkbox\" $checked9 name=\"option9\" value=\"9\"> PHQ 2 - 9 screen<br>";
}
if ($ptage >779){
echo "<input type=\"checkbox\" $checked12 name=\"option12\" value=\"12\"> Medicare Wellness Visit<br>";
}
if ($ptage >119){
echo "<input type=\"checkbox\" $checked13 name=\"option13\" value=\"13\"> GI visit history<br>";
}
echo "</div>";
echo "<div id='pediatric' style='display:$pedsdecision;font-family:Lucida Grande;font-size:24px;postion:absolute;left:30px'>";

echo "<input type=\"checkbox\" $checked2 name=\"option2\" value=\"2\"> Pediatric Health Questionnaire<br>";

echo "<input type=\"checkbox\" $checked6 name=\"option6\" value=\"6\"> Development/behavioral<br>";

If ($ptage < 6 ) {
echo "<input type=\"checkbox\" $checked5 name=\"option5\" value=\"5\"> Newborn History<br>";
}

If (($ptage > 12) and ($ptage < 60)){
echo "<input type=\"checkbox\" $checked7 name=\"option7\" value=\"7\"> MCHAT";
}

echo "</div>
<br><br>
<input type=\"checkbox\" name=\"option100\" value=\"100\" style='font-family:Lucida Grande;font-size:24px;left:110px'>Remove this patient from the list<br>
</form>
</body>
</html>
";
}
ELSE
ECHO "<br><br><h3>Select a patient to see choices.</h3><br>";
}
ELSE {
ECHO"
<br>
<table style='font-family:lucida grande;font-size:20px;width:800px;position:absolute;left:30px'>
<tr><td ><b>Select your location of care:</b></td>
<td 'style=text-align:right'><a href=\"http://progress.screenstepslive.com/s/9044/m/28403\" target='_blank'>PROGress Manual</a></td></tr></table>
<div id=\"wb_Form1\" style=\"font-family:Lucida Grande;font-size:24px;position:absolute;left:30px;top:170px;width:920px;height:500px;z-index:2;\">
<form name=\"Patient_select\" method=\"post\" action=\"./list4.php\" enctype=\"multipart/form-data\" id=\"Form1\">
<div id=\"wb_Text1\" style=\"font-family:Lucida Grande;font-size:24px;margin:10;padding:0;position:absolute;left:20px;top:15px;width:92px;height:20px;text-align:left;z-index:0;border:0px #C0C0C0 solid;overflow-y:hidden;background-color:transparent;\">
<div style=\"font-family:Lucida Grande;font-size:13px;color:#000000;\">
<div style=\"text-align:left\">Location:</div>
</div>
</div>
<select name=\"loc\" size=\"1\" id=\"loc\" onchange='if(this.value != 0) { this.form.submit(); }' style=\"font-size:24px;position:absolute;left:107px;top:15px;width:400px;height:32px;z-index:1;\">
<option value=\"\">Choose LOC from this list:</option>";

$mysqli = openMysqli();

$query = "SELECT DISTINCT `loc_care` FROM pt_data.name_table ORDER BY `loc_care`";

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    $n = 1;
    while ($row = $result->fetch_assoc()) {
     echo "<option value=\"".$row['loc_care']."\">".$row['loc_care']."</option>
     ";
	$n++;
    }
    $result->close();
    $mysqli->close();
}
Echo "
</form>
</div>
</body>
</html>
";


}
?>