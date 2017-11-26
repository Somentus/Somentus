<?php
$connect = mysql_connect('mysql2.000webhost.com','a9862957_som','Joperli1');

if(!$connect){
	die('Could not connect <br />'.mysql_error());
}

$db_selected = mysql_select_db("a9862957_som");
if (!$db_selected){
	die('Could not select database'.mysql_error());
}
?>