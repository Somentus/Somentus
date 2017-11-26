<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if (isset($_GET['keywords']) && !empty($_GET['keywords'])){
	$_SESSION['keywords'] = $_GET['keywords'];
	$existance_check = query($pdo, "SELECT * FROM users WHERE username = :keywords ", ['keywords' => $_SESSION['keywords']]);
	if ( count($existance_check) == 0){
		$_SESSION['keywords'] = '';
		header('Location:prompt.php?x=10');
	}
}

if(!isset($_GET['keywords'])){
	header('Location:login.php');
}

//if(!isset($_SESSION['user_id']) OR !isset($_SESSION['keywords']) ){
if(!isset($_SESSION['user_id'])){
	header('Location:login.php'); // Indien ingelogd word je doorgestuurd naar account.php
}

function AddFriendButton($pdo){
	if($_SESSION['username'] != $_SESSION['keywords']){
		$friend = query($pdo, "SELECT * FROM users WHERE username = :keywords ", ['keywords' => $_SESSION['keywords']])[0];
		$friendship_check_1 = query($pdo, "SELECT * FROM friends WHERE id_1 = :friend_user_id AND id_2 = :user_id ", ['friend_user_id' => $friend['user_id'],'user_id' => $_SESSION['user_id']]);
		$friendship_check_2 = query($pdo, "SELECT * FROM friends WHERE id_2 = :friend_user_id AND id_1 = :user_id ", ['friend_user_id' => $friend['user_id'],'user_id' => $_SESSION['user_id']]);
		$friendship_check_1_pending = query($pdo, "SELECT * FROM friends_pending WHERE id_1 = :friend_user_id AND id_2 = :user_id ", ['friend_user_id' => $friend['user_id'],'user_id' => $_SESSION['user_id']]);
		$friendship_check_2_pending = query($pdo, "SELECT * FROM friends WHERE id_2 = :friend_user_id AND id_1 = :user_id ", ['friend_user_id' => $friend['user_id'],'user_id' => $_SESSION['user_id']]);
		if(count($friendship_check_1) == 0 && count($friendship_check_2) == 0 && count($friendship_check_1_pending) == 0 && count($friendship_check_2_pending) == 0){
			$friend_1 = query($pdo, "SELECT * FROM users WHERE username = :keywords ", ['keywords' => $_SESSION['keywords']])[0];
			echo "<form action=\"\" method=\"POST\"><input type=\"submit\" name=\"addfriend\" value=\"Add friend!\" class=\"button\" /></form>";
			if(isset($_POST['addfriend'])){
				$friendship = query($pdo, "INSERT INTO friends_pending (id, id_1, id_2) VALUES ('', :user_id, :friend_1_user_id) ", ['user_id' => $_SESSION['user_id'], 'friend_1_user_id' => $friend_1['user_id']]);
				$_SESSION['friend_name'] = $_SESSION['keywords'];
				header('Location:prompt.php?x=8');	
			}
		}
	}
}

function LikeCheck($cont_id) {
	$likes_liketable_check = query($pdo, "SELECT * FROM likes WHERE user_id = :user_id AND content_id = :cont_id ", ['user_id' => $_SESSION['user_id'], 'cont_id' => $cont_id]);
	if(count($likes_liketable_check) == 0){
		$_SESSION['likecheck'] = true;
	}else{
		$_SESSION['likecheck'] = false;
	}
}

function EchoContent($pdo) {
	$content_body_raw = query($pdo, "SELECT * FROM content WHERE name = :keywords ORDER BY id DESC ", ['keywords' => $_SESSION['keywords']]);
	foreach($content_body_raw as $content) {
		$content_body = $content['body'];
		$date = $content['date'];
		$likes = $content['likes'];
		$cont_id = $content['id'];
		$number_of_comments = $content['comments'];
		$user = $_SESSION['keywords'];
		echo "<br>".$content_body."<br><br>";
		$content_get = query($pdo, "SELECT * FROM content WHERE id = :cont_id ", ['cont_id' => $cont_id]);
		$likes_liketable_check = query($pdo, "SELECT * FROM likes WHERE user_id = :user_id AND content_id = :cont_id ", ['user_id' => $_SESSION['user_id'], 'cont_id' => $cont_id]);
		if(count($likes_liketable_check) == 0){
			$likecheck = true;
		}else{
			$likecheck = false;
		}
		if($likecheck == true){	
			$like_status =  "<a class=\"likecomment_1\" href=\"like.php?id=".$cont_id."&user=".$user."\">Like</a>";
		}else if($likecheck == false){
			$like_status =  "<a class=\"likecomment_1\" href=\"unlike.php?id=".$cont_id."&user=".$user."\">Unlike</a>";
		}
		echo "<div id=\"likecomment\" >".$like_status." - ".$likes." likes - <a onclick=\"toggle('comments_paste".$cont_id."');\" >".$number_of_comments;
		if($number_of_comments == 1){
			echo " comment</a>";
		}else{
			echo " comments</a>";
		}
		if(isset($date) && !empty($date)){
			echo " - ".$date;
		}
		echo "</div><div class=\"comments_paste\" id=\"comments_paste".$cont_id."\" style=\"display:none; width:400px; \">";
		$comments = query($pdo, "SELECT * FROM comments WHERE father_id = :cont_id ORDER BY id desc", ['cont_id' => $cont_id]);
		foreach($comments as $comment) {
			$id = $comment['id'];
			$father_id = $cont_id;
			$user = $comment['user'];
			$body = $comment['body'];
			$time = $comment['time'];
			$likes = $comment['likes'];
			if($user == $_SESSION['username']){
				echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."&nbsp<a href=\"delete.php?id=".$id."&father_id=".$father_id."\">X</a><br><hr><br></div>";
				// echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."</div><a href=\"delete.php?id=".$id."&father_id=".$father_id."\">X</a>";
			}else{
				echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."</div><hr><br></div>";
			}
//			echo "<div ><a href=\"user.php?keywords=".$user."\">".$user."</a>&nbsp;&nbsp;".$body." <br><div id=\"date_paste\">".$time."<div class=\"like_allign\" >Like</div></div> <br><hr><br></div>";
		}
		echo "<input onkeypress=\"if (window.event && window.event.keyCode == 13) {comment_post(".$cont_id.");} else if (evn && evn.keyCode == 13) {comment_post(".$cont_id.");}\" type=\"text\" name=\"textarea_comment_post\" id=\"textarea_comment_post\" content=\"Write a comment...\" placeholder=\"Write a comment...\">";		
		echo "<div id=\"test_message\"></div>";
		echo "</div>";
		echo "<br><br><hr>";
	}
	if (count($content_body_raw) == 0 ) {
		echo "This user did not post content.";
	}
}

function UserPF(){
	$pf_existance = 0; 
	$extension = array('jpeg','png','gif', 'jpg');
	foreach($extension as $ext){
		$pf_filename = 'images/users/'.$_SESSION['keywords'].'/'.$_SESSION['keywords'].'_pf.'.$ext;
		if(file_exists($pf_filename)){
			$imgtag = '<img src="'.$pf_filename.'" width="200" height="200" />';
			echo $imgtag;
			$pf_existance = true;			
		}
	}
	if ($pf_existance == false){
		echo "<img src=\"/images/noprofile.png\" />";
	}
}

function UserContent($pdo){
	$user = query($pdo, "SELECT user_id FROM users WHERE username = :keywords ", ['keywords' => $_SESSION['keywords']])[0];
	$profile = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id", ['user_id' => $user['user_id']]);
	if(count($profile) == 1) {
		$profile = $profile[0];
		$birth_day = $profile['birth_day'];
		$birth_month = $profile['birth_month'];
		$birth_year = $profile['birth_year'];
		$city = $profile['city'];
		$country = $profile['country'];
	}
	if(!empty($birth_day) && !empty($birth_month) && !empty($birth_year)){
		echo 'Born on: '.$birth_day.' '.$birth_month.' '.$birth_year.'<br><br>';
	}else if(!empty($birth_day) && !empty($birth_month)){
		echo 'Born on: '.$birth_day.' '.$birth_month.'<br><br>';
	}else if(!empty($birth_month) && !empty($birth_year)){
		echo 'Born in: '.$birth_month.' '.$birth_year.'<br><br>';
	}else if(!empty($birth_year)){
		echo 'Born in: '.$birth_year.'<br><br>';
	}
	if(!empty($city) && !empty($country)){
		echo 'Location: '.$city.', '.$country.'<br><br>';
	}else if(!empty($city)){
		echo 'City: '.$city.'<br><br>';
	}else if(!empty($country)){
		echo 'Country: '.$country.'<br><br>';
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - <?php echo $_SESSION['keywords']; ?></title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/account.css">
	<link rel="stylesheet" href="../css/user.css">
	
	<script type="text/Javascript" >
	
	function toggle(d){
		var o=document.getElementById(d);
		o.style.display=(o.style.display=='none')?'block':'none';
	}
	
	function comment_post(father_id) {
		if(window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById('test_message').innerHTML = xmlhttp.responseText;
			}
		}
		
		xmlhttp.open('GET', 'comment_post.php?body='+document.getElementById('textarea_comment_post').value+'&father_id='+father_id, true);
		xmlhttp.send();
	}

	</script>
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<?php persons_left($pdo); ?>
		</aside>
		
		<section id="user_menu">
			<div id="right_left_side" >
				<?php UserPF(); ?>
			</div>
			<div id="right_right_side" >
				<?php UserContent($pdo); AddFriendButton($pdo); ?>
			</div>
		</section>
		<br>
		<section id="right_side">
			<?php EchoContent($pdo); ?>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>
