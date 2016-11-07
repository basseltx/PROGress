<?php
require './toolbox.php';
$num_radios = 0;
if (isset( $_POST["num_rb"])) {  $num_radios = $_POST["num_rb"];}
$num_items = $_POST["num_items"];
$num_devs = $_POST["num_devs"];
$mr_number = $_POST["mrn"];
$ptage = $_POST["pt_age"];
$ptsex = $_POST["pt_sex"];
if (isset($_POST['loc'])) {$loc = $_POST['loc'];}
$fname = " ";
$resultflag = 0;
//Echo "$num_devs devs<br>";
//Echo "$num_items items<br>";
//Echo $_POST["devquestion_1"];
//Echo "$num_radios radios<br>";
$phq9 = 0;
$i = 1;
$z = 0;
$rb = 1;
//get current number of rows for this pt in the DB
$mysqli = openMysqli();
$query = "Select `obs_term` from form_parts where `mrn_pt` = '$mr_number' and `status` = '0'";
if ($aresult = $mysqli->query($query)) {
$row_cnt1 = $aresult->num_rows;
}

//*****process radiobutton yes|no answers here*****
while($rb <= $num_radios)
{
	$radiokey = "RadioButtonAnswer".$rb;
	//Echo "$radiokey <br>";
	$rb_answer[$rb] = $_POST[$radiokey];
	$rb_array = explode("|",$rb_answer[$rb]);
	//Echo "item= $rb_array[0] answer $rb_array[1]<br>";
	if ($rb_array[1] == "yes"){
	$obskey = $rb_array[2];}
	else{
	$obskey = $rb_array[3];
	}
	if (!isset($yes_array[$obskey])){
		$yes_array[$obskey] = "";
		}

	if (!isset($no_array[$obskey])){
		$no_array[$obskey] = "";
		}

	if ($rb_array[1] == "yes"){
	//concatenate affirmative response to comma delimited list

	if ($yes_array[$obskey]== "") {
		$yes_array[$obskey] = "Pt. complains of: ".$rb_array[0];
		//echo "setting the first yesarray item to $rb_array[0] <br>";
		}
	else{
		$yes_array[$obskey] = $yes_array[$obskey].",".$rb_array[0];
		//echo "adding $rb_array[0] to yesarray <br>";
		}
}
else {
//concatenate negative response to comma delimited list

		if ($no_array[$obskey] == "") {
		$no_array[$obskey] = "Pt. denies: ".$rb_array[0];
		//echo "setting the first noarray item to $rb_array[0] <br>";
		}
	else{
		$no_array[$obskey] = $no_array[$obskey].",".$rb_array[0];
		//echo "adding $rb_array[0] to noarray >br>";
		}


}
	$rb++;
}
//*****Now gather all radiobutton entries and add them to the POST arrays*****

if ($num_radios > 0){
foreach(Array_keys($yes_array) as $obs_rb){
	//echo $obs_rb." | ".$yes_array[$obs_rb]." ; ".$no_array[$obs_rb];
	$num_items++;
	$itemkey = "item_".$num_items;
	$obskey = "obs_".$num_items;
	$_POST[$itemkey] = $yes_array[$obs_rb].$no_array[$obs_rb];
	$_POST[$obskey] = $obs_rb;

	/*$itemkey++;
	$_POST[$itemkey] = $no_array[$obs_rb];
	$obskey = "obs_".$num_items;
	$_POST[$obskey] = $obs_rb;
	*/
}
}

//*****Now do the other obs term responses.*****
while ($i <= $num_items) {
$itemkey = "item_".$i;
$obskey = "obs_".$i;
//get items and obs from POST data
if (isset($_POST[$itemkey])) {$item_ary[$i] = $_POST[$itemkey];}
else {$item_ary[$i] = "";}
if (isset($_POST[$obskey])) {$obs_ary[$i] = $_POST[$obskey];}
else {$obs_ary[$i] = "";}
if ((isset($POST[$itemkey]) and (is_array($_POST[$itemkey])))) {
$item_ary[$i] = implode(",",$_POST[$itemkey]);
}
$i++;
if (($_POST[$obskey] == "INTRST_PLSRE") or ($_POST[$obskey] == "PHQ2") ){
	if ($_POST[$itemkey] == "yes") {
	$phq9 = 1;
	}
}
}
$dc = 1;
if ($ptage > 79) {
$neg_obs_value = "The patient COMPLAINS OF:,";
$pos_obs_value = "The patient DENIES: ";
while ($dc <= $num_devs) {
$devitemkey = "devquestion_".$dc;
$dev_item = $_POST[$devitemkey];
$dev_key = explode ("|",$dev_item);
//echo $dev_item;
$dc++;

if ($dev_key[1] == "no") {
//add the value to postive obsterm
$pos_obs_value = $pos_obs_value.$dev_key[0].", ";
}
else{
//add the value to negative obsterm
//echo $dev_key[0].", ".$dev_key[1]."<br>";

$neg_obs_value = $neg_obs_value.$dev_key[0].", ";
$z++;
}
}
if ($z == 0) { $item_ary[$i] = " ";}
else {
$item_ary[$i] = $neg_obs_value.".";
}
}
else {
$neg_obs_value = "The patient DOES NOT:,";
$pos_obs_value = "The patient DOES: ";
while ($dc <= $num_devs) {
$devitemkey = "devquestion_".$dc;
$dev_item = $_POST[$devitemkey];
$dev_key = explode ("|",$dev_item);
//echo $dev_item;
$dc++;

if ($dev_key[1] == "yes") {
//add the value to postive obsterm
$pos_obs_value = $pos_obs_value.$dev_key[0].", ";
}
else{
//add the value to negative obsterm
//echo $dev_key[0].", ".$dev_key[1]."<br>";

$neg_obs_value = $neg_obs_value.$dev_key[0].", ";
$z++;
}
}
if ($z == 0) { $item_ary[$i] = " ";}
else {
$item_ary[$i] = $neg_obs_value.".";
}
}

$obs_ary[$i] = "DEV REVIEW";
$num_items++;
$i++;

$num_items++;

$item_ary[$i] = $pos_obs_value;
$obs_ary[$i] = "DEVTASK NOTE";

if ($num_devs == 0) {
$num_items = $num_items - 2;
}


//Echo $pos_obs_value."<br>";
//Echo $neg_obs_value."<br>";


 $mysqli = openMysqli();
$offset = 0;
$n = 1;
while ($n <= $num_items) {

 $obsname = $obs_ary[$n];
 if (is_array($item_ary[$n])) {
$itemvalue = implode(",",$item_ary[$n]);
}
 else {$itemvalue = $item_ary[$n];}
 $n++;
 //ECHO $itemvalue." | ".$obsname."<br>";
 if (($obsname == "question_1") or ($obsname == "question_2")){
 $query = "INSERT INTO `survey_results` (`mrn_pt`,`loc_care`, `question_num`, `question_answer`) VALUES ('$mr_number','$loc','$obsname','$itemvalue')";
 $offset++;
 }
 else{
 $query = "INSERT INTO `form_parts` (`mrn_pt`, `obs_term`, `obs_value`) VALUES ('$mr_number','$obsname','$itemvalue')";
 }
 $result = $mysqli->query($query);
  $err_msg = $mysqli->error;
}
if ($result == 1){
$success_status = "SUCCESSFUL";
$query = "Select * from form_parts where `mrn_pt` = '$mr_number' and `status` = '0'";
if ($aresult = $mysqli->query($query)) {
$row_cnt2 = $aresult->num_rows + $offset;
}
if (($row_cnt2 - $row_cnt1) <> $num_items) {
$success_status = "UNSUCCESSFUL, no data was written to the server. <br><br>Office staff, please make a note of this error.<br>This can be due to a temporary network or server interruption<b>You may want to try reloading the form and submitting it again";
}
ECHO "
<div style='font-family:lucida grande;position:absolute;left:30px'>
<H2>Thank you. Your submission was ".$success_status.".</h2>";
}
else{
 $err_msg = $mysqli->error;
ECHO "<h2>An error has occured and the data could not be submitted properly.  Please notify the Medical Assistant</h2>";
ECHO "Office staff, please make a note of this error message :".$err_msg."
</div>";
}

$mysqli->close();

// check to see if phq 9 is needed
If ($phq9 == 1){
$form_array[1] = 109;
echo "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<script type='text/javascript'>
window.history.forward();
function noBack(){ window.history.forward(); }
</script>
<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
<title>Patient data form</title>
<meta name='generator' content='HTPN PROGress - http://bhdahtpnptdata.bhcs.pvt'>
<style type='text/css'>
body
{
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<style type='text/css'>
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
<style type='text/css'>
#wb_Text1
{
   font-family:Lucida Grande;
   background-color: transparent;
   border: 0px #C0C0C0 solid;
}
#wb_Text2
{
   font-family:Lucida Grande;
   background-color: transparent;
   border: 0px #C0C0C0 solid;
}
#wb_Form1
{
   font-family:Lucida Grande;
   background-color: #05C5FF;
   border: 0px #000000 solid;
}

</style>
</head>
<body>";
//<div id='wb_Text2' style='margin:0px;position:absolute;left:40px;top:70px;width:880px;height:69px;text-align:left;z-index:16;border:0px #C0C0C0 solid;overflow-y:hidden;background-color:transparent;'>
//<div style='text-align:left'><span style='font-family:Lucida Grande;font-size:24px;'>";

ECHO "
</span></div>
</div>

<div id='wb_Form1' style='margin:0px;position:absolute;left:30px;top:70px;width:920px;font-family:'Lucida Grande';font-size:24px;color:#000000;'>

<form name='health_questionnaire' method='post' action='./commit_data3.php' enctype='multipart/form-data' id='Form1'>
<h2>Stop!&nbsp&nbspSome additional information is needed.</h2>";

if ($ptage > 143 and $ptage < 216) {

ECHO "There are personal questions of a personal nature on this form. We suggest that the patient answer these privately unles they want or need a parent's help.";
}
ECHO "
Based on the information you gave us we need to know more.&nbsp&nbspPlease change any selection needed to match your answer.
<input type='hidden' name='mrn' value='$mr_number'></input>";

   $mysqli = openMysqli();

	$item_number = 1;
	$i = 1;
	$dc = 0;

	while ($i <= (count($form_array)))  {
			$form_number = $form_array[$i];
			//Echo "Form number ".$form_number;
			$i++;
			if ($form_number == "6"){
			if ($ptage > 79){
			echo "<table style='padding:20;width:820px;font-size:24px'>";
			Echo "<tr><td><h4>Behavioral Health</h4></td></tr>";

		//do bahavioral questions here.
			$aquery = "SELECT `question`, `obsterm_value` FROM dev_questions where (('$ptage' between `age_minimum` and `age_maximum`) or `age_maximum` = '0')";
			if ($aresult = $mysqli->query($aquery)) {
			//if questions are returned, process them
			while ($arow = $aresult->fetch_assoc()) {
			//get each question from the row
			$dc++;
			Echo "<tr><td>".$arow["question"]."</td>";
			Echo "<td style=\"width:300px;font-family:'Lucida Grande';font-size:24px;\"><input type=\"radio\" name=\"devquestion_".$dc."\" value=\"".$arow["obsterm_value"]."|yes\" >&nbspyes &nbsp&nbsp&nbsp&nbsp ";
			Echo "<input type=\"radio\" name=\"devquestion_".$dc."\" value=\"".$arow["obsterm_value"]."|no\" checked=\"checked\">&nbspno</td></tr><tr></tr>";
			echo "</table>";

			}

			}
			}
			else {
			Echo "<tr><td><h4>Developmental Milestones</h4></td></tr>";
			//do developmental form here
			$aquery = "SELECT `question`, `obsterm_value` FROM dev_questions where (('$ptage' between `age_minimum` and `age_maximum`) or `age_maximum` = '0')";
			if ($aresult = $mysqli->query($aquery)) {
			//if questions are returned, process them
			while ($arow = $aresult->fetch_assoc()) {
			//get each question from the row
			$dc++;
				Echo "<tr><td>".$arow["question"]."</td>";
			Echo "<td style=\"width:300px;font-family:'Lucida Grande';font-size:24px;\"><input type=\"radio\" name=\"devquestion_".$dc."\" value=\"".$arow["obsterm_value"]."|yes\"checked=\"checked\" >&nbspyes &nbsp&nbsp&nbsp&nbsp ";
			Echo "<input type=\"radio\" name=\"devquestion_".$dc."\" value=\"".$arow["obsterm_value"]."|no\" >&nbspno</td></tr><tr></tr>";
			echo "</table>";
			}

			}
			}
}
			Else{
//do the normal health questionnaire forms here
			$aquery = "SELECT * FROM form_questions where `form_num` = '$form_number' and (('$ptage' between `age_minimum` and `age_maximum`) or `age_maximum` = '0') and (`sex_flag` =  '$ptsex' or `sex_flag` = '' or sex_flag is NULL) order by `form_name`,`id_num`";
		if ($aresult = $mysqli->query($aquery)) {
			$form_id_marker = "";
			//echo $item_number;
		echo "<table cellspacing = '20' style='width:820px;font-size:24px'>";
    	while ($arow = $aresult->fetch_assoc()) {
			if ($form_id_marker <> $arow["form_name"]) {

			ECHO "<tr><td><h4>".$arow["form_name"]."</h4></td></tr>";
			$form_id_marker = $arow["form_name"];
			}
       		$form_question = $arow["question_text"];
       		$opt_array = explode("|",$arow["option_items"]);
       		//echo count($opt_array);
       		$obs_array = explode("|",$arow["obs_values"]);
       		$inpt_type = $arow["input_type"];
       		ECHO "<tr><td>".$form_question."</td>";

       		if ($inpt_type == "DL") {
       		ECHO "<td><select name=\"item_".$item_number."\" tabindex=".$item_number." style=\"width:300px;font-family:'Lucida Grande';font-size:24px;\">";
			$n = 0;
			while ($n < count($opt_array))  {
			echo "<option value = \"".$obs_array[$n]."\">".$opt_array[$n]."</option>" ;
			$n++;
			}
			//echo "</td></tr>";

			ECHO "<input type = \"hidden\"  name = \"obs_".$item_number."\" value = \"".$arow["obs_term"]."\">
			</td></tr>";
			$item_number++;

}
       		if ($inpt_type == "CB") {
			$n = 0;
			echo "<td>";
			while ($n < count($opt_array))  {
			echo "<input type='checkbox' name=\"item_".$item_number."[]\" value = \"".$obs_array[$n]."\">".$opt_array[$n]."</input>" ;
			$n++;
			}
			ECHO "<input type = \"hidden\"  name = \"obs_".$item_number."\" value = \"".$arow["obs_term"]."\">
			</td></tr>";
			$item_number++;
			}
			}
			 ECHO "</table>";
			}
			}

    }


    $num_items = $item_number - 1;
    //post number of questionaire items and developmental items for the commit page
    ECHO "<input type=\"hidden\" name=\"num_items\" value=\"$num_items\">";
    ECHO "<input type=\"hidden\" name=\"num_devs\" value=\"$dc\">";
    ECHO "<input type=\"hidden\" name=\"pt_age\" value=\"$ptage\">";
    ECHO "<input type=\"hidden\" name=\"pt_sex\" value=\"$ptsex\">";
        ECHO "<input type=\"hidden\" name=\"loc\" value=\"$loc\">";

  /* close connection */
$mysqli->close();

Echo "<div style='font-size:24px'>
<H4>Really, the last button!</H4>
<table style='cellspacing:20px;position:absolute;left:10px:width:820px;font-size:24px'><tr><td style='width:460px;font-size:24px'>
Return the device to the office staff after clicking 'SUBMIT'.</td>
 <td style='text-align:center;width:240px'>
<INPUT type='submit' style='font-family:Lucida Grande;font-size:24px;width:200px;height:64px' value=' SUBMIT '/>
</td></tr>
</table>
</form>
<br>
<br>
<br/>
Thanks again for using the HTPN PROGress tool.
</div>";

}
//add the ending items.
Else {
Echo "<br><H2>Please return the device to the office staff.</H2>
 <br><br><br><br>
<table style='top:400px;width:600px;text-align:center'>
<tr><td ><img src='./id2_htpn.jpg' alt='HTPN Logo'></td>
<td><br><br><img src='./BSWH_Logo_RGB_210.jpg' alt='PROGress'></td>
</tr>
</table>
<br>
<br>
<form name='health_questionnaire' method='post' action='./login.php' enctype='multipart/form-data' id='Form2'>
<INPUT type='submit' style='font-family:Lucida Grande;font-size:24px;width:200px;height:64px' value='PROGress login'/>
";


}
?>