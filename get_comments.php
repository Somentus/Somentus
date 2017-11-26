<?php

include("includes/DB.php");
$pdo = DB();

if(isset($_GET['id_con'])){
	$id_con = $_GET['id_con'];
}

if(!empty($id_con)){
	$comments = query($pdo, "SELECT * FROM comments WHERE father_id = :id_con ORDER BY id desc", ['id_con' => $id_con]);
	$com_numrows = count($query);
	$i = 0;
	if($com_numrows > 0){
		foreach($comments as $comment) {
			$id = $comment['id'];
			$father_id = $comment['father_id'];
			$user = $comment['user'];
			$body = $comment['body'];
			$time = $comment['time'];
			$likes = $comment['likes'];
			echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."</div> <br><hr><br></div>";
			$i++;
			if($i == $com_numrows){
				echo "<input type=\"text\" id=\"textarea_comment_post\" onkeypress=\"if (window.event && window.event.keyCode == 13) {comment_post(".$father_id.");} else if (evn && evn.keyCode == 13) {comment_post(".$father_id.");}\" content=\"Write a comment...\" placeholder=\"Write a comment...\">";
//				echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."<div class=\"like_allign\" >Like</div></div> <br><hr><br></div>";
			}
		}
	}
}

//echo "<input type=\"text\" id=\"textarea_comment_post\" onkeypress=\"if (window.event && window.event.keyCode == 13) {comment_post(".$father_id.");} else if (evn && evn.keyCode == 13) {comment_post(".$father_id.");}\" content=\"Write a comment...\" placeholder=\"Write a comment...\">";

?>
