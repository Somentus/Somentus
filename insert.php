<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
include("includes/register.php");

if(isset($_POST['submit'])){
	$result = query($pdo, " INSERT INTO friends (id, id_1, id_2) VALUES ('', '26', '6')");
	if(!$result){
		die('Could not insert into database: '.mysql_error());
	}else{
		header('Location: prompt.php?x=7');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - Insert</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			
		</aside>

		<section id="right_side">
			<form id="generalform" method="post" action="">
				<input type="submit" name="submit" id="submit" class="button" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>