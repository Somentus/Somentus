<?php 

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

if(isset($_GET['id'])){
	$id = $_GET['id'];
	if(isset($_GET['father_id'])){
		$father_id = $_GET['father_id'];
		$owner_check = query($pdo, "SELECT * FROM comments WHERE id = :id AND user = :username ", ['id' => $id, 'username' => $_SESSION['username']]);
		if(count($owner_check) == 1){
			$comment_check = query($pdo, "SELECT * FROM content WHERE id = :father_id", ['father_id' => $father_id]);
			$content = $comment_check[0];
			$comments_before = $content['comments'];
			$comments_after = $comments_before - 1;
			// Like-counter for content: -1
			$comment_counter_delete = query($pdo,"UPDATE content SET comments = :comments_after WHERE id = :father_id ", ['comments_after' => $comments_after, 'father_id' => $father_id]);
			
			$content_check = query($pdo, "SELECT * FROM comments WHERE id = :id ", ['id' => $id]);
			$comment = $content_check[0];
			date_default_timezone_set('Europe/Amsterdam');
			$old_id = $comment['id'];
			$old_father_id = $comment['father_id'];
			$old_user = $comment['user'];
			$old_body = $comment['body'];
			$old_time = $comment['time'];
			$old_likes = $comment['likes'];
			$time_deleted = date("jS F, Y, G:i");
			$comment_delete_archive = query($pdo, "INSERT INTO comments_deleted (id, id_old, father_id, user, body, time, likes, time_deleted) VALUES ('', :old_id, :old_father_id, :old_user, :old_body, :old_time, :old_likes, :time_deleted) ", ['old_id' => $old_id, 'old_father_id' => $old_father_id, 'old_user' => $old_user, 'old_body' => $old_body, 'old_time' => $old_time, 'old_likes' => $old_likes, 'time_deleted' => $time_deleted]);

			$comment_delete = query($pdo, "DELETE FROM comments WHERE id = :id ", ['id' => $id]);
			$comment_counter_restate = query($pdo, "UPDATE content SET comments = :comments_before WHERE id = :father_id ", ['comments_before' => $comments_before, 'father_id' => $father_id]);
			header('Location:prompt.php?x=25');
		}else{
			header('Location:prompt.php?x=24');
		}
	}else{
		header('Location:prompt.php?x=3');
	}
}

?>