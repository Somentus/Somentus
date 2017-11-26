<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

if(isset($_POST['pagecreate'])){
	$error = array();
	if(isset($_POST['pagename'])){
		if(!empty($_POST['pagename'])){
			$pagename = $_POST['pagename'];
			$page_check = query($pdo, "SELECT * FROM pages WHERE name=pagename ", ['pagename' => $pagename]);
			if(count($page_check) == 0){
				$page_result = query($pdo, "INSERT INTO pages (id, name, admin) VALUES ('', :pagename, :username) ", ['pagename' => $pagename, 'username' => $_SESSION['username']]);
				if(!$page_result){
					header('Location:prompt.php?x=3');
				}else{
					header('Location:prompt.php?x=20');
				}
			}else{
				$error[] = "This page already exists.";
			}
		}else{
			$error[] = "Please enter the name of the page you want to create";
		}
	}else{
		$error[] = "Please enter the name of the page you want to create";
		$error_message = '<span class="error">';
		foreach($error as $key => $values){
			$error_message.= "$values";
		}
		$error_message.="</span><br/><br/>";
	}
}

/*function PageCheck(){
	$pagecheck = mysql_query("SELECT * FROM pages WHERE admin='$_SESSION[username]' ") or die(mysql_error());
	if(mysql_num_rows($pagecheck) == 0 ){
		echo "<form id=\"generalform\" class=\"container\" method=\"post\" action=\"\">
				<h3>Create page</h3>
				<?php echo $error_message; ?>
				<div class=\"field\">
					<label for=\"pagename\">Name of the page:</label>
					<input type=\"text\" class=\"input\" id=\"pagename\" name=\"pagename\" maxlength=\"50\" placeholder=\"Name of the page\" />
					<p class=\"hint\">50 characters maximum</p>
				</div>
				<input type=\"submit\" name=\"pagecreate\" id=\"submit\" class=\"button\" value=\"Submit\"/>
			</form>";
	}else{
		echo "<form id=\"generalform\" method=\"POST\" action=\"\">
				<h3>Post content for your page</h3>
				<div class=\"field\">
				<textarea type=\"text\" class=\"input\" id=\"content\" name=\"content\" maxlength=\"5000\" rows=\"10\" required ></textarea>
				</div>
				<input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button\" value=\"Submit\"/>
			</form>"; // H3 nog aanpassen met $_SESSION['pagename'] OFZO!
	}
}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Create Page</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/register.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside id="left_side">
			<img src="images/registerbanner.png" />
		</aside>
		
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="">
				<h3>Create page</h3>
				<?php echo $error_message; ?>
				<div class="field">
					<label for="pagename">Name of the page:</label>
					<input type="text" class="input" id="pagename" name="pagename" maxlength="50" placeholder="Name of the page" />
					<p class="hint">50 characters maximum</p>
				</div>
				<input type="submit" name="pagecreate" id="submit" class="button" value="Submit"/>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>