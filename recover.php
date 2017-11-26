<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if( isset($_SESSION['user_id']) ){
	header('Location:account.php');
}

if(isset($_POST['recover'])){
	$error = array();
	if(empty($_POST['email'])){
		$error[] = 'Please enter your emailaddress. ';
	}else if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
		$email = $_POST['email'];
	}else{
		$error[] = 'Your emailaddress is invalid. ';
	}
	if(empty($error)){
		$recovery_data = query($pdo, "SELECT * FROM users WHERE email= :email ", ['email' => $email]);
		var_dump($recovery_data);
		if( count($recovery_data) == 1 ){
			$message = "You have asked us to recover your data for you. Your username is: \n\n";
			$username_thingy_raw = query($pdo, "SELECT username FROM users WHERE email = :email ", ['email' => $email])[0];
			$username_thingy = $row["username"];
			$message .= $username_thingy;
			$message .= "\n\n Your password has been reset to: ";
			$pass_new = md5(uniqid(rand(), true));
			$pass_new_md5 = md5($pass_new);
			$pass_new_insert = query($pdo, "UPDATE users SET password = :pass_new_md5 WHERE email = :email ", ['pass_new_md5' => $pass_new_md5, 'email' => $email]);
			if(!$pass_new_insert){
				$error[] = "#SWAG ERROR 1";
				header('Location:prompt.php?x=3');
			}else{
				$message .= $pass_new;
			}
			mail($email, 'Data recovery', $message);
			header('Location: prompt.php?x=19');
		}else{
			$error[]= "There is no account with that emailaddress.";
		}
	}else{
		$error_message = '<span class="error">';
		foreach($error as $key => $values){
			$error_message.= "$values";
		}
		$error_message.="</span><br/><br/>";
	}
}
if(!empty($error)){
	$error_message = '<span class="error">';
	foreach($error as $key => $values){
		$error_message.= "$values";
	}
	$error_message.="</span><br/><br/>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Recover data</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/recover.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<img src="images/recover_data.jpg" width="400" />
		</aside>
		
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="">
				<h3>Recover data</h3>
				<?php if(isset($error_message)){echo $error_message;} ?>
				Forgot your password? Can't remember your username? Don't worry! <br>As long as you know the emailaddress you used to register your account, you can recover your username or reset your password.<br><br>
				<div class="field">
					<label for="email">Emailaddress:</label>
					<input type="text" class="input" name="email" placeholder="Emailaddress" required />
				</div>
				<div id="button_center">
					<input type="submit" name="recover" id="submit" class="button" value="Submit"/>
				</div>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>