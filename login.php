<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if( isset($_SESSION['user_id']) ){
	header('Location:account.php');
}

login($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Log In</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<img src="images/login.png" />
		</aside>
		
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="">
				<h3>Log In</h3>
				<?php if(isset($error_message)){echo $error_message;} ?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" class="input" name="username" maxlength="20" placeholder="Username" required />
				</div>
				<br><br><br>
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" class="input" name="password" maxlength="100" placeholder="Password" required/>
				</div>
				<br><br>
				<input type="submit" name="submit" id="submit" class="button" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>