<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

if(isset($_POST['submit'])){
	$error = array();
	
	if(empty($_POST['content'])){
		$error[] = 'Please enter content. ';
	}else{
		$content = $_POST['content'];
	}
	
	if(empty($error)){
		date_default_timezone_set('Europe/Amsterdam');
		$date = date("jS F, Y, G:i");  
		$result = query($pdo, "INSERT INTO content (id, name, body, date, comments) VALUES ('', :username, :content, :date, '0') ", ['username' => $_SESSION[username], 'content' => $content, 'date' => $date]);
		if(!$result){
			die('Could not insert into database: '.mysql_error());
		}else{
			header('Location:user.php?keywords='.$_SESSION['username']);			
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
	<title>Somentus - Post content</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/account.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside>
			<?php persons_Left($pdo); ?>
		</aside>

		<section id="right_side">
			<form id="generalform" method="POST" action="">
				<h3>Post content</h3>
				<div class="field">
				<textarea type="text" class="input" id="content" name="content" maxlength="5000" rows="10" required ></textarea>
				</div>
				<input type="submit" name="submit" id="submit" class="button" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>