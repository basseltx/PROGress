<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Select Questionnaires</title>
<meta name="generator" content="Paul Bassel,MD">
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


</style>
</head>
<body>
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
<br>
<div id="wb_Form1" style="font-family:Lucida Grande;font-size:24px;position:absolute;left:30px;top:170px;width:920px;height:500px;z-index:2;">
<form name="question_select" method="post" action="./createform.php" enctype="multipart/form-data" id="Form1">
<table style='font-family:lucida grande;width:800px;position:absolute;left:20px'>
<tr><td><b>Enter patient's MRN and age</b></td>
</tr></table>
<br></br>
<br>Confirm or select the patient entry items needed:<br><br>
MRN <input style="font-family:Lucida Grande;font-size:24px;" size="12" maxlength="10" type="text" name="MRN">
&nbspPt. Age <input style="font-family:Lucida Grande;font-size:24px;" size="3" maxlength="3" type="text" name="pt_age">&nbsp<input style="transform: scale(2);" type="radio" name="age_unit" value="mo">&nbsp&nbspmonths
<input style="transform: scale(2);" type="radio" name="age_unit" value="yr">&nbsp&nbspyears<br><br>
Select the questionnaires needed for visit:<br><br>
<input style="position:absolute;left:20px;transform:scale(2);" type="checkbox"  name="option1" value="1">
&nbsp&nbsp&nbsp&nbsp&nbspAsthma Questionnaire<br>
<input style="position:absolute;left:20px;transform:scale(2);"  type="checkbox"  name="option2" value="7"> &nbsp&nbsp&nbsp&nbsp&nbspMCHAT<br>
<input style="position:absolute;left:20px;transform:scale(2);"  type="checkbox"  name="option3" value="2"> &nbsp&nbsp&nbsp&nbsp&nbspWell Child<br>
<br>
<input style="position:absolute;left:30px;transform:scale(2);" type="submit" value="Submit">
</form>
</div>
</body>
</html>

