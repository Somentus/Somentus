<?php

function Register($pdo) {
	if(isset($_POST['submit'])){
		$error = array();
		
		//username
		if(empty($_POST['username'])){
			$error[] = 'Please enter a username. ';
		}else if( ctype_alnum($_POST['username']) ){
			$username = $_POST['username'];
		}else{
			$error[] = 'Username must consist of letters and numbers only. ';
		}
		
		//email
		if(empty($_POST['email'])){
			$error[] = 'Please enter your email. ';
		}else if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
			$email = $pdo->quote($_POST['email']);
		}else{
			$error[] = 'Your e-mail address is invalid. ';
		}
		
		//password
		if(empty($_POST['password'])){
			$error[] = 'Please enter a password. ';
		}else{
			$password = md5($pdo->quote($_POST['password']));
		}
		
		if(empty($error)){
			$result = query($pdo, "SELECT * FROM users WHERE email = :email OR username = :username ", ['email' => $email, 'username' => $username]);
			if(count($result)==0){
				$activation = md5(uniqid(rand(), true));
				$result2 = query($pdo, " INSERT INTO tempusers (user_id, username, email, password, activation) VALUES ('', :username, :email, :password, :activation) ", ['username' => $username, 'email' => $email, 'password' => $password, 'activation' => $activation]);
				if(!$result2){
					die('Could not insert into database: '.mysql_error());
				}else{
					$message = "To activate your account, please click on this link: \n\n";
					$message .= "http://somentus.nl".'/activate.php?email='.urlencode($email)."&key=$activation";
					mail($email, 'Registration Confirmation', $message);
					header('Location: prompt.php?x=1');
				}
			}else{
				$error[] = 'That email address or username has already been registered.';
			}
		}else{
			$error_message = '<span class="error">';
			foreach($error as $key => $values){
				$error_message.= "$values";
			}
			$error_message.="</span><br/><br/>";
		}
	}
}
?>