<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_GET['email'])){
	$email = mysql_real_escape_string($_GET['email']);
}

if(isset($_GET['key']) && (strlen($_GET['key'])==32)){
	$key = mysql_real_escape_string($_GET['key']);
}

if(isset($email) && isset($key)){
	$result = query($pdo, " SELECT * FROM tempusers WHERE (email = :email AND activation = :key) LIMIT 1 ", ['email' => $email, 'key' => $key]);
	$user = $result[0];	
	$user_id = $pdo->quote($user['user_id']);
	$username = $pdo->quote($user['username']);
	$email = $pdo->quote($user['email']);
	$password = $pdo->quote($user['password']);
	
	$result1 = query($pdo, "INSERT INTO users (user_id, username, email, password) VALUES ('', :username, :email, :password)", ['username' => $username, 'email' => $email, 'password' => $password]);
	$result2 = query($pdo, "DELETE FROM tempusers WHERE username = :username ", ['username' => $username]);
	if(!$result1){
		header('Location:prompt.php?x=3');
	}else{
		$folder_create = mkdir('/home/a9862957/public_html/images/users/'.$username.'/');
		if($folder_create){
			header( 'Location:prompt.php?x=0' );
		}else{
			header('Location:prompt.php?x=3');
		}
	}
}else{
	header('Location:prompt.php?x=3');
}
?>