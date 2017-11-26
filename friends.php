<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}
	
function EchoFriends($pdo){
	$friend_requests = query($pdo, "SELECT * FROM friends_pending WHERE id_2 = :id_2 ", ['id_2' => $_SESSION['user_id']]);
	if (count($friend_requests) != 0 ) {
		echo 'Received requests: <br><br>';
		foreach($friend_requests as $friend_request) {
			$friend_echo = query($pdo, "SELECT * FROM users WHERE user_id = :id_1", ['id_1' => $friend_request['id_1']])[0];
			$_SESSION['id_1'] = $friend_echo['user_id'];
			echo $friend_echo['username']." <a href=\"add_friend.php?id_1=".$_SESSION['id_1']."\"><img src=\"images/check.gif\" /></a> <a href=\"decline_friend.php?id_1=".$_SESSION['id_1']."\"><img src=\"images/cross.gif\" /></a><br><br>" ;
		}
	}
	
	if (count($friend_requests) == 0 ) {
		echo "<b>You don't have any friendrequests.</b> <br><br>";
	}
	
	$pending_friend_requests = query($pdo, "SELECT * FROM friends_pending WHERE id_1 = :user_id ", ['user_id' => $_SESSION['user_id']]);
	if (count($pending_friend_requests) != 0 ) {
		echo 'Requests pending: <br><br>';
		foreach($pending_friend_requests as $pending_friend_request) {
			$friend_echo = query($pdo, "SELECT * FROM users WHERE user_id = :id_2 ", ['id_2' => $pending_friend_request['id_2']])[0];
			$_SESSION['id_2'] = $friend_echo['user_id'];
			echo $friend_echo['username']." </a> <a href=\"decline_friend.php?id_2=".$_SESSION['id_2']."\"><img src=\"images/cross.gif\" /></a><br><br>" ;
		}
	}
	
	if (count($pending_friend_requests) == 0 ) {
		echo "<b>You don't have any outgoing friendrequests.</b> <br><br>";
	}
}

function Friends($pdo){
	echo "<b>Friends:</b> <br><ul><br>";

	$id_1s = query($pdo, "SELECT id_1 FROM friends WHERE id_2 = :id_2", ['id_2' => $_SESSION['user_id']]);
	$id_2s = query($pdo, "SELECT id_2 FROM friends WHERE id_1 = :id_1", ['id_1' => $_SESSION['user_id']]);
	
	foreach($id_1s as $id_1) {
		$person = query($pdo, "SELECT username FROM users WHERE user_id = :id_1", ['id_1' => $id_1['id_1']])[0];
		$person_low_case = strtolower($person['username']);
		$keywords = $person_low_case;
		echo '<li><a class="right_side" href="user.php?keywords='.$keywords.'">'.$person['username'].'</a></li><br>';
	}
	foreach($id_2s as $id_2) {
		$person = query($pdo, "SELECT username FROM users WHERE user_id = :id_2", ['id_2' => $id_2['id_2']])[0];
		$person_low_case = strtolower($person['username']);
		$keywords = $person_low_case;
		echo '<li><a class="right_side" href="user.php?keywords='.$keywords.'">'.$person['username'].'</a></li><br>';
	}
	echo "</ul>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - Friends</title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/users.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<?php persons_left($pdo); ?>
		</aside>
		
		<section class="right_side">
			<div id="generalform">
				<?php EchoFriends($pdo); Friends($pdo); ?>
			</div>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>		