<?php
$connection ="\"127.0.0.1\", \"php\", \"PHP!23php\", \"epic_questions\"";

function openMysqli()
{
	// (1) Open the database connection
   $dbcon = new mysqli("127.0.0.1", "php", "PHP!23php", "epic_questions");
   if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: (" . $dbcon->connect_errno . ") " . $dbcon->connect_error;
	}
return $dbcon;
}
$item_total = 13;

?>