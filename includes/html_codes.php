<?php

error_reporting(E_ALL);

//Code for Header and Search Bar
function Head(){
	echo "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"/images/favicon.ico\">";
}

function headerAndSearchCode($pdo){
	if(isset($_SESSION['keywords'])){
		$defaultText = htmlentities($_SESSION['keywords']);
	}else{
		$defaultText = '';
	}
	echo '
		<header id="main_header">
			<div id="rightAlign">
	';
	topRightLinks();
	echo "
			</div>";
	if( isset( $_SESSION['user_id'] ) && !empty( $_SESSION['user_id'] ) ){
		echo "<a href=\"account.php\"><img src=\"images/mainLogo.png\"></a>";
	}else{
		echo "<a href=\"index.php\"><img src=\"images/mainLogo.png\"></a>";
	}
	echo "</header>
		
		<div id=\"top_search\">
			<form name=\"input\" action=\"user.php\" method=\"POST\">
				<input type=\"text\" name=\"keywords\" size=\"124\" class=\"searchBox\" value=\"$defaultText\" placeholder=\"Search\" > &nbsp;
				<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Search\" class=\"button\" style=\"margin-right: 2px\"/>
			</form>
		</div>
	";
	ExistanceCheck($pdo);
	date_default_timezone_set('Europe/Amsterdam');
}

function login($pdo){
	if(isset($_POST['submit'])){
		$error = array();
		
		//username
		if(empty($_POST['username'])){
			$error[] = 'Please enter a username. ';
		}else if( ctype_alnum($_POST['username']) ){
			$username = $_POST['username'];
		}else{
			$error[] = 'Username must consist of letters and numbers only. ';
		}
		
		//password
		if(empty($_POST['password'])){
			$error[] = 'Please enter a password. ';
		}else{
			$password = $_POST['password'];
			// $password = md5($pdo->quote($_POST['password']));
		}
		var_dump($username);
		var_dump($password);
		
		if(empty($error)){
			$result = query($pdo, "SELECT * FROM users WHERE username=:username AND password=:password ", ['username' => $username, 'password' => $password]);
			var_dump($result);
			if(count($result)==1){
				$user = $result[0];
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['username'] = $user['username'];
				if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
					header('Location:account.php');
				}
			} else {
				$error_message = '<span class="error">Username or password is incorrect.</span><br /><br />';
			}
		} else {
			$error_message = '<span class="error">';
			foreach($error as $key => $values){
				$error_message.= "$values";
			}
			$error_message.="</span><br/><br/>";
		}
	}
}

// Actionfunction: does the person you searched for actually exist?
function ExistanceCheck($pdo){
	if (isset($_POST['submit'])){	
		if (isset($_POST['keywords'])){
			$_SESSION['keywords'] = $_POST['keywords'];
			$existance_check = query($pdo, "SELECT * FROM users WHERE username = :username ", ['username' => $_SESSION[keywords]]);
			if (count($existance_check) == 0){
				header('Location:prompt.php?x=10');
			}else{
				header('Location:user.php?keywords='.$_SESSION['keywords']);
			}
		}
	}
}

//Top Right Links
function topRightLinks(){
	echo '<div class="topLinks" >';
	if( !isset($_SESSION['user_id']) ){
		echo '<ul>
						<li><a href="recover.php">Forgot login?</a></li>
						<li><a href="register.php">Register</a></li>
						<li><a href="login.php">Log In</a></li>
					</ul>';
	}else{
		echo '<ul>
						<li><a href="friends.php">Friends</a></li>
						<li><a href="users.php">Users</a></li>
						<li><a href="profile.php">Profile</a></li>
						<li><a href="account.php">Post content</a></li>
						<li><a href="logout.php">Log Out</a></li>
					</ul>';
	}
	echo '</div>';
	// FUNCTION THAT SHOWS AMOUNT OF PENDING SENT FRIENDREQUESTS
	/*}else{
		$friendrequests_pending = query($pdo, "SELECT * FROM friends_pending WHERE id_1='$_SESSION[user_id]' ") or die(mysql_error());
		$friendrequests_pending_numrows = mysql_num_rows($friendrequests_pending) or die(mysql_error());
		if($friendrequests_pending_numrows != 0){
			echo '<a href="friends.php">Friends ('.$friendrequests_pending_numrows.')</a> | <a href="users.php">Users</a> | <a href="profile.php">Profile</a> | 
			<a href="account.php">My Account</a> | <a href="logout.php">Log Out</a>';
		}else{
			echo '<a href="friends.php">Friends</a> | <a href="users.php">Users</a> | <a href="profile.php">Profile</a> | <a href="account.php">My Account</a> | <a href="logout.php">Log Out</a>';
		}
	}*/
}

//Creates Category <option>'s for search bar
function createCategoryList(){
	if( ctype_digit($_POST['category']) ){ 
		$x = $_POST['category']; 
	}else{ $x = 999; }
	echo "<option>All Categories</option>";
	$i=0;
	while(1){
		if(numberToCategory($i)=="Category Does Not Exist"){
			break;
		}else{
			echo " <option value=\"$i\" ";
			if($i==$x){echo ' SELECTED ';}
			echo " > ";
			echo numberToCategory($i);
			echo "</option>";
		}
		$i++;
	}
}

//Category Number to String
function numberToCategory($n){
	switch($n){
	case 0:
        $cat = "All";
        break;
	case 1:
		$cat = "Friends";
		break;
	case 2:
		$cat = "Friends of friends";
	default:
        $cat = "Category Does Not Exist";
	}
	
	return $cat;
}

// Code for Add content-section
/*function AddContent(){
	if(empty($_POST['content'])){
		$error[] = 'Please enter content. ';
	}else{
		$content = $_POST['content'];
	}
	
	if(empty($error)){
		$result = query($pdo, " INSERT INTO content (id, name, content) VALUES ('', '$_SESSION[username]', '$content') ") or die(mysql_error());
		if(!$result){
			die('Could not insert into database: '.mysql_error());
		}else{
			header('Location: prompt.php?x=6');
		}
	}else{
		$error_message = '<span class="error">';
		foreach($error as $key => $values){
			$error_message.= "$values";
		}
		$error_message.="</span><br/><br/>";
	}
}*/

// Funtion for friends in the left_section
function persons_Left($pdo){
	echo "<ul id=\"left_side\">";

	$id_1 = query($pdo, "SELECT id_1 FROM friends WHERE id_2 = :user_id ", ['user_id' => $_SESSION['user_id']]);
	$id_2 = query($pdo, "SELECT id_2 FROM friends WHERE id_1 = :user_id ", ['user_id' => $_SESSION['user_id']]);

	if(count($id_1) == 0 && count($id_2) == 0){
		echo '<li id="left_item"><a href="users.php">You don\'t have friends yet. Check the userlist to make some friends!</a></li>';
	}else{
		foreach($id_1 as $friend) {
			$friend = query($pdo, "SELECT username FROM users WHERE user_id = :friend_id ", ['friend_id' => $friend['id_1']])[0];
			$friend_username_lowercase = strtolower($friend['username']);
			$keywords = $friend_username_lowercase;
			echo '<li id="left_item"><a href="user.php?keywords='.$keywords.'">'.$friend['username'].'</a></li><br>';
		}
		
		foreach($id_2 as $friend) {
			$friend = query($pdo, "SELECT username FROM users WHERE user_id = :friend_id ", ['friend_id' => $friend['id_2']])[0];
			$friend_username_lowercase = strtolower($friend['username']);
			$keywords = $friend_username_lowercase;
			echo '<li id="left_item"><a href="user.php?keywords='.$keywords.'">'.$friend['username'].'</a></li><br>';
		}
		/*while ($row = mysql_fetch_object($id_1)) {
			$person = mysql_fetch_object(query($pdo, "SELECT username FROM users WHERE user_id=$row->id_1")) or die(mysql_error());
			$person_low_case = strtolower($person->username);
			$keywords = $person_low_case;
			echo '<li id="left_item"><a href="user.php?keywords=$person->username">$person->username</a></li><br>';
		}*/
	}
	
	/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if(empty($person)){
		echo '<li><a href="user.php?keywords=$!!!!!!!!!!!!!!!!!!!!!"></a></li><br>';
	}
*/
	echo '</ul>';
}

function hit_count(){
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_file = file('/home/a9862957/public_html/ip.txt');
	foreach($ip_file as $ip){
		$ip_single = trim($ip);
		if($ip_address==$ip_single){
			$found = true;
			break;
		}else{
			$found = false;
		}
	}
	
	if ($found==false){
		$filename = '/home/a9862957/public_html/count.txt';
		$handle = fopen($filename, 'r');
		$current = fread($handle, filesize($filename));
		fclose($handle);
		
		$current_inc = $current +1;
		
		$handle = fopen($filename, 'w');
		fwrite($handle, $current_inc);
		fclose($handle);
		
		$handle = fopen('/home/a9862957/public_html/ip.txt', 'a');
		fwrite($handle, $ip_address."\n");
		fclose($handle);
	}
}

//code for footer <td><a href="bugs.php">Report a bug!</a></td>
function footerCode(){
	echo '
		<footer id="main_footer">
			<table>
				<tr>
					<td id="main_footer_2_cells" >
						This website is still under construction. 
					</td>
					<td id="main_footer_2_cells" >
						<a href="bugs.php">Report a bug!</a>
					</td>
			</table>
		<footer>';
	// hit_count();
}
?>