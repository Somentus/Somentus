<?php 

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

if(isset($_GET['id_1']) && isset($_GET['id_2'])){
	header('Location:prompt.php?x=3');
}

if(isset($_GET['id_1'])){
	$id_1 = $_GET['id_1'];
	$result1 = query($pdo, "INSERT INTO friends (id, id_1, id_2) VALUES ('', :id_1, :user_id) ", ['id_1' => $id_1, 'user_id' => $_SESSION[user_id]]);
	if(!$result1){
		header('Location:prompt.php?x=3');
	}
	$result2 = query($pdo, "DELETE FROM friends_pending WHERE id_1 = :id_1 AND id_2 = :user_id", ['id_1' => $id_1, 'user_id' => $_SESSION[user_id]]);
	header('Location:prompt.php?x=20');
}

if(isset($_GET['id_2'])){
	$id_1 = $_GET['id_2'];
	$result1 = query($pdo, "INSERT INTO friends (id, id_1, id_2) VALUES ('', :user_id, :id_2) ", ['user_id' => $_SESSION[user_id], 'id_2' => $id_2]);
	if(!$result1){
		header('Location:prompt.php?x=3');
	}
	$result2 = query($pdo, "DELETE FROM friends_pending WHERE id_1 = :user_id AND id_2 = :id_2", ['user_id' => $_SESSION[user_id], 'id_2' => $id_2]);
	header('Location:prompt.php?x=20');
}
else{
	header('Location:login.php');
}


?>