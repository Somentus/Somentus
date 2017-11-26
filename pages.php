<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

function Pages(){
	$pages = query($pdo, "SELECT name FROM pages ORDER BY name ASC ");
	$i = 1;
	if (count($pages) == 0 ) {
		echo "There are no pages :(";
	} else {
		foreach($pages as $page) {
			$_SESSION['pagename'] = $page['name'];
			echo $i.". <a class='right_side' href='page.php?pagename=".$_SESSION['pagename']."'>".$_SESSION['pagename']."</a><br><br>";
			$i++;
			//echo "<a href=\"user.php?keywords=$_SESSION['keywords']\">$_SESSION['keywords']</a><br><br>";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - Pages</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/users.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<?php persons_left($pdo); ?>
		</aside>
		
		<section class="right_side">
			<div id="generalform">
				<?php Pages(); ?>
			</div>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>