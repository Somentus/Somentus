<?php
session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(isset($_GET['x'])){
	$x = $_GET['x'];
}else{
	header('Location:index.php');
}

function createMessage($x){
	if(is_numeric($x)){
		switch($x){
			case 0:
				$message = "Your account is now active. You may now <a href=\"login.php\">log in.</a.";
				break;
			case 1:
				$message = "Thank you for registering. A confirmation email has been sent to your email. Please click on the activation link to active your account.";
				break;
			case 2:
				$message = "That email address or username has already been registered.";
				break;
			case 3:
				$message = "Error, please contact systemadmin!";
				break;
			case 4:
				$message = "Your bug was succesfully submitted.";
				break;
			case 5:
				$message = "You were succesfully logged out.";
				break;
			case 6:
				$message = "Content was succesfully posted.";
				break;
			case 7:
				$message = "Information was succesfully inserted into database.";
				break;
			case 8:
				$message = $_SESSION['friend_name']." received your friendrequest.";
				break;
			/*case 9:
				$message = "You are already friends.";
				break;*/
			case 10:
				$message = "That username doesn't exist. Check the <a href=\"users.php\">userlist</a> for a complete list of all users.";
				break;
			/*case 11:
				$message = "Your passwords did not match, please try again.";
				break;*/
			case 12:
				$message = "Your password was succesfully changed.";
				break;
			/*case 13:
				$message = "Please enter a new password.";
				break;*/
			/*case 14:
				$message = "Please repeat your new password.";
				break;*/
			case 15:
				$message = "Your emailaddress was succesfully changed.";
				break;
			/*case 16:
				$message = "Your emailadresses did not match, please try again.";
				break;*/
			/*case 17:
				$message = "Please enter a new emailaddress.";
				break;*/
			/*case 18:
				$message = "Please repeat your new emailaddress.";
				break;*/
			case 19:
				$message = "An email has been sent to you with your login-data.";
				break;
			case 20:
				$message = "User was succesfully added to your friendlist.";
				break;
			case 21:
				$message = "You succesfully declined the friendrequest.";
				break;
			case 22:
				$message = "You succesfully cancelled the friendrequest.";
				break;
			case 23:
				$message = "You already liked that post.";
				break;
			case 24:
				$message = 'You do not own that comment.';
				break;
			case 25:
				$message = 'Your comment was succesfully deleted.';
				break;
		}
		
		echo $message;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Prompt</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/prompt.css">
</head>
<body>
	<div id="wrapper">
	<?php headerAndSearchCode($pdo); ?>
		
		<div id="outer">
			<div id="inner">
				<?php createMessage($x); ?>
			</div>
		</div>
	
	<?php footerCode(); ?>
	</div>
</body>
</html>