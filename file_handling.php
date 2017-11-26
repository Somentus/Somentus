<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
/*
w = writing
r = reading
a = appending


$handle = fopen('users/123emmer.php', 'a');
//fwrite($handle, 'Steven');

//fclose($handle);

echo 'Current names in file: ';

$count = 1;
$readin = file('users/123emmer.php');
$reading_count = count($readin);
foreach($readin as $fname) {
	echo trim($fname).', ';
	if ($count <= $readin_count) {
		echo ', ';
	}
	$count++;
}
*/

$handle = fopen('/users/123emmer.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Somentus - File Handling</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			
		</aside>

		<section id="right_side">
		
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>