<?php 

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}


if(isset($_GET['id']) && isset($_GET['user'])){
	$id = $_GET['id'];
	$user = $_GET['user'];
	date_default_timezone_set('Europe/Amsterdam');
	$date = date("jS F, Y, G:i");  
	$content_get = query($pdo, "SELECT * FROM content WHERE id = :id ", ['id' => $id])[0];
	$likes_liketable_check = query($pdo, "SELECT * FROM likes WHERE user_id = :user_id AND content_id = :id ", ['user_id' => $_SESSION['user_id'], 'id' => $id]);
	if(count($likes_liketable_check) == 0){
		$likes_before = $content_get['likes'];
		$likes_after = $content_get['likes'] + 1;
		$likes_adjust = query($pdo, "UPDATE content SET likes = :likes_after WHERE id = :id ", ['likes_after' => $likes_after, 'id' => $id]);
		$likes_liketable_insert = query($pdo, "INSERT INTO likes (id, user_id, content_id, date) VALUES ('', :user_id, :id, :date) ", ['user_id' => $_SESSION['user_id'], 'id' => $id, 'date' => $date]);
		header('Location:user.php?keywords='.$user);
	}else{
		header('Location:prompt.php?x=23');
	}
}

else{
	header('Location:login.php');
}

?>