<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(isset($_GET['body']) && !empty($_GET['body'])){
	$com_body = $_GET['body'];
}

if(isset($_GET['father_id']) && !empty($_GET['father_id'])){
	$com_father_id = $_GET['father_id'];
}

if(!empty($com_body) && !empty($com_father_id)){
	date_default_timezone_set('Europe/Amsterdam');
	$com_date = date("jS F, Y, G:i"); 
	$comment_post_1 = query($pdo, "INSERT INTO comments (id, father_id, user, body, time, likes) VALUES ('', :com_father_id, :username, :com_body, :com_date, '0') ", ['com_father_id' => $com_father_id, 'username' => $_SESSION['username'], 'com_body' => $com_body, 'com_date' => $com_date]);
	$comment_number_get = query($pdo, "SELECT * FROM content WHERE id= :com_father_id ", ['com_father_id' => $com_father_id]);
	$content = $comment_number_get[0];
	$username = $content['name'];
	$comments_before = $content['comments'];
	$comments_after = $content['comments'] + 1;
	$comment_update = query($pdo, "UPDATE content SET comments = :comments_after WHERE id = :com_father_id ", ['comments_after' => $comments_after, 'com_father_id' => $com_father_id]);
	if($comment_update){
		echo "<br>Your comment was posted!";
	}
}

?>