

<?php
require './toolbox.php';
if (isset($_GET["mssg"])){
$mssgstrng = $_GET["mssg"];
}
else {
$mssgstrng = "Please log in:";
}
if (isset($_COOKIE["htname"])) {
$usrnm = $_COOKIE["htname"];
//echo "cookie OK";
}
elseif (isset($_GET["usrn"])){
$usrnm = $_GET["usrn"];
//echo "no cookie!";
}
else
{$usrnm = "";}
if (isset($_COOKIE["loc"])) {
$loc= $_COOKIE["loc"];
}
elseif (isset($_GET["loc"])){
$loc = $_GET["loc"];
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
<title>PROGress login - HTPN</title>
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
ECHO"
<table style='font-family:lucida grande;font-size:20px;width:800px;position:absolute;left:30px;top:142px'>
<tr><td><b>$mssgstrng</b></td>
<td style='text-align:right'><a href=\"http://progress.screenstepslive.com/s/9044/m/28403\" target='_blank'>PROGress Manual</a></td></tr></table>
<div id=\"wb_Form1\" style=\"font-family:Lucida Grande;font-size:24px;position:absolute;left:30px;top:170px;width:920px;height:400px;z-index:2;\">
<form name=\"Patient_select\" method=\"post\" action=\"./checkpwd.php\" enctype=\"multipart/form-data\" id=\"Form1\">
<div id=\"wb_Text1\" style=\"font-family:Lucida Grande;font-size:24px;margin:10;padding:0;position:absolute;left:20px;top:15px;width:92px;height:200px;text-align:left;z-index:0;border:0px #C0C0C0 solid;overflow-y:hidden;background-color:transparent;\">
<div style=\"font-family:Lucida Grande;font-size:13px;color:#000000;\">
<div style=\"text-align:left\">Location: <br><br><br><br><br>Username:<br><br><br>Password:</div>
</div>
</div>
<select name=\"loc\" size=\"1\" id=\"loc\" style=\"font-size:24px;position:absolute;left:107px;top:15px;width:400px;height:32px;z-index:1;\">";
if ((isset($loc)) and ($loc<>"")){
echo "<option value='$loc'>$loc</option>";
}
else {
echo "<option value=''>Choose LOC from this list:</option>";
}
$mysqli = openMysqli();

$query = "SELECT DISTINCT `loc_care` FROM name_table ORDER BY `loc_care`";


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
<input type='text' name='usrn' value='$usrnm' maxlength='16' style='font-size:18px;position:absolute;left:107px;top:94px;height:24px'><br><br>
<input type='password' name='psswrd' maxlength='16' style='font-size:24px;position:absolute;left:107px;top:140px;height:24px'><br>
<input type='submit' name='Log in' value='Log in' style='font-size:24px;position:absolute;left:107px;top:190px;height:32px;width:140px'>
</form>
</div>
</body>
</html>
";

?>