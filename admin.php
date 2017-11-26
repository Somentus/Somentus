<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(isset($_SESSION['admin_id'])){
	header('Location:adminpanel.php');
}

if(isset($_POST['submit'])){
	$error = array();
	
	//adminname
	if(empty($_POST['adminname'])){
		$error[] = 'Please enter a adminname. ';
	}else if( ctype_alnum($_POST['adminname']) ){
		$adminname = $_POST['adminname'];
	}else{
		$error[] = 'Adminname must consist of letters and numbers only. ';
	}
	
	//password
	if(empty($_POST['password'])){
		$error[] = 'Please enter a password. ';
	}else{
		$pre_password = $_POST['password'];
		$password = $_POST['password'];
	}
	
	if(empty($error)){
		$result = query($pdo, "SELECT * FROM admin WHERE adminname = :adminname AND password = :password ", ['adminname' => $adminname, 'password' => $password]);
		if(count($result)==1){
			$user = $result[0];
			$_SESSION['admin_id'] = $user['admin_id'];
			$_SESSION['adminname'] = $user['adminname'];
			date_default_timezone_set('Europe/Amsterdam');
			$login_time = date("jS F, Y, G:i");
			$login_insert = query($pdo, "UPDATE admin SET login = :login_time WHERE id= :admin_id ", ['login_time' => $login_time, 'admin_id' => $admin_id]);
			header('Location:admin.php');
		}else{
			$error_message = '<span class="error">Username or password is incorrect.</span><br /><br />';
		}
	}else{
		$error_message = '<span class="error">';
		foreach($error as $key => $values){
			$error_message.= "$values";
		}
		$error_message.="</span><br/><br/>";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Admin</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div id="wrapper">';
	<?php headerAndSearchCode($pdo); ?>
	<aside id="left_side">
		<img src="images/login.png" />
	</aside>

	<section id="right_side">
		<form id="generalform" class="container" method="post" action="">
			<h3>Log In</h3>
			<?php if(isset($error_message)){echo $error_message;} ?>
			<div class="field">
				<label for="adminname">Admin:</label>
				<input type="text" class="input" name="adminname" maxlength="20" placeholder="Adminname" required />
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