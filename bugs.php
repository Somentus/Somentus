<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(isset($_POST['submit'])){
	$error = array();
	
	// Name
	if(empty($_POST['name'])){
		$error[] = 'Please enter a name. ';
	}else if( ctype_alnum($_POST['name']) ){
		$name = $_POST['name'];
	}else{
		$error[] = 'Name must consist of letters and numbers only. ';
	}
	
	
	//Email
    if(empty($_POST['email'])){
        $error[] = 'Please enter your email. ';
    }else if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
		$email = $pdo->quote($_POST['email']);
    }else{
		$error[] = 'Your e-mail address is invalid. ';
    }
	
	//bug
	if(empty($_POST['bug'])){
		$error[] = 'Please enter a bug. ';
	}else{
		$bug = $_POST['bug'];
	}

	//post
	if(empty($error)){
		$result2 = query($pdo, " INSERT INTO bugs (bug_id, name, email, bug) VALUES ('', :name, :email, :bug) ", ['name' => $name, 'email' => $email, 'bug' => $bug]);
		header('Location:prompt.php?x=4');
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
	<title>Bugs</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/register.css">
	<link rel="stylesheet" href="css/bugs.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<img src="images/bugs.png" />
		</aside>
		
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="">
				<h3>Report a bug</h3>
				<?php if(isset($error_message)){echo $error_message;} ?>
				<div class="field">
					<label for="name">Name:</label>
					<input type="text" class="input" id="float_right" name="name" maxlength="20" method="POST" placeholder="Name" />
					<p class="hint">Please enter your name so I know who reported the bug. Not mandatory! 20 characters max.</p>
				</div>
				<br><br><br>
				<div class="field">
					<label for="email">Email:</label>
					<input type="text" class="input" id="float_right" name="email" maxlength="80" method="POST" placeholder="you@domain.com"/>
					<p class="hint">Please enter your email so I can reply to your bugreport.</p>
				</div>
				<br><br><br>
				<div class="field">
					<label for="bug">Bug found:</label>
					<textarea type="text" class="input" name="bug" maxlength="5000" rows="10" method="POST" required>
					</textarea>
					<p class="hint">Please enter the bug you found. Be as detailed as possible: mention on what page you were and if paste an error if you got one.</p>
				</div>
				<br><br>
				<input type="submit" name="submit" class="button" method="POST" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>