<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
include("includes/register.php");

Register($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Register</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/register.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<img src="images/registerbanner.png" />
		</aside>
		
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="">
				<h3>Register</h3>
				<?php if(isset($error_message)){echo $error_message;} ?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" class="input" name="username" maxlength="20" placeholder="Username" required />
					<p class="hint">20 characters maximum (letters and numbers only)</p>
				</div>
				<br><br><br>
				<div class="field">
					<label for="email">Email:</label>
					<input type="text" class="input" name="email" maxlength="80" placeholder="you@domain.com" required />
				</div>
				<br><br><br>
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" class="input" name="password" maxlength="20" placeholder="Password" required />
					<p class="hint">20 characters maximum</p>
				</div>
				<br><br>
				<input type="submit" name="submit" class="button" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>