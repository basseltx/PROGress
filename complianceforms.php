<?php



$uri="https://www.mybaylor.com/htpn/departments/compliance/_vti_bin/listdata.svc/Forms()";



$cat_choice="Compliance";
$lang_choice="All";
if (isset($_POST["category"])){
$cat_choice = $_POST["category"];
}
if (isset($_POST["language"])){
$lang_choice = $_POST["language"];
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
    curl_setopt($curl, CURLOPT_USERPWD, "HTPNCompliance_SVC:26z6cJCJ");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function parsData($input,$n){
	$localfile = Array();
	$localfile= explode("|",$input);
	return $localfile;
	}
	?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Compliance forms</title>
<style type="text/css">
body
{
   padding:5px;
   line-height:20px;
   background-color: #FFFFFF;
   color: #000000;
   font-family: Arial;
   font-size: 14px;
}
</style>
</head>

<body>

<?php
$response = CallAPI("GET",$uri);

$doc = new DOMDocument();
$doc->loadXML($response);
$cat = $doc->getElementsByTagName('ComplianceCategoriesValue');

$Name = $doc->getElementsByTagName('Name');
//$title = $doc->getElementsByTagName('Title');
$path = $doc->getElementsByTagName('Path');
$lang= $doc->getElementsByTagName('BaylorLanguageValue');
$x = $cat->length;

echo "
<h3>HTPN Compliance forms (consents,etc.)</h3>
Note: .doc or .docx files will open in Microsoft Word on your client. To print, use the menu item File/Print.
<form name=\"Select category and language\" method=\"post\" action=\"./complianceforms.php\" enctype=\"multipart/form-data\" id=\"Form1\">
<select name=\"category\" size=\"1\" id=\"category\" >
<option value=\"$cat_choice\">Category: $cat_choice</option>
<option value=\"Compliance\">Category: Compliance</option>
<option value=\"HIPAA\">Category: HIPAA</option>
</select>
<select name=\"language\" size=\"1\" id=\"language\" >
<option value=\"$lang_choice\">Language: $lang_choice</option>
<option value=\"All\">Language: All</option>
<option value=\"English\">Language: English</option>
<option value=\"Spanish\">Language: Spanish</option>
</select>
<input type=\"submit\" value=\"Display\">
</form>";

$file_list = Array();
$file = Array();


	$needle = "spanish";
for ($i=0;$i<$x;$i++) {
	//$file[$i]category=$Category[$i]->nodeValue;
	$link="https://www.mybaylor.com".$path->item($i)->nodeValue."/".$Name->item($i)->nodeValue;
	$language=$lang->item($i)->nodeValue;
	$haystack=$Name->item($i)->nodeValue;
	$langresult = stripos($haystack,$needle);
	if ($langresult>0){
	$language = "Spanish";
	}
	$file_list[$i]=$cat->item($i)->nodeValue."|".$language."|".$Name->item($i)->nodeValue."|".$link;
	//Echo $file_list[$i];
	}

echo "
<a target='main_iframe' href='./addtional_forms/Ortho Supply Waiver.pdf'>Ortho Supply Waiver.pdf</a>
<br>
<a target='main_iframe' href='./addtional_forms/Spacer-Neb tubing waiver.pdf'>Spacer-Neb tubing waiver.pdf</a>
<br>
<a target='main_iframe' href='./addtional_forms/VTR-214.HandicapPlacardLicense.pdf'>TX Handicapped Parking.pdf</a>
<br>
";
if ($lang_choice=="Spanish"){
for ($i=0;$i<$x;$i++) {
    $file=parsData($file_list[$i],$i);

    if (($file[0]==$cat_choice) and ($file[1]=="Spanish")) {
   echo " <a href='".$file[3]."'>".$file[2]."</a><br>";
    }

}
}
elseif ($lang_choice=="English"){
for ($i=0;$i<$x;$i++) {
$file=parsData($file_list[$i],$i);
    if ($file[0]==$cat_choice and ($file[1]<>"Spanish")) {
   echo " <a href='".$file[3]."'>".$file[2]."</a><br>";;
    }

}
}
 else {
 for ($i=0;$i<$x;$i++) {
 $file=parsData($file_list[$i],$i);
    if ($file[0]==$cat_choice) {
   echo " <a href='".$file[3]."'>".$file[2]."</a><br>";;
    }
    }
  }
?>
</body>