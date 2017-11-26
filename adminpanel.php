<?php
session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");

if(isset($_GET['function'])){
	$function = $_GET['function'];
	switch($function){
		case 'commentCheck':
			$content = query($pdo, "SELECT * FROM content");
			foreach($content as $item){
				$content_id = $item['id'];
				$content_count = $item['comments'];
				$comment_search = query($pdo, "SELECT * FROM comments WHERE father_id = :content_id ", ['content_id' => $content_id]);
				$comment_count = count($comment_search);
				if($content_count != $comment_count){
					$content_update = query($pdo, "UPDATE content SET comments = :comment_count WHERE id= :id ", ['comment_count' => $comment_count, 'id' => $content_id]);
				}
			}
			break;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Adminpanel</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/prompt.css">
</head>
<body>
	<div id="wrapper">
	<?php headerAndSearchCode($pdo); ?>
		
		<div id="outer">
			<div id="inner">
				<a href="adminpanel.php?function=commentcheck">Check comments</a>
			</div>
		</div>
	
	<?php footerCode(); ?>
	</div>
</body>
</html>