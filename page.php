<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) /*OR !isset($_SESSION['pagename'])*/ ){
	header('Location:login.php'); // Indien ingelogd word je doorgestuurd naar account.php
}

if (isset($_GET['pagename']) && !empty($_GET['pagename'])){
	$_SESSION['pagename'] = $_GET['pagename'];
	//$page_admin_check = mysql_query("SELECT * FROM pages WHERE admin='$_SESSION[username]' ") or die(mysql_error()); WORKING ON THIS!!!!	
}

function EchoContent(){
	$content_bodies = query($pdo, "SELECT body FROM content WHERE name = :keywords ORDER BY id DESC ", ['keywords' => $_SESSION['keywords'] ]);
	if ( count($content_bodies) == 0 ) {
		echo "This user did not post content.";
	} else {	
		foreach($content_bodies as $content) {
			$content_body = $content["body"];
			echo $content_body."<br><br><hr><br><br>";
		}
	}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - <?php echo $_SESSION['pagename']; ?></title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/account.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<?php persons_left($pdo); ?>
		</aside>
		
		<section id="right_side">
			<?php echo $error_message; EchoContent(); ?>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>		