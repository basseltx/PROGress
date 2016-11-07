<?PHP


require './toolbox.php';


$ptsex="";
$i = 1;


if (isset($_POST["MRN"])){
	$MRN = $_POST['MRN'];
	}
if (isset($_POST["pt_age"])){
	$ptage = $_POST['pt_age'];
	}

if (isset($_POST["age_unit"])){
	$age_unit = $_POST['age_unit'];
	}

if ($age_unit == "yr"){
$ptage= $ptage*12;
}
$item_total=3;

while ($i <= $item_total) {
$itemkey = "option".$i;
	if (isset($_POST[$itemkey])) {
	$form_array[$i] = $_POST[$itemkey];
	}
	else {
	$form_array[$i] = 0;
	}
$i++;
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript">
window.history.forward();
function noBack(){ window.history.forward(); }
</script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Patient form - powered by PROGress Lite</title>
<meta name="generator" content="Quick 'n Easy Web Builder - http://www.quickandeasywebbuilder.com">
<style type="text/css">
body
{
   background-color: #ffffff;
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
#wb_Text1
{
   background-color: transparent;
   border: 0px #000000 solid;
}
#wb_Text2
{
   background-color: transparent;
   border: 0px #000000 solid;
}
#wb_Form1
{
   background-color: #ffffff;
   border: 0px #000000 solid;
}

</style>
</head>
<body>
<div style="text-align:left">
<img src='./BSWH_Logo_RGB_210.jpg' alt='PROGress'>
<hr style='position:absolute;top:50px;left:30px;width:920px'>

</div>
<div id="wb_Text2" style="margin:0;position:absolute;left:60px;top:60px;width:900px;height:69px;text-align:left;z-index:16;border:0px #C0C0C0 solid;overflow-y:hidden;background-color:transparent;">
<div style="text-align:left"><span style="font-family:Lucida Grande;font-size:10px;">
<?php ECHO "Patient Information MRN: ".$MRN." &nbsp&nbspAge(in months): ".$ptage; "<br>";
//print_r($form_array);
?>
</span></div>
</div>

<div id="wb_Form1" style="margin:0px;position:absolute;left:30px;top:80px;width:920px;z-index:17;font-family:'Lucida Grande';font-size:10px;color:#000000;">

<form name="health_questionnaire" method="post" action="./commit_data3.php" enctype="multipart/form-data" id="Form1">
Please complete the information below about the patient.  Thank you!
<br>
<?php
if ($ptage > 143 and $ptage < 216) {

ECHO "There are personal questions of a personal nature on this form. We suggest that the patient answer these privately unles they want or need a parent's help.";
}

   $mysqli = openMysqli();

	$item_number = 1;
	$i = 1;
	$dc = 0;
	$rbc = 0;

	while ($i <= (count($form_array)))  {
			$form_number = $form_array[$i];
			//Echo "Form number ".$form_number;
			$i++;
			$aquery = "SELECT * from `form_questions` where `form_num` = '$form_number' and (('$ptage' between `age_minimum` and `age_maximum`) or `age_maximum` = '0') and (`sex_flag` =  '$ptsex' or `sex_flag` = '' or sex_flag is NULL) order by `id_num`,`form_name`";
		if ($aresult = $mysqli->query($aquery)) {
			$form_id_marker = "";
			//echo $item_number;
		echo "<table cellspacing = '20' style='width:820px;font-size:10px'>";
    	while ($arow = $aresult->fetch_assoc()) {
    	//print_r($arow);
    	//echo "<br>";
			if ($form_id_marker <> $arow["form_name"]) {

			ECHO "<tr><td><b>".$arow["form_name"]."</b></td></tr>";
			$form_id_marker = $arow["form_name"];
			}
       		$form_question = $arow["question_text"];

       		$opt_array = explode("|",$arow["option_items"]);
       		//echo count($opt_array);
       		$obs_array = explode("|",$arow["obs_values"]);
      // /*
      	if ($opt_array[0] == "*table" ){
       		//"*table" signifies tells PROGress to look up option values in the table specified in the second part of the data.
       		$tablename = $opt_array[1];
       		$columnname = $opt_array[2];
       		$query_string = $opt_array[3];
       		$order_param = $opt_array[4];
       		$select_string = $opt_array[5];
       		$query = "select $select_string from pt_data.$tablename where `$columnname` = '$query_string' order by $order_param";
       		if ($result = $mysqli->query($query)) {
       		$n = 0;
       		unset($opt_array);
       		unset($obs_array);
       		while ($row = $result->fetch_assoc()){
       		$opt_array[$n] = implode(" ",$row);
       		$obs_array[$n] = $opt_array[$n];
       		$n++;
       		}
       		}
			}
			//*/
       		$inpt_type = $arow["input_type"];
       		if ($inpt_type=="DL") {$inpt_type = "CB";}
       		ECHO "<tr><td valign='top' width='480'>".$form_question."</td>";
       		/*	This is the ROS section */
    //ROS category prints above (form_name)
	//set radio button counter $rbc = 0 (above)
	//if input type RB
	       	if ($inpt_type == "RB") {
	       	$rbc++;
	       	$data_identifier_rb = $arow["data_identifier"];
			Echo "<td style=\"width:300px;font-family:'Lucida Grande';font-size:10px;\"><input type=\"radio\" name=\"RadioButtonAnswer".$rbc."\" id=\"RadioButtonAnswer".$rbc."yes\" value=\"".$obs_array[0]."|yes|".$data_identifier_rb."\" ><label for=\"RadioButtonAnswer".$rbc."yes\">yes&nbsp&nbsp&nbsp</label> ";
			Echo "<input type=\"radio\" name=\"RadioButtonAnswer".$rbc."\" id=\"RadioButtonAnswer".$rbc."no\" value=\"".$obs_array[0]."|no|".$data_identifier_rb."\" checked=\"checked\"><label for=\"RadioButtonAnswer".$rbc."no\">no</label></td></tr><tr></tr>";

	/*symptom choice question = $form_question (example "Fever") yes or no
	build each answer as RadioButtonAnswer[$rbc] with with value=$obs_array[$n] | yes or no | target obsterm ($arow["data_identifier"])
	example: fever|yes|ROS:GENERAL
	$rbc increments
	fetchdata will parse the answers into correct format.
	when done post hidden variable num_RB with value $rbc (below)
	*/
	}



       		if ($inpt_type == "DQ") {
       		ECHO "<td style='width:340px'><select name=\"item_".$item_number."\" tabindex=".$item_number." style=\"width:300px;font-family:'Lucida Grande';font-size:10px;\">";
       		echo "<option value='none'>none</option>";
			$n = 0;
			while ($n < count($opt_array))  {
			echo "<option value = \"".$obs_array[$n]."\">".$opt_array[$n]."</option>" ;
			$n++;
			}
			echo "<option value='other'>other</option>";
			//echo "</td></tr>";

			ECHO "<input type = \"hidden\"  name = \"obs_".$item_number."\" value = \"".$arow["data_identifier"]."\">
			</td></tr>";
			$item_number++;

}
if ($inpt_type == "HD") {
       		ECHO "<td style='width:340px'><select name=\"item_".$item_number."\" tabindex=".$item_number." style=\"width:300px;font-family:'Lucida Grande';font-size:10px;\">";

		echo"</td></tr>";
			}
       		if ($inpt_type == "DL") {
       		ECHO "<td style='width:340px'><select name=\"item_".$item_number."\" tabindex=".$item_number." style=\"width:300px;font-family:'Lucida Grande';font-size:10px;\">";
			$n = 0;
			while ($n < count($opt_array))  {
			echo "<option value = \"".$obs_array[$n]."\">".$opt_array[$n]."</option>" ;
			$n++;
			}
			//echo "</td></tr>";

			ECHO "<input type = \"hidden\"  name = \"obs_".$item_number."\" value = \"".$arow["data_identifier"]."\">
			</td></tr>";
			$item_number++;

}
       		if ($inpt_type == "CB") {
       		if ($opt_array[0]=="yes"){
       					$n = 0;
       					echo "<td>";
						while ($n < 2)  {
			echo "<input type='checkbox' id='item_".$item_number."-$n' name=\"item_".$item_number."[]\" value = \"".$obs_array[$n]."\"></input><label for='item_".$item_number."-$n'>&nbsp$opt_array[$n]</label> &nbsp&nbsp";
			$n++;

			}
			echo "</td>";
			}
			else {
			$n = 0;
			echo "<td><table style='width:340px'>";
			while ($n < count($opt_array))  {
			echo "<tr><td><input type='checkbox' id='item_".$item_number."-$n' name=\"item_".$item_number."[]\" value = \"".$obs_array[$n]."\"></input><label for='item_".$item_number."-$n'>&nbsp$opt_array[$n]</label>";
			echo "</td></tr>" ;
			$n++;

			}
			ECHO "</table>";
			}
			echo "</td></tr>";

			$item_number++;
			}


			if ($inpt_type == "OB") {
			$n = 0;
			$c = $item_number;
			$total_items = count($opt_array);
			echo "<td><table style='width:340px'>";
			echo "<tr><td><input id='item$c-$n' onclick='uncheck$c()' type='checkbox' name=\"item_".$item_number."[]\" value = \"".$obs_array[$n]."\"></input><label for='item$c-$n'>$opt_array[$n]</label>";
			$n++;
			while ($n < count($opt_array))  {
			echo "<tr><td><input id='item$c-$n' type='checkbox' onclick='check$c()' name='item_".$item_number."[]' value = '$obs_array[$n]'></input><label for='item$c-$n'>$opt_array[$n]</label>";

			echo "</td></tr>" ;
			$n++;
			}
			echo "<script>
					function check$c(){
					  document.getElementById('item$c-0').checked=false
					}

					function uncheck$c(){
					var cbfn
					var it
					var eid
					for (it = 1; it < $total_items; it++) {
					eid = 'item$c-' + it
					cbfn = document.getElementById(eid)
					cbfn.checked=false
					}

					}
					</script>";

			ECHO "</table><input type = \"hidden\"  name = \"obs_".$item_number."\" value = \"".$arow["data_identifier"]."\">
			</td></tr>";
			$item_number++;
			}

			}
			 ECHO "</table>";
			}
			}



    $num_items = $item_number - 1;
    //post number of questionaire items and developmental items for the commit page

  /* close connection */
$mysqli->close();
?>
<H4>Thank you!</H4>
<table style="cellspacing:20px;position:absolute;left:10px:width:820px;font-size:10px'"><tr><td style="width:460px;font-size:10px">
Return this form to your medical assistant</td>
</tr>
</table>
</form>
</div>
</body>
</html>


