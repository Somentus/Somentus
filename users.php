<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

function Users($pdo){
	$users = query($pdo, "SELECT username FROM users ORDER BY username ASC ");
	$i = 1;
	if (count($users) == 0 ) {
		echo "There are no users :(";
	} else {
		foreach($users as $user) {
			$keywordss = $user['username'];
			echo $i.". <a class='right_side' href='user.php?keywords=".$keywordss."'>".$keywordss."</a><br><br>";
			$i++;
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - Users</title>
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
				<?php Users($pdo); ?>
			</div>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>