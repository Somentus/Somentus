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
	$result1 = query($pdo, "DELETE FROM friends_pending WHERE id_1 = :id_1 AND id_2 = :id_2 ", ['id_1' => $id_1, 'id_2' => $_SESSION['user_id']]);
	if($result1){
		header('Location:prompt.php?x=21');
	}
}

if(isset($_GET['id_2'])){
	$id_2 = $_GET['id_2'];
	$result1 = query($pdo, "DELETE FROM friends_pending WHERE id_1 = id_1 AND id_2 = :id_2 ", ['id_1' => $_SESSION['user_id'], 'id_2' => $id_2]);	
	if($result1){
		header('Location:prompt.php?x=22');
	}
}
else{
	header('Location:login.php');
}

?>